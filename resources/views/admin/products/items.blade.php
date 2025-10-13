@if ($products->count() > 0)
    <table class="table tproduct-table">
        <thead>
            <tr class="product-table-thead">
                <th>Название</th>
                <th>Цена</th>
                <th>Кооп цена</th>
                <th>Категория</th>
                <th>Автор</th>
                <th>Одобрено</th>
                <th>{{-- Инструменты --}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                @if (!$service)
                    @if ( $product->is_service )
                        @continue
                    @endif
                @else
                    @if ( (!$product->is_service) )
                        @continue
                    @endif
                @endif
                <tr>
                    <td>
                        {{$product->title}}
                    </td>
                    <td>
                        {{$product->price}}
                    </td>
                    <td>
                        {{$product->cooperative_price}}
                    </td>
                    <td>
                        {{$product->category?$product->category->title:''}}
                    </td>
                    <td>
                        {{$product->user ? $product->user->name : ''}}
                    </td>
                    <td>
                        @if ( (isset($product->is_confirmed)) && ($product->is_confirmed =='1'))
                            <span class="approve text-success" title="Одобрено"><i class="fas fa-check"></i></span>
                        @else
                            <span class="not-approve text-danger" title="Не одобрено"><i class="fas fa-times"></i></span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.products.update', ['id' => $product->id]) }}" title="Редактировать" class="btn btn-info btn-sm">
                            <span><i class="fas fa-edit"></i></span>
                        </a>
                        <a href="{{ route('admin.products.delete', ['id' => $product->id]) }}" class="btn btn-danger btn-sm" onclick="var result = confirm('Вы действительно хотите удалить продукт?'); if(!result) return false;" title="Удалить">
                            <span><i class="fas fa-trash-alt"></i></span>
                        </a>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <div>
        <span>Ой! Похоже, что в магазине ещё нет товаров или услуг.</span>
    </div>
@endif