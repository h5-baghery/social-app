<!-- resources/views/posts/show.blade.php -->
<x-layout>
<div class="card mb-4">
    <div class="card-body">
        <!-- Post content here -->
        <x-rating-input :post="$post" />
        
        <div class="row mt-4">
            <div class="col-md-6">
                <h5>Rating</h5>
                <x-rating-display 
                    :average="$post->averageRating()" 
                    :count="$post->ratingCount()" 
                />
            </div>
            
            @auth
            <div class="col-md-6">
                <h5>Your Rating</h5>
                <x-rating-input 
                    :post="$post" 
                    :userRating="$post->ratings->where('user_id', auth()->id())->first()?->rating" 
                />
            </div>
            @endauth
        </div>
        
        <!-- Rating distribution chart -->
        <div class="mt-4">
            <h5>Rating Distribution</h5>
            @php
                $distribution = $post->ratings()
                    ->selectRaw('rating, count(*) as count')
                    ->groupBy('rating')
                    ->orderBy('rating', 'desc')
                    ->get()
                    ->keyBy('rating');
            @endphp
            
            @for($i = 5; $i >= 1; $i--)
                <div class="row align-items-center mb-2">
                    <div class="col-1 text-end">
                        {{ $i }} <i class="fas fa-star text-warning"></i>
                    </div>
                    <div class="col-8">
                        <div class="progress" style="height: 20px;">
                            @php
                                $count = $distribution->has($i) ? $distribution->get($i)->count : 0;
                                $percentage = $post->ratingCount() > 0 ? ($count / $post->ratingCount()) * 100 : 0;
                            @endphp
                            <div class="progress-bar bg-warning" 
                                 role="progressbar" 
                                 style="width: {{ $percentage }}%" 
                                 aria-valuenow="{{ $percentage }}" 
                                 aria-valuemin="0" 
                                 aria-valuemax="100">
                            </div>
                        </div>
                    </div>
                    <div class="col-1">
                        <small>{{ $count }}</small>
                    </div>
                </div>
            @endfor
        </div>
    </div>
</div>

</x-layout>