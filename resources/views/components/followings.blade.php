    <div class="list-group">
      @forelse ($followings as $following)
      <a href="{{route('user.profile' , ['user' => $following])}}" class="list-group-item list-group-item-action"> <img class="avatar-tiny" src="{{$following->avatar}}" /> {{$following->username}} </a>     
      
      @empty
          <p>No Following found</p>
      @endforelse
    </div>