    <div class="list-group">
      @forelse ($followers as $follower)
      <a href="{{route('user.profile' , ['user' => $follower])}}" class="list-group-item list-group-item-action"> <img class="avatar-tiny"  src="{{$follower->avatar}}" /> {{$follower->username}} </a>     
      
      @empty
          <p>No Follower found</p>
      @endforelse