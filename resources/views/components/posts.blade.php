    <div class="list-group">
      @forelse ($posts as $post)
        <a href="{{route('singlepost', ['post' => $post->id])}}" class="list-group-item list-group-item-action"> <img class="avatar-tiny" src="{{$post->user->avatar}}" /> {{$post->title}}</a>     
      @empty
          <p>No Post found</p>
      @endforelse
  {{$posts->links()}}

    </div>