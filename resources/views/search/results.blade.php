@extends('templates.default')
@section('title', 'search')
@section('content')

    <div class="row">
        <div class="col-md-12">
            <h3>search : "{{Request::input('query')}}"</h3>
        </div>
    
        <div class="col-md-12">

            @if(!$users->count())
                <p>not found</p>
            @else

                @foreach($users as $user)
                    @include('user.partials.userblock')
                @endforeach

            @endif
        </div>
    </div>
@endsection