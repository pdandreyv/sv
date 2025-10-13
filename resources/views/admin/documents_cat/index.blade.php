@extends('layouts.app')

@section('content')

    @include('admin.parts.menu')

    <div class="col-md-9">
        <div class="title">
            <h3>Категории документов</h3>
        </div>
        <hr />
        <div class="btn-container">
            <a href="{{ route('admin.documents_cat.create') }}" class="btn btn-info btn-add">Добавить Категорию</a>
        </div>
        <hr />

        @php $i=0; $coun=1;
        @endphp
        @foreach ($documents_cat as $cat)
            @if ($i%4==0)
                <div class="row">
            @endif
            <div class="col-md-3 text-center" >
                <a href="{{route('admin.documents_cat.documents.index', $cat->id)}}">
                    <span style="color: #FFCC33;"><i class="fas fa-folder fa-5x"></i></span><br>
                    <span style="display: grid;">{{$cat->name}}</span></a><br>
                {{--<span>{{$cat->getRolesDisplay()}}</span>--}}

                <a href="{{ route('admin.documents_cat.edit', ['id' => $cat->id]) }}" class="btn btn-info btn-sm">
                    <span><i class="fas fa-edit"></i></span>
                </a>

                <a href="{{ route('admin.documents_cat.delete', ['id' => $cat->id]) }}" class="btn btn-danger btn-sm" onclick="var result = confirm('Вы действительно хотите удалить Категорию?'); if(!result) return false;">
                    <span><i class="fas fa-trash-alt"></i></span>
                </a>
            </div>
            @if ($i%4==3 || $coun == count($documents_cat))
                </div>
            @endif
            @php $i++; $coun++;
            @endphp
        @endforeach
        {{$documents_cat->links()}}

    </div>

@endsection