

@guest
<form class="ml-2 d-inline" action="{{route('follow', ['user' => $user])}}" method="POST">
    @csrf
    <button class="btn btn-primary btn-sm">Follow <i class="fas fa-user-plus"></i></button>
</form>
@endguest
@auth
@if (auth()->user()->id !== $user->id)
    @if (auth()->user()->isFollowing($user))
    <form class="ml-2 d-inline" action="{{route('unfollow', $user->id)}}" method="POST">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger btn-sm">Unfollow <i class="fas fa-user-times"></i></button>
    </form>
    @else
    <form class="ml-2 d-inline" action="{{route('follow', $user->id)}}" method="POST">
        @csrf
        <button class="btn btn-primary btn-sm">Follow <i class="fas fa-user-plus"></i></button>
    </form>
    @endif
@else
    <a href="{{route('avatar.upload', $user->id)}}" class="btn btn-secondary">Upload Avatar</a>
@endif
@endauth