@extends('templates.default')
@section('title', 'profile')
@section('content')

    <div class="row">
    <div class="col-lg-4">
        <h1>edit</h1>
        <form action="{{route('profile.edit')}}" method="POST" novalidate>
            @csrf
            <div class="form-group">
                <label>firstname</label>
                <input type="text" 
                class="form-control {{$errors->has('firstname') ? 'is-invalid' : 'is-valid'}}" 
                name="firstname" value="{{Auth::user()->firstname ?: old('firstname')}}">

                @if($errors->has('firstname'))
                    <span class="help-block text-danger">
                        {{$errors->first('firstname')}}
                    </span>
                @endif
            </div>

            <div class="form-group">
                <label>lastname</label>
                <input type="text" 
                class="form-control {{$errors->has('lastname') ? 'is-invalid' : 'is-valid'}}" 
                name="lastname" value="{{Auth::user()->lastname ?: old('lastname')}}">

                @if($errors->has('lastname'))
                    <span class="help-block text-danger">
                        {{$errors->first('lastname')}}
                    </span>
                @endif
            </div>

            <div class="form-group">
                <label>location</label>
                <input type="text" 
                class="form-control {{$errors->has('location') ? 'is-invalid' : 'is-valid'}}" 
                name="location" value="{{Auth::user()->location ?: old('location')}}">

                @if($errors->has('location'))
                    <span class="help-block text-danger">
                        {{$errors->first('location')}}
                    </span>
                @endif
            </div>

            <button type="submit" class="btn btn-success">edit</button>
        </form>
    </div>
    </div>
@endsection