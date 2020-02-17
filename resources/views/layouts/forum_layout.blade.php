<html>

<head>
    <link rel="stylesheet" href="{{asset('css/forum_layout.css')}}">
    <div id="header">
    <a href="/forum">
    <h1 id="important-notice"> </h1>
    <h1 id="title"> Forumation </h1>
    </a>
    @guest
        <p class="auth">
        <a href="{{ route('login') }}">{{ __('Login') }}</a>@if (Route::has('register')) | <a href="{{ route('register') }}">{{ __('Register') }}</a>
        </p>
    @endif
    @else
            @if(Auth::user()->role == "admin")
            <a id="admin" style="color:white; position:absolute; top:1vh; left:1vh;" href="/forum/admin"> <i style="font-size: 5vh;" class="fas fa-cog"></i></a>
            @endif
            <p class="auth">
            <a id="username" style="color:white;" href="/forum/profile/{{Auth::user()->id}}">{{ Auth::user()->name }}</a>
            <a id="logout" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                {{ __('logout') }}
            </a>
            </p>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
    @endguest
    </div>
</head>
<div id="container">
@yield('content')
</div>
</html>