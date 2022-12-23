@extends('templates.default')
@section('title', 'home page')
@section('content')

    <div class="row">
        <div class="col-md-6">
            <form action="{{route('status.post')}}" method="POST">
                @csrf
                <div class="form-group">
                    <textarea name="body" 
                    class="form-control {{$errors->has('status') ? 'is-invalid' : ''}}" 
                    placeholder="what's new {{Auth::user()->getFirstNameOrUsername()}}"></textarea>
                @if($errors->has('body'))
                    <span class="help-block text-danger">
                        {{$errors->first('body')}}
                    </span>
                @endif
                </div>
                <button class="btn btn-outline-success" type="submit">share</button>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6"><hr>
            
            {{--  --}}
            @if(!$statuses->count())
                <p>no entries yet :(</p>
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
            {{--  --}}

        </div>
    </div>
@endsection