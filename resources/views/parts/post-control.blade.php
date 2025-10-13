<div class="post-control pull-right row">
    <a href="{{ route('posts.edit', ['post_id' => $post->post_id]) }}" title="Редактировать Запись">
        <span><i class="fas fa-edit"></i></span>
    </a>
    <a href="{{ route('posts.delete', ['post_id' => $post->post_id]) }}" onclick='return confirm("Вы действительно хотите удалить запись?")' title="Удалить запись">
        <span><i class="fas fa-trash-alt"></i></span>
    </a>
    @if($post->stick_on_top)
        <a href="#" class="sticky-post" title="Запись закреплена">
            <span><i class="far fa-sticky-note"></i></span>
        </a>
    @endif
</div>