  {{-- this is a regular(none model base component) --}}
  <div class="container py-md-5 container--narrow">
    <h2>

      <img class="avatar-small" src="{{ $data['user']->avatar }}" /> {{$data['user']->username}}
      <x-follow-avatar-button :user="$data['user']" />
    </h2>

    <div class="profile-nav nav nav-tabs pt-2 mb-4" >
     <a href="{{route('user.profile', ['user' => $data['user']])}}" class="profile-nav-link nav-item nav-link {{ ($title === 'profile') ? 'active' : ''}}" >Posts: {{$data['postCount']}}</a>
      <a href="{{route('user.profile.followers', ['user' => $data['user']])}}" class="profile-nav-link nav-item nav-link {{ ($title === 'followers') ? 'active' : ''}}">Followers: {{$data['followersCount']}}</a>
      <a href="{{route('user.profile.followings', ['user' => $data['user']])}}" class="profile-nav-link nav-item nav-link {{ ($title === 'followings') ? 'active' : ''}}">Following: {{$data['followingsCount']}}</a>
    </div>
    