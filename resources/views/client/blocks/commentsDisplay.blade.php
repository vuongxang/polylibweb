@foreach($comments as $comment)
    <div class="book-comment-body__detail" @if($comment->parent_id != null) style="margin-left:40px;" @endif>
        <div class="book-comment-body-detail__img">
            <img src="{{ asset($comment->user->avatar) }}" alt="" class="rounded-circle" width="40">
        </div>
        <div class="book-comment-body-detail__content">
            <div class="book-comment-body-detail__username">{{ $comment->user->name }}</div>
            <div class="book-comment-body-detail__date">{{ $comment->user->created_at }}</div>
            <div class="book-comment-body-detail__comment">{{ $comment->body }}</div>
        </div>
        <form method="post" action="{{ route('comments.store') }}">
            @csrf
            <div class="form-group">
                <input type=text name="body" class="form-control" hidden/>
                <input type=hidden name="book_id" value="{{ $book_id }}" />
                <input type=hidden name="parent_id" value="{{ $comment->id }}" />
            </div>
            <div class="form-group">
                <input type=submit class="btn btn-warning" value="Reply" />
            </div>
        </form>
    </div>
@endforeach

<div class="">
    
    
</div>