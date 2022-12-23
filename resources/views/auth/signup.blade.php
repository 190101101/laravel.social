<div>
    <div>
        <h1>register</h1>
    </div>
    <div>
        <form action="{{route('auth.signup')}}" method="POST" novalidate>
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
                <label>username</label>
                <input type="text" 
                class="form-control {{$errors->has('username') ? 'is-invalid' : 'is-valid'}}" 
                name="username" placeholder="username" value="{{old('username')}}">

                @if($errors->has('username'))
                    <span class="help-block text-danger">
                        {{$errors->first('username')}}
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
            <button type="submit" class="btn btn-success">register</button>
        </form>
    </div>
</div>
