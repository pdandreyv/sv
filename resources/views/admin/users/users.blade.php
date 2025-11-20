@extends('layouts.app')

@section('content')

    @include('admin.parts.menu')

    <div class="col-md-9">
        <div class="d-flex justify-content-between align-items-center">
            <div class="title">
                <h3>Список пользователей</h3>
            </div>
            <a href="{{ route('admin.users.create') }}" class="btn btn-info btn-add">Добавить</a>
        </div>
        <hr />

        <form method="GET" action="{{ route('admin.users') }}" class="form-inline" style="gap:10px; flex-wrap: wrap; margin-bottom: 10px;">
            <input type="text" class="form-control" name="q" value="{{ request('q') }}" placeholder="Поиск: email, имя, фамилия, телефон">
            <input type="hidden" name="per_page" value="{{ request('per_page', 50) }}">
            <button type="submit" class="btn btn-default">Найти</button>
            <a href="{{ route('admin.users') }}" class="btn btn-default">Сброс</a>
        </form>

        @if($users->hasPages())
        <div class="d-flex justify-content-between align-items-center" style="margin-bottom: 10px;">
            <div class="pagination-container">
                @php
                    $lastPage = $users->lastPage();
                    $current = $users->currentPage();
                @endphp
                <ul class="pagination" style="margin:0; padding-left:0; list-style:none;">
                    <li style="display:inline-block; margin:2px;">
                        @if($users->onFirstPage())
                            <span style="display:inline-block; border:1px solid #ddd; padding:4px 8px; border-radius:4px; color:#999;"><i class="fas fa-chevron-left"></i></span>
                        @else
                            <a href="{{ $users->previousPageUrl() }}" style="display:inline-block; border:1px solid #ddd; padding:4px 8px; border-radius:4px;"><i class="fas fa-chevron-left"></i></a>
                        @endif
                    </li>
                    @for($i=1;$i<=$lastPage;$i++)
                        <li style="display:inline-block; margin:2px;">
                            @if($i === $current)
                                <span style="display:inline-block; border:1px solid #00a2ff; padding:4px 8px; border-radius:4px; background:#00a2ff; color:#fff;">{{ $i }}</span>
                            @else
                                <a href="{{ $users->url($i) }}" style="display:inline-block; border:1px solid #ddd; padding:4px 8px; border-radius:4px;">{{ $i }}</a>
                            @endif
                        </li>
                    @endfor
                    <li style="display:inline-block; margin:2px;">
                        @if($current >= $lastPage)
                            <span style="display:inline-block; border:1px solid #ddd; padding:4px 8px; border-radius:4px; color:#999;"><i class="fas fa-chevron-right"></i></span>
                        @else
                            <a href="{{ $users->nextPageUrl() }}" style="display:inline-block; border:1px solid #ddd; padding:4px 8px; border-radius:4px;"><i class="fas fa-chevron-right"></i></a>
                        @endif
                    </li>
                </ul>
            </div>
            <form method="GET" action="{{ route('admin.users') }}" class="form-inline">
                <input type="hidden" name="q" value="{{ request('q') }}">
                <input type="hidden" name="sort" value="{{ request('sort','id') }}">
                <input type="hidden" name="dir" value="{{ request('dir','desc') }}">
                <select name="per_page" class="form-control" style="width:auto; height:28px; padding:3px 6px;" onchange="this.form.submit()">
                    @foreach([20,50,100,500] as $pp)
                        <option value="{{ $pp }}" {{ (string)$pp === (string)request('per_page', 50) ? 'selected' : '' }}>{{ $pp }} на странице</option>
                    @endforeach
                </select>
            </form>
        </div>
        @endif

        <table class="table tproduct-table">
            <thead>
            <tr class="product-table-thead">
                @php
                    $currSort = request('sort','id');
                    $currDir = request('dir','desc');
                    function sort_link($col, $title) {
                        $isCurr = request('sort','id') === $col;
                        $nextDir = ($isCurr && request('dir','desc') === 'asc') ? 'desc' : 'asc';
                        $params = array_merge(request()->all(), ['sort'=>$col, 'dir'=>$nextDir]);
                        $icon = $isCurr ? (request('dir','desc')==='asc' ? '↑' : '↓') : '';
                        return '<a href="'.route('admin.users', $params).'">'.$title.' '.$icon.'</a>';
                    }
                @endphp
                <th>{!! sort_link('email','Логин') !!}</th>
                <th>{!! sort_link('name','Отображаемое имя') !!}</th>
                <th>Роли</th>
                <th style="width: 130px;">{!! sort_link('created_at','Создан') !!}</th>
                <th style="width: 130px;">Действия</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="client_info">
                        <td>
                            <span>{{$user->email}}</span>
                        </td>
                        <td>
                            <span>{{$user->name}}</span>
                        </td>
                        <td>
                            <span>{{$user->getRolesDisplay()}}</span>
                        </td>
                        <td><span>{{ optional($user->created_at)->format('Y-m-d') }}</span></td>
                        <td class="text-right" style="white-space: nowrap; width: 130px;">
                            <div class="btn-group btn-group-sm" role="group" style="white-space: nowrap;">
                            <a href="{{ route('admin.users.update', ['id' => $user->id]) }}" class="btn btn-info btn-sm">
                                <span><i class="fas fa-edit"></i></span>
                            </a>
                            <a href="{{ route('admin.users.delete', ['id' => $user->id]) }}" class="btn btn-danger btn-sm" onclick="var result = confirm('Вы действительно хотите удалить пользователя?'); if(!result) return false;">
                                <span><i class="fas fa-trash-alt"></i></span>
                            </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @if($users->hasPages())
        <div class="d-flex justify-content-between align-items-center" style="margin-top: 10px;">
            <div class="pagination-container">
                @php
                    $lastPage = $users->lastPage();
                    $current = $users->currentPage();
                @endphp
                <ul class="pagination" style="margin:0; padding-left:0; list-style:none;">
                    <li style="display:inline-block; margin:2px;">
                        @if($users->onFirstPage())
                            <span style="display:inline-block; border:1px solid #ddd; padding:4px 8px; border-radius:4px; color:#999;"><i class="fas fa-chevron-left"></i></span>
                        @else
                            <a href="{{ $users->previousPageUrl() }}" style="display:inline-block; border:1px solid #ddd; padding:4px 8px; border-radius:4px;"><i class="fas fa-chevron-left"></i></a>
                        @endif
                    </li>
                    @for($i=1;$i<=$lastPage;$i++)
                        <li style="display:inline-block; margin:2px;">
                            @if($i === $current)
                                <span style="display:inline-block; border:1px solid #00a2ff; padding:4px 8px; border-radius:4px; background:#00a2ff; color:#fff;">{{ $i }}</span>
                            @else
                                <a href="{{ $users->url($i) }}" style="display:inline-block; border:1px solid #ddd; padding:4px 8px; border-radius:4px;">{{ $i }}</a>
                            @endif
                        </li>
                    @endfor
                    <li style="display:inline-block; margin:2px;">
                        @if($current >= $lastPage)
                            <span style="display:inline-block; border:1px solid #ddd; padding:4px 8px; border-radius:4px; color:#999;"><i class="fas fa-chevron-right"></i></span>
                        @else
                            <a href="{{ $users->nextPageUrl() }}" style="display:inline-block; border:1px solid #ddd; padding:4px 8px; border-radius:4px;"><i class="fas fa-chevron-right"></i></a>
                        @endif
                    </li>
                </ul>
            </div>
            <form method="GET" action="{{ route('admin.users') }}" class="form-inline">
                <input type="hidden" name="q" value="{{ request('q') }}">
                <input type="hidden" name="sort" value="{{ request('sort','id') }}">
                <input type="hidden" name="dir" value="{{ request('dir','desc') }}">
                <select name="per_page" class="form-control" style="width:auto; height:28px; padding:3px 6px;" onchange="this.form.submit()">
                    @foreach([20,50,100,500] as $pp)
                        <option value="{{ $pp }}" {{ (string)$pp === (string)request('per_page', 50) ? 'selected' : '' }}>{{ $pp }} на странице</option>
                    @endforeach
                </select>
            </form>
        </div>
        @endif

    </div>

@endsection