<!-- resources/views/components/rating-stars.blade.php -->
@props(['rating' => 0, 'size' => 'sm'])

@php
    $fullStars = floor($rating);
    $hasHalfStar = ($rating - $fullStars) >= 0.5;
    $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);
@endphp

<div class="rating-stars text-warning {{ $size === 'sm' ? 'fs-6' : 'fs-4' }}">
    @for($i = 0; $i < $fullStars; $i++)
        <i class="fas fa-star"></i>
    @endfor
    
    @if($hasHalfStar)
        <i class="fas fa-star-half-alt"></i>
    @endif
    
    @for($i = 0; $i < $emptyStars; $i++)
        <i class="far fa-star"></i>
    @endfor
</div>