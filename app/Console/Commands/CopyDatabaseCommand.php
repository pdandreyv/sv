<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CopyDatabaseCommand extends Command
{
    protected $signature = 'db:copy 
        {--source=svetograd : Имя соединения-источника}
        {--target=sv : Имя соединения-приёмника}
        {--chunk=1000 : Размер чанка для вставки}
        {--truncate : Очищать таблицы цели перед копированием}
        {--fk-off : Принудительно отключить проверку FK в целевой БД}';

    protected $description = 'Копирование всех таблиц из одной БД в другую с учётом зависимостей (FK)';

    public function handle(): int
    {
        $sourceName = (string) $this->option('source');
        $targetName = (string) $this->option('target');
        $chunkSize  = (int) $this->option('chunk');

        $src = DB::connection($sourceName);
        $dst = DB::connection($targetName);

        // Имя БД (устойчиво к кэшу конфига):
        $srcDb = env('DB_OLD_DATABASE');
        $dstDb = env('DB_DATABASE');

        if (empty($srcDb) || empty($dstDb)) {
            $this->error('Не удалось определить имена БД. Проверьте .env и выполните: php artisan config:clear');
            $this->line('source: '.($srcDb ?: 'NULL').', target: '.($dstDb ?: 'NULL'));
            return self::FAILURE;
        }

        // Список таблиц-источника и цели (только общие)
        $srcTables = collect($src->select("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = ?", [$srcDb]))
            ->pluck('TABLE_NAME')
            ->reject(fn($t) => in_array($t, ['migrations']))
            ->values();
        $dstTables = collect($dst->select("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = ?", [$dstDb]))
            ->pluck('TABLE_NAME')
            ->values();
        $tables = $srcTables->intersect($dstTables)->values();

        if ($tables->isEmpty()) {
            $this->warn('Совпадающих таблиц не найдено.');
            return self::SUCCESS;
        }

        // Зависимости по FK: child -> parent
        $fkRows = collect($src->select(
            "SELECT TABLE_NAME, REFERENCED_TABLE_NAME 
             FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
             WHERE CONSTRAINT_SCHEMA = ? AND REFERENCED_TABLE_NAME IS NOT NULL",
            [$srcDb]
        ));

        $deps = [];
        foreach ($tables as $t) { $deps[$t] = []; }
        foreach ($fkRows as $row) {
            $child  = $row->TABLE_NAME;
            $parent = $row->REFERENCED_TABLE_NAME;
            if (isset($deps[$child]) && isset($deps[$parent]) && $child !== $parent) {
                $deps[$child][] = $parent;
            }
        }

        // Топологическая сортировка (Kahn)
        $order = $this->topoSort($deps);
        if (!$order) {
            $this->warn('Не удалось построить порядок по зависимостям, используем алфавитный порядок.');
            $order = $tables->sort()->values()->all();
        }

        // Отключаем FK в целевой БД
        $fkOff = (bool) $this->option('fk-off');
        if ($fkOff) {
            $dst->statement('SET FOREIGN_KEY_CHECKS=0');
        }

        foreach ($order as $table) {
            // Пересечение колонок
            $srcCols = collect($src->select(
                "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?",
                [$srcDb, $table]
            ))->pluck('COLUMN_NAME');
            $dstCols = collect($dst->select(
                "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?",
                [$dstDb, $table]
            ))->pluck('COLUMN_NAME');
            $columns = $srcCols->intersect($dstCols)->values();
            if ($columns->isEmpty()) {
                $this->line("[skip] {$table} — нет общих колонок");
                continue;
            }

            if ($this->option('truncate')) {
                $dst->statement("TRUNCATE TABLE `{$table}`");
            }

            $countRes = $src->select("SELECT COUNT(1) AS c FROM `{$table}`");
            $countRow = (int) ((is_array($countRes) ? ($countRes[0]->c ?? 0) : 0));
            $this->info("Копируем {$table} ({$countRow} записей)...");

            $offset = 0;
            $copied = 0;
            $colList = $columns->map(fn($c) => "`{$c}`")->implode(',');
            while ($offset < $countRow) {
                $rows = $src->select("SELECT {$colList} FROM `{$table}` LIMIT {$chunkSize} OFFSET {$offset}");
                if (empty($rows)) break;

                $batch = [];
                foreach ($rows as $r) {
                    $row = [];
                    foreach ($columns as $c) {
                        $row[$c] = $r->{$c} ?? null;
                    }
                    $batch[] = $row;
                }
                // Вставка пачкой
                $dst->table($table)->insert($batch);
                $copied += count($batch);
                $offset += $chunkSize;
                $this->line("  +{$copied}/{$countRow}");
            }
        }

        if ($fkOff) {
            $dst->statement('SET FOREIGN_KEY_CHECKS=1');
        }

        $this->info('Готово.');
        return self::SUCCESS;
    }

    private function topoSort(array $deps): array|null
    {
        // deps: node => [parents]
        $inDegree = [];
        $graph = [];
        foreach ($deps as $node => $parents) {
            $inDegree[$node] = $inDegree[$node] ?? 0;
            foreach ($parents as $p) {
                $graph[$p] = $graph[$p] ?? [];
                $graph[$p][] = $node;
                $inDegree[$node]++;
                $inDegree[$p] = $inDegree[$p] ?? 0;
            }
        }

        $queue = collect(array_keys($inDegree))->filter(fn($n) => $inDegree[$n] === 0)->values();
        $order = [];
        while ($queue->isNotEmpty()) {
            $n = $queue->shift();
            $order[] = $n;
            foreach ($graph[$n] ?? [] as $m) {
                $inDegree[$m]--;
                if ($inDegree[$m] === 0) {
                    $queue->push($m);
                }
            }
        }
        // если остались узлы с положительной степенью — цикл
        foreach ($inDegree as $d) {
            if ($d > 0) return null;
        }
        return $order;
    }
}


