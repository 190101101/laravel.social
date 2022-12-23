@extends('templates.default')
@section('title', 'sign up')
@section('content')

<div class="row">
    <div class="col-lg-4">
        <h1>log in</h1>
        <form action="{{route('auth.signin')}}" method="POST" novalidate>
            @csrf
            <div class="form-group">
                <label>email</label>
                <input type="email" 
                class="form-control {{$errors->has('email') ? 'is-invalid' : 'is-valid'}}" 
                name="email" placeholder="email" value="{{old('email')}}">

                @if($errors->has('email'))
                    <span class="help-block text-danger">
                        {{$errors->first('email')}}
                    </span>
                @endif
            </div>

            <div class="form-group">
                <label>password</label>
                <input type="password" 
                class="form-control {{$errors->has('password') ? 'is-invalid' : 'is-valid'}}" 
                name="password" placeholder="password">

                @if($errors->has('password'))
                    <span class="help-block text-danger">
                        {{$errors->first('password')}}
                    </span>
                @endif
            </div>

            <div class="form-check d-flex justify-content-between">
                <input type="checkbox" name="remember" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">remember</label>
                <button type="submit" class="btn btn-success">login</button>
            </div>
        </form>
    </div>
</div>
@endsection