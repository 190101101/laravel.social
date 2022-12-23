@extends('templates.default')
@section('title', 'profile')
@section('content')

    <div class="row">
        <div class="col-lg-5">
            @include('user.partials.userblock')
            <hr>
            @if(!$statuses->count())
                <p>{{$user->getFirstNameOrUsername()}} - no have statuses</p>
            @else
                @foreach($statuses as $status)
                <div class="media mb-3">
                    <a class="mr-3" href="{{route('profile.index', ['username' => $status->user->username])}}">
                        <img class="media-object" src="{{$status->user->getAvatarUrl()}}" width="50">
                    </a>
                    <div class="media-body">
                        <h4>
                            <a href="">{{$status->user->getNameOrUsername()}}</a>
                        </h4>
                        <p>{{$status->body}}</p>
                        <ul class="list-inline">
                            <li class="list-inline-item">{{$status->created_at->diffforHumans()}}</li>
                            @if($status->user_id !== Auth::user()->id)
                            <li class="list-inline-item">
                                <a href="{{route('status.like', ['statusId' => $status->id])}}">like</a>
                            </li>
                            <li class="list-inline-item">
                                {{$status->likes->count()}} {{Str::plural('like', $status->likes->count())}}
                            </li>
                            @endif
                        </ul>


                        {{--  --}}
                        @if($authUserIsFriend || Auth::user()->id === $status->user_id)
                        <form action="{{route('status.reply', ['statusId' => $status->id])}}" method="POST" class="mb-3">
                            @csrf
                            <div class="form-group">
                                <textarea name="reply-{{$status->id}}" 
                                class="form-control {{$errors->has("reply-{$status->id}") ? 'is-invalid' : ''}}" 
                                placeholder="what's new {{Auth::user()->getFirstNameOrUsername()}}"></textarea>
                            @if($errors->has("reply-{$status->id}"))
                                <span class="help-block text-danger">
                                    {{$errors->first("reply-{$status->id}")}}
                                </span>
                            @endif
                            </div>
                            <button class="btn btn-outline-success" type="submit">answer</button>
                        </form>
                        @endif
                        {{--  --}}

                        {{-- reply --}}
                        @foreach($status->replies as $reply)
                            <div class="media mb-3">
                                <a class="mr-3" href="{{route('profile.index', ['username' => $reply->user->username])}}">
                                    <img class="media-object" src="{{$reply->user->getAvatarUrl()}}" width="50">
                                </a>
                                <div class="media-body">
                                    <h4>
                                        <a href="">{{$reply->user->getNameOrUsername()}}</a>
                                    </h4>
                                    <p>{{$reply->body}}</p>
                                    <ul class="list-inline">
                                        <li class="list-inline-item">{{$reply->created_at->diffforHumans()}}</li>
                                        @if($reply->user_id !== Auth::user()->id)
                                        <li class="list-inline-item">
                                            <a href="{{route('status.like', ['statusId' => $reply->id])}}">like</a>
                                        </li>
                                        <li class="list-inline-item">
                                            {{$reply->likes->count()}} {{Str::plural('like', $reply->likes->count())}}
                                        </li>
                                        @endif
                                    </ul>
                                    
                                </div>
                            </div>
                        @endforeach
                        {{-- reply --}}
                        
                    </div>
                </div>
                @endforeach

            {{$statuses->links()}}
            @endif
        </div>

        <div class="col-lg-4 col-lg-offset-3">

            @if(Auth::user()->hasFriendRequestPending($user))
                <div>
                    waiting for {{$user->getFirstNameOrUsername()}} 
                    confirmation of friend request
                </div>
            @elseif(Auth::user()->hasFriendRequestReceived($user))
                <a href="{{route('friend.accept', ['username' => $user->username])}}" 
                    class="btn btn-outline-success">add confirm friend</a>

            @elseif(Auth::user()->isFriendWith($user))
                {{$user->getFirstNameOrUsername()}} is your friend

            <form action="{{route('friend.delete', ['username' => $user->username])}}" method="POST">
                @csrf
                <button class="btn btn-outline-success">delete</button>
            </form>
                
            @elseif(Auth::user()->id !== $user->id)
                <a href="{{route('friend.add', ['username' => $user->username])}}" 
                    class="btn btn-outline-success">add to friend</a>
            @endif

            <h3>{{$user->getFirstNameOrUsername()}} friends</h3>

            @if($user->friends()->count())
                @foreach($user->friends() as $user)
                    @include('user.partials.userblock')
                @endforeach
            @else
                <p>{{$user->getFirstNameOrUsername()}} not have friend</p>
            @endif
        </div>
    </div>
@endsection