<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="{{route('home')}}">Social</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            @if(Auth::check())
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="{{route('home')}}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('friend.index')}}">friends</a>
                </li>
                <form action="{{route('search.results')}}" method="GET" class="form-inline my-2 ml-2 my-lg-0">
                    <input class="form-control mr-sm-2" name="query" type="search" placeholder="what are we looking for?">
                    <button class="btn btn-success my-2 my-sm-0" type="submit">search</button>
                </form>
            </ul>
            @endif
            <ul class="navbar-nav ml-auto">
                @if(Auth::check())
                <li class="nav-item">
                    <a href="{{route('profile.index', Auth::user()->getNameOrUsername())}}" class="nav-link">
                        {{Auth::user()->getNameOrUsername()}}
                    </a>
                </li>
                <li class="nav-item"><a href="{{route('profile.edit')}}" class="nav-link">edit</a></li>
                <li class="nav-item"><a href="{{route('auth.signout')}}" class="nav-link">logout</a></li>
                {{-- 
                @else 
                <li class="nav-item"><a href="{{route('auth.signup')}}" class="nav-link">register</a></li>
                <li class="nav-item"><a href="{{route('auth.signin')}}" class="nav-link">login</a></li>
                 --}}
                @endif
            </ul>
        </div>
    </div>
</nav>