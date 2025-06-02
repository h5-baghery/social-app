<x-layout>
    <x-slot name="title">Explorer - Browse Posts</x-slot>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Explorer</h1>
        <div class="dropdown">
            <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                @switch($currentSort)
                    @case('oldest')
                        Oldest First
                        @break
                    @case('top-rated')
                        Top Rated
                        @break
                    @case('most-rated')
                        Most Rated
                        @break
                    @default
                        Newest First
                @endswitch
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{ route('explorer', ['sort' => 'newest']) }}">Newest First</a></li>
                <li><a class="dropdown-item" href="{{ route('explorer', ['sort' => 'oldest']) }}">Oldest First</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="{{ route('explorer', ['sort' => 'top-rated']) }}">Top Rated</a></li>
                <li><a class="dropdown-item" href="{{ route('explorer', ['sort' => 'most-rated']) }}">Most Rated</a></li>
            </ul>
        </div>
    </div>

    <div class="row">
        @foreach($posts as $post)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ $post->user->avatar }}" alt="{{ $post->user->name }}" 
                                 class="rounded-circle me-2" width="32">
                            <a href="{{ route('user.profile', $post->user) }}" class="text-decoration-none">
                                {{ $post->user->name }}
                            </a>
                            <span class="text-muted ms-auto">
                                {{ $post->created_at->format('M j, Y') }}
                            </span>
                        </div>
                        
                        <h5 class="card-title">{{ $post->title }}</h5>
                        <p class="card-text">{{ Str::limit($post->content, 150) }}</p>
    
    <div class="d-flex justify-content-between align-items-center mt-3">
        <a href="{{ route('singlepost', $post) }}" class="btn btn-sm btn-outline-primary">
            Read More
        </a>
        <div class="text-muted">
            {{-- rating-star-component --}}
            <x-rating-stars :rating="round($post->ratings_avg_rating)" size="sm" />
            <small>
                <i class="fas fa-star text-warning"></i> 
                {{ number_format($post->ratings_avg_rating, 1) }} <!-- Changed from ratings_avg_rating -->
                ({{ $post->ratings_count }})
                <i class="far fa-comment ms-2"></i> {{ $post->comments_count }}
            </small>
        </div>
    </div>
    
    <!-- Rest of the view remains the same -->
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $posts->links() }}
    </div>

    <x-slot name="sidebar">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Top Rated</h5>
                <a href="{{ route('explorer', ['sort' => 'top-rated']) }}" class="small">View All</a>
            </div>
            <div class="card-body">
                @foreach(\App\Models\Post::withAvg('ratings', 'rating')
                    ->orderByDesc('rating')
                    ->limit(5)
                    ->get() as $topPost)
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('singlepost', $topPost) }}" class="text-decoration-none">
                                {{ Str::limit($topPost->title, 25) }}
                            </a>
                            <x-rating-stars :rating="round($topPost->ratings_avg_rating)" size="xs" />
                        </div>
                        <div class="small text-muted">
                            by {{ $topPost->user->name }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </x-slot>
</x-layout>