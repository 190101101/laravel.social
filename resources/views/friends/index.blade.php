@extends('templates.default')
@section('title', 'friend')

@section('content')
	<div class="row">
		<div class="col-md-6">
			<h3>your friend</h3>
			   @if($friends->count())
	                @foreach($friends as $user)
	                    @include('user.partials.userblock')
	                @endforeach
	            @else
	                <p>not have friend</p>
	            @endif
		</div>

		<div class="col-md-6">
			<h3>friend requests</h3>
			@if($requests->count())
                @foreach($requests as $user)
                    @include('user.partials.userblock')
                @endforeach
            @else
                <p>not have friend requests</p>
            @endif
		</div>
	</div>
@endsection