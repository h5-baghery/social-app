<!-- resources/views/explorer/_sidebar.blade.php -->
<div class="sticky-top" style="top: 20px;">
    <!-- Top Rated Posts -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-white border-bottom-0">
            <h5 class="mb-0 d-flex justify-content-between align-items-center">
                <span><i class="fas fa-crown text-warning me-2"></i>Top Rated</span>
                <a href="{{ route('explorer', ['sort' => 'top-rated']) }}" class="btn btn-sm btn-outline-primary">
                    View All
                </a>
            </h5>
        </div>
        <div class="card-body pt-0">
            @foreach($topRatedPosts as $post)
                <div class="mb-3 pb-2 border-bottom">
                    <div class="d-flex justify-content-between align-items-start">
                        <a href="{{ route('singlepost', $post) }}" class="text-decoration-none flex-grow-1 me-2">
                            {{ Str::limit($post->title, 28) }}
                        </a>
                        <x-rating-stars :rating="round($post->ratings_avg_rating)" size="xs"/>
                    </div>
                    <div class="small text-muted mt-1">
                        by <a href="{{ route('user.profile', $post->user) }}" class="text-decoration-none">{{ $post->user->name }}</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Active Posters -->
    <div class="card shadow-sm">
        <div class="card-header bg-white border-bottom-0">
            <h5 class="mb-0"><i class="fas fa-users text-primary me-2"></i>Active Posters</h5>
        </div>
        <div class="card-body pt-0">
            @foreach($activePosters as $user)
                <x-user-avatar :user="$user" size="32" class="mb-3"/>
            @endforeach
        </div>
    </div>
</div>