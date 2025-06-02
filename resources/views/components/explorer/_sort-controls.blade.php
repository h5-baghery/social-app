<!-- resources/views/explorer/_sort-controls.blade.php -->
<div class="dropdown" id="sortDropdown">
    <button class="btn btn-outline-primary dropdown-toggle" type="button" 
            data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fas fa-sort me-1"></i>
        @switch($currentSort)
            @case('oldest') Oldest First @break
            @case('top-rated') Top Rated @break
            @case('most-rated') Most Rated @break
            @default Newest First
        @endswitch
    </button>
    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="sortDropdown">
        <li><h6 class="dropdown-header">Sort By</h6></li>
        <li><a class="dropdown-item" href="{{ route('explorer', ['sort' => 'newest']) }}">
            <i class="fas fa-clock me-2"></i>Newest First
        </a></li>
        <li><a class="dropdown-item" href="{{ route('explorer', ['sort' => 'oldest']) }}">
            <i class="fas fa-history me-2"></i>Oldest First
        </a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item" href="{{ route('explorer', ['sort' => 'top-rated']) }}">
            <i class="fas fa-star me-2"></i>Top Rated
        </a></li>
        <li><a class="dropdown-item" href="{{ route('explorer', ['sort' => 'most-rated']) }}">
            <i class="fas fa-poll me-2"></i>Most Rated
        </a></li>
    </ul>
</div>