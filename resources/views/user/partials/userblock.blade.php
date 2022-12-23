<ul class="list-unstyled">
    <li class="media mb-2">
        <a href="{{route('profile.index', $user->username)}}">
            <img class="mr-3" src="{{$user->getAvatarUrl()}}" alt="{{$user->getNameOrUsername()}}" width="40">
        </a>
        <div class="media-body">
            <h5 class="mt-0 mb-1">
                <a href="{{route('profile.index', $user->username)}}">{{$user->getNameOrUsername()}}</a>
            </h5>

            @if($user->location)
                <span>{{$user->location}}</span>
            @endif
        </div>
    </li>
</ul>
