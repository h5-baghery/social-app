<!-- resources/views/components/user-avatar.blade.php -->
@props([
    'user',      // User object (must have ->name and ->avatar)
    'size' => 32, // Default size in pixels
    'class' => '', // Additional classes
    'link' => true // Whether to wrap in a link
])

@php
    // Calculate font size for initials
    $initialsSize = round($size * 0.5);
    $avatarUrl = $user->avatar ?? null;
    $userName = $user->name ?? 'User';
    $initials = strtoupper(substr($userName, 0, 1));
@endphp

@if($link)
    <a href="{{ route('user.profile', $user) }}" 
       class="avatar-wrapper d-inline-block {{ $class }}"
       title="{{ $userName }}"
       style="width: {{ $size }}px; height: {{ $size }}px;">
@else
    <div class="avatar-wrapper d-inline-block {{ $class }}"
         style="width: {{ $size }}px; height: {{ $size }}px;">
@endif

    @if($avatarUrl)
        <img src="{{ $avatarUrl }}" 
             alt="{{ $userName }}"
             class="rounded-circle h-100 w-100"
             style="object-fit: cover;">
    @else
        <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center h-100 w-100"
             style="font-size: {{ $initialsSize }}px;">
            {{ $initials }}
        </div>
    @endif
@if($link)
    </a>
@else
    </div>
@endif
<span>{{$user->username}} sdfsdfsdf</span>
