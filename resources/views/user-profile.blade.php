<x-layout doctitle="{{$data['user']->username}}'s Profile">

  
  <div class="list-group">
    @foreach ($data['posts'] as $post)
    <a href={{route('singlepost', ['post' => $post->id])}} class="list-group-item list-group-item-action">
      <img class="avatar-tiny" src="{{$post->user->avatar}}" />
      <strong>{{$post->title}}</strong> on {{$post->created_at->diffForHumans()}}
    </a>         
    @endforeach
  </div>
  
    <x-user-profile-shared :data="$data" :title="$title" /> 
  @if ($title === 'profile')
    <x-posts :posts="$posts"/>
  @endif
  @if ($title === 'followers')
    <x-followers :followers="$followers" />
  @endif
  @if ($title === 'followings')
    <x-followings :followings="$followings"/>
  @endif
</x-layout>