<x-layout>
  <div class="container py-md-5 container--narrow">

    @unless ($posts->isEmpty())
    
                <!-- Responsive Posts Grid -->
        <div class="row g-4"> <!-- 'g-4' adds consistent gutters -->
            @forelse($posts as $post)
            <div class="col-12 col-md-6 col-lg-4 mb-4"> <!-- Responsive columns -->
                <div class="h-100"> <!-- Ensure cards take full height -->
                    <x-explorer._post-card :post='$post' />
                </div>
            </div>
            @empty
            <div class="col-12">
                @include('components.explorer._empty-state')
            </div>
            @endforelse
        </div>
  {{$posts->links()}}

    @else
      <div class="text-center">
        <h2>Hello <strong>{{auth()->user()->username}}</strong>, your feed is empty.</h2>
        <p class="lead text-muted">Your feed displays the latest posts from the people you follow. If you don&rsquo;t have any friends to follow that&rsquo;s okay; you can use the &ldquo;Search&rdquo; feature in the top menu bar to find content written by people with similar interests and then follow them.</p>
      </div>
    @endunless
  </div>
</x-layout>