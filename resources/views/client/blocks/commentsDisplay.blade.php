@foreach ($comments as $comment)
@if($comment->parent_id == null)
<div class="book-user-comment">
    <div class="comment-box__image">
        <img src="{{ asset($comment->user->avatar) }}" alt="">
    </div>
    <div class="book-user-comment__body js-comment-body">
        <div class="book-user-comment__heading">
            <div class="book-user-comment__name">{{ $comment->user->name }}</div>
            <div class="book-user-comment__content">{{ $comment->body }}</div>
        </div>
        <div class="book-user-comment__footer">
            <div class="book-user-comment__link"><a href="javascript:void(0);" class="js-comment-reply" id="js-comment-reply-{{$comment->id}}" >Trả lời</a></div>
            <div class="book-user-comment__date">{{Carbon\Carbon::parse($comment->created_at)->diffForHumans()}}</div>
        </div>
        @foreach ($comments as $commentChild)
        @if ($commentChild->parent_id != null && $commentChild->parent_id == $comment->id)
        
        <div class="book-user-comment">
            <div class="comment-box__image">
                <img src="{{ asset($comment->user->avatar) }}" alt="">
            </div>
            <div class="book-user-comment__body">
                <div class="book-user-comment__heading">
                    <div class="book-user-comment__name">{{ $commentChild->user->name }}</div>
                    <div class="book-user-comment__content">{{ $commentChild->body }}</div>
                </div>
                <div class="book-user-comment__footer">
                <div class="book-user-comment__link"><a href="javascript:void(0);" class="js-comment-reply-child" >Trả lời</a></div>
                    <div class="book-user-comment__date">{{Carbon\Carbon::parse($commentChild->created_at)->diffForHumans()}}</div>
                </div>
            </div>
        </div>
        @endif
        @endforeach
        <div class="comment-box__wrapper comment-box__hidden">
            <div class="comment-box__image">
                <img src="{{Auth::user()->avatar}}" alt="">
            </div>
            <div class="comment-box__content">
                <form action="{{ route('comments.store') }}" method="post">
                    @csrf
                    <div class="comment__input">
                        <input type="text" name="body" placeholder="Viết bình luận..." id= "js-reply-input-{{$comment->id}}">
                        <input type=hidden name="book_id" value="{{ $book_id }}" />
                        <input type=hidden name="parent_id" value="{{ $comment->id }}" />
                    </div>
                    <div class="comment__btn">
                        <button type="submit" class="button button__background-lg button-comment">Bình luận</button>
                        <button type="button" class="button button__background-lg button-cancel">Hủy</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

</div>
@endif
@endforeach

<!-- 
@foreach ($comments as $comment)
<div class="book-comment-body__detail" @if ($comment->parent_id != null) style="margin-left:40px;" @endif>
    <div class="book-comment-body-detail__img">
        <img src="{{ asset($comment->user->avatar) }}" alt="" class="rounded-circle" width="40">
    </div>
    <div class="book-comment-body-detail__content">
        <div class="book-comment-body-detail__username">{{ $comment->user->name }}</div>
        <div class="book-comment-body-detail__date">{{ $comment->user->created_at }}</div>
        <div class="book-comment-body-detail__comment">{{ $comment->body }}</div>
    </div>
    <div>
        <form method="post" action="{{ route('comments.store') }}">
            @csrf
            <div class="form-group">
                <input type=text name="body" class="form-control" />
                <input type=hidden name="book_id" value="{{ $book_id }}" />
                <input type=hidden name="parent_id" value="{{ $comment->id }}" />
            </div>
            <div class="form-group">
                <input type=submit class="btn btn-warning" value="Reply" />
            </div>
        </form>
    </div>
</div>
@endforeach -->