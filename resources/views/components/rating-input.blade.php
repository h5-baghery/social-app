<!-- resources/views/components/rating-input.blade.php -->
<form action="{{ route('posts.rate', $post) }}" method="POST">
    @csrf
    <div class="rating-input">
        @for($i = 5; $i >= 1; $i--)
            <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}"
                   {{ $userRating == $i ? 'checked' : '' }}>
            <label for="star{{ $i }}" title="{{ $i }} stars">
                <i class="fas fa-star"></i>
            </label>
        @endfor
    </div>
    <button type="submit" class="btn btn-sm btn-primary mt-2">Submit Rating</button>
</form>

<style>
.rating-input {
    display: flex;
    flex-direction: row-reverse;
    justify-content: flex-end;
}
.rating-input input {
    display: none;
}
.rating-input label {
    color: #ddd;
    font-size: 1.5rem;
    cursor: pointer;
}
.rating-input input:checked ~ label,
.rating-input label:hover,
.rating-input label:hover ~ label {
    color: #ffc107;
}
.rating-input input:checked + label:hover,
.rating-input input:checked ~ label:hover,
.rating-input label:hover ~ input:checked ~ label {
    color: #ffc107;
}
</style>