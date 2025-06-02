<!-- resources/views/components/rating-display.blade.php -->
<div class="rating-container">
    <div class="average-rating">
        <span class="rating-value">{{ number_format($average, 1) }}</span>
        <div class="stars">
            @for($i = 1; $i <= 5; $i++)
                @if($i <= floor($average))
                    <i class="fas fa-star text-warning"></i>
                @elseif($i - 0.5 <= $average)
                    <i class="fas fa-star-half-alt text-warning"></i>
                @else
                    <i class="far fa-star text-warning"></i>
                @endif
            @endfor
        </div>
        <small class="text-muted">({{ $count }} ratings)</small>
    </div>
</div>