<x-layout>
    <x-slot name="title">Explorer - Browse Community Posts</x-slot>

    <div class="container py-3 py-md-5">
        <!-- Header with Sorting -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1><i class="fas fa-compass me-2"></i>Explorer</h1>
            <x-explorer._sort-controls :currentSort="$currentSort" />
        </div>

        <!-- Responsive Posts Grid -->
        <div class="row g-4"> <!-- 'g-4' adds consistent gutters -->
            @forelse($posts as $post)
            <div class="col-12 col-md-6 col-lg-4 mb-4"> <!-- Responsive columns -->
                <div class="h-100"> <!-- Ensure cards take full height -->
                    @include('components.explorer._post-card', ['post' => $post])
                </div>
            </div>
            @empty
            <div class="col-12">
                @include('components.explorer._empty-state')
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($posts->hasPages())
        <div class="d-flex justify-content-center mt-5">
            {{ $posts->onEachSide(1)->links() }}
        </div>
        @endif
    </div>
    {{-- <x-explorer.register-form /> --}}

    <x-slot name="sidebar">
        @include('components.explorer._sidebar')
    </x-slot>
</x-layout>