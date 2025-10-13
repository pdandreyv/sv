@foreach($posts as $post)
    <div class="panel panel-info post-item">
        <div class="panel-heading">
            <a href="{{ route('posts.post', ['post_id' => $post->post_id]) }}" title="{{ $post->post_title }}">
                <h3 class="post-title">{{ $post->post_title }}</h3>
            </a>
            @include('parts.post-control', ['post_id' => $post->post_id,'stick_on_top' => $post->stick_on_top])
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
                    {{ \Carbon\Carbon::parse($post->updated_at)->format('H:i d F Y')}}
                </div>
            </div>
        </div>
    </div>
@endforeach