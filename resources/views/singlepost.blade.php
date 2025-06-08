<x-layout :doctitle="$post->title">
  <div class="container py-md-5 container--narrow">
      <div class="d-flex justify-content-between">
        <h2>{{$post->title}}</h2>
        <span class="pt-2">
          @can('update', $post)
            <a href={{route('editpost', ['post' => $post->id])}} class="text-primary mr-2" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fas fa-edit"></i></a>    
          @endcan
          @can('delete', $post)
            <form class="delete-post-form d-inline" action="{{route('post.delete', ['post' => $post])}}" method="POST">
              @csrf
              @method('DELETE')
              <input type="hidden" name="redirect_to" value="{{ url()->previous() }}">
              <button class="delete-post-button text-danger" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fas fa-trash"></i></button>
            </form>
          @endcan
        </span>
      </div>

      <p class="text-muted small mb-4">
        <a href="{{route('user.profile', ['user' => $post->user->username])}}"><img class="avatar-tiny" src="{{$post->user->avatar}}" /></a>
        Posted by <a href="{{route('user.profile', ['user' => $post->user->username])}}">{{$post->user->username}}</a> {{$post->created_at->diffForHumans()}}
      </p>

      <div class="body-content">
        {!! $post->body !!}
      </div>

      <x-rating :post="$post" :userRating="$userRating"/>
    
    </div>
</x-layout>