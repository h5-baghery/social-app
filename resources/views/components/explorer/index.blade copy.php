

 <x-layout>
    {{-- section one starts here --}}
 <div class="container py-md-5">
      <div class="row align-items-center">
       <!-- explorer starts here -->
            <div class="col-lg-7 py-3 py-md-5">
        
<div>
    <x-slot name="title">Explorer - Browse Community Posts</x-slot>

    <div class="container">
        <!-- Header with Sorting -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1><i class="fas fa-compass me-2"></i>Explorer</h1>
            <x-explorer._sort-controls :currentSort="$currentSort"/>
        </div>

        <!-- Posts Grid -->
        <div class="row g-4">
            @forelse($posts as $post)
                @include('components.explorer._post-card', ['post' => $post])
            @empty
                @include('components.explorer._empty-state')
            @endforelse
        </div>

        <!-- Pagination -->
        @if($posts->hasPages())
            <div class="d-flex justify-content-center mt-5">
                {{ $posts->onEachSide(1)->links() }}
            </div>
        @endif
    </div>

    <!-- Sidebar -->
    <x-slot name="sidebar">
        @include('components.explorer._sidebar')
    </x-slot>
</div>
</div>
{{-- explorer ends here --}}
{{-- section one continues from here again --}}
        <div class="col-lg-5 pl-lg-5 pb-3 py-lg-5">
          <form action={{route("register")}} method="POST" id="registration-form">
            @csrf
            <div class="form-group">
              <label for="username-register" class="text-muted mb-1"><small>Username</small></label>
              <input name="username" value="{{old('username')}}" id="username-register" class="form-control" type="text" placeholder="Pick a username" autocomplete="off" />
              @error('username')
                  <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p>
              @enderror
            </div>

            <div class="form-group">
              <label for="email-register" class="text-muted mb-1"><small>Email</small></label>
              <input name="email" value="{{old('email')}}" id="email-register" class="form-control" type="text" placeholder="you@example.com" autocomplete="off" />
              @error('email')
                  <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p>
              @enderror
            </div>

            <div class="form-group">
              <label for="password-register" class="text-muted mb-1"><small>Password</small></label>
              <input name="password" id="password-register" class="form-control" type="password" placeholder="Create a password" />
              @error('password')
                  <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p>
              @enderror
            </div>

            <div class="form-group">
              <label for="password-register-confirm" class="text-muted mb-1"><small>Confirm Password</small></label>
              <input name="password_confirmation" id="password-register-confirm" class="form-control" type="password" placeholder="Confirm password" />
              @error('password_confirmation')
                  <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p>
              @enderror
            </div>

            <button type="submit" class="py-3 mt-4 btn btn-lg btn-success btn-block">Sign up for OurApp</button>
          </form>
        </div>
      </div>
    </div>

  </x-layout>
