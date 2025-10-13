@extends('layouts.app')

@section('content')

    @include('parts.sidebar')
    <div class="col-md-9">
        <div class="title">
            <h3>Новости</h3>
        </div>
        <hr>
        <div class="content">
            <div class="posts-list">
            @foreach($posts as $post)
                <div class="panel panel-info post-item">
                    <div class="panel-heading">
                        <h3 class="post-title">{{ $post->post_title }}</h3>
                    </div>
                    <div class="panel-body">
                        {!! $post->post_content !!}
                    </div>
                    <div class="panel-footer">
                        <div class="row">
                            <div class="post-author col-12 col-sm-12 col-md-6">
                                <h5>Автор:</h5>
                                <span>{{$post->user->fullName()}}</span>
                            </div>
                            <div class="post-date col-12 col-sm-12 col-md-6">
                                <h5>Обновлено:</h5>
                                {{ \Carbon\Carbon::parse($post->updated_at)->format('H:i d m Y')}}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            </div>
            <input type="hidden" id="offset" value={{count($posts)}}>
            <div>
                <input style="display: block; margin: auto;" type="button" class="btn btn-primary" value="Загрузить еще" id="loadMoreBtn"></button>
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#loadMoreBtn').on('click', function(e) {
                    var offset = $('#offset').val();
                    $.ajax({
                        url: '/newsAjax/'+offset,
                        type: 'get',
                        dataType: "html",
                        async: false,
                        success: function(data) {
                            $('.posts-list').append(data);
                            var newCount = $('.post-item').length;
                            if(newCount == offset) {
                                $('#loadMoreBtn').remove();
                            } else {
                                $('#offset').val(newCount)
                            }
                        }
                    });
                })
            })
        </script>
    </div>
@endsection