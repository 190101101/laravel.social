@extends('templates.default')
@section('title', '404')
@section('content')

    <div class="row">
        <div class="col-lg-5">
            <h1>404 page</h1>
            <a href="{{route('home')}}">go back</a>
        </div>
    </div>
    
@endsection