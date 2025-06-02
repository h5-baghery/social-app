<style>
  .star-rating {
    display: flex;
    flex-direction: row-reverse;
    justify-content: flex-end;
    gap: 0.3rem;
}
.star-rating input {
    display: none;
}
.star-rating label {
    color: #dee2e6;
    font-size: 1.5rem;
    cursor: pointer;
    transition: color 0.2s;
}
.star-rating input:checked ~ label,
.star-rating label:hover,
.star-rating label:hover ~ label {
    color: #ffc107;
}
.comment {
    transition: background-color 0.1s;
}
.comment:hover {
    background-color: #f8f9fa;
}
</style>

<!-- Rating Section -->
<div class="mt-4 border-top pt-3">
    <h5>Rate this post</h5>
    <form action="{{ route('posts.rate', $post) }}" method="POST" class="mb-3" id="rating-form-{{ $post->id }}">
        @csrf
        <div class="star-rating mb-2">
            @for($i = 5; $i >= 1; $i--)
                <input type="radio" 
                       id="post{{ $post->id }}_rating{{ $i }}" 
                       name="rating" 
                       value="{{ $i }}"
                       {{ $userRating && $userRating->rating == $i ? 'checked' : '' }}
                       onchange="document.getElementById('rating-form-{{ $post->id }}').submit();">
                <label for="post{{ $post->id }}_rating{{ $i }}" title="{{ $i }} stars">
                    <i class="fas fa-star"></i>
                </label>
            @endfor
        </div>
    </form>


    
    <!-- Average Rating Display -->
    <div class="d-flex align-items-center small text-muted">
        <div class="text-warning me-2">
            @php $avgRating = $post->ratings_avg_rating @endphp
            @for($i = 1; $i <= 5; $i++)
                @if($i <= floor($avgRating))
                    <i class="fas fa-star"></i>
                @elseif($i - 0.5 <= $avgRating)
                    <i class="fas fa-star-half-alt"></i>
                @else
                    <i class="far fa-star"></i>
                @endif
            @endfor
        </div>
        <span>{{ number_format($avgRating, 1) }} ({{ $post->ratings_count }} ratings)</span>
    </div>
</div>

<!-- Comments Section -->
<div class="mt-4">
    <h5 class="mb-3">Comments</h5>
    
    @auth
    <form action="{{ route('comments.store', $post) }}" method="POST" class="mb-4">
        @csrf
        <div class="input-group">
            <textarea name="content" class="form-control" placeholder="Add a comment..." rows="2" required></textarea>
            <button class="btn btn-primary" type="submit">Post</button>
        </div>
    </form>
    @else
    <div class="alert alert-light py-2 mb-3">
        <a href="{{ route('login') }}" class="text-primary">Login</a> to post comments
    </div>
    @endauth

    <div class="comments">
        @foreach($post->comments as $comment)
        <div class="comment mb-3 pb-2 border-bottom">
            <div class="d-flex">
                <x-user-avatar :user="$comment->user" size="32" class="me-2"/>
                <div class="flex-grow-1">
                    <div class="d-flex justify-content-between small mb-1">
                        <strong>{{ $comment->user->name }}</strong>
                        <span class="text-muted">{{ $comment->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="mb-1">{{ $comment->body }}</p>
                    @auth
                        @if($comment->user_id == auth()->id())
                        <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger py-0 px-2">Delete</button>
                        </form>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
