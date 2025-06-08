<!-- resources/views/explorer/_post-card.blade.php -->
<div class="col-md-6 col-lg-4" style="min-width: 250px;">
    <div class="card h-100 shadow-sm">
        <div class="card-body d-flex flex-column">
            <!-- Author -->
            <x-user-avatar :user="$post->user" size="36" class="mb-3"/>

            <!-- Content -->
            <h5 class="card-title">{{ $post->title }}</h5>
            <p class="card-text flex-grow-1">{{ Str::limit($post->content, 120) }}</p>
            
            <!-- Rating & Stats -->
            <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top">
                <x-rating-stars :rating="$post->ratings_avg_rating" showNumber />
                <div class="text-muted small">
                    <span class="me-2"><i class="far fa-comment-dots me-1" ></i>{{ $post->comments_count }}</span>
                    <span><i class="fas fa-star me-1" style="margin-left: 1rem"></i>{{ $post->ratings_count }}</span>
                </div>
            </div>
            <!-- Action -->
            <a href="{{ route('singlepost', $post) }}" class="btn btn-outline-primary btn-sm mt-3 align-self-start">
                Read More
            </a>
        </div>
    </div>
</div>