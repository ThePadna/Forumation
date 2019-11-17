<html>

<head>
    <link rel="stylesheet" href="{{asset('css/forum_layout.css')}}">
    <div id="auth">
    @guest
        <p>
        <a href="{{ route('login') }}">{{ __('Login') }}</a>@if (Route::has('register')) | <a href="{{ route('register') }}">{{ __('Register') }}</a>
        </p>
    @endif
    @else
            <p> 
            Logged in as <a style="color:white;" href="/forum/profile/{{Auth::user()->id}}">{{ Auth::user()->name }}</a>
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
            </a>
            </p>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
    @endguest
</div>
    <div id="header">
    <a href="/forum">
    <h1 id="title"> Forumation </h1>
    </a>
    </div>
</head>
<div id="container">
@yield('content')
</div>
</html>