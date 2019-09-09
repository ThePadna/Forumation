<html>

<head>
    <link href="https://fonts.googleapis.com/css?family=Yellowtail|Saira+Stencil+One&display=swap" rel="stylesheet">
    <div id="auth">
    @guest
        <p>
        <a href="{{ route('login') }}">{{ __('Login') }}</a>@if (Route::has('register')) | <a href="{{ route('register') }}">{{ __('Register') }}</a>
        </p>
    @endif
    @else
            <p> 
            Logged in as {{ Auth::user()->name }}
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
            </a>
            </p>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
    @endguest
</head>
</div>
    <div id="header">
    <h1 id="title"> Forumation </h1>
    </div>

@yield('content')
<style>
html,
body {
    height: 100vh;
    width: 100vw;
    overflow-x: hidden;
    overflow-y: hidden;
}
#auth {
    border-radius: 10px 10px 0 0;
    position: fixed;
    opacity: 0.7;
    font-size: 20px;
    height: 5vh;
    width: 25vw;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    background-color: #014952;
}
p {
    color: darkgray;
    text-align: center;
}
#header {
    background-color: #014952;
    height: 15vh;
    width: 100vw;
    text-align: center;
}
#title {
    position: relative;
    font-family: 'Yellowtail', cursive;
    font-size: 50px;
    top: 50%;
    transform: translateY(-50%);
}
</style>
</html>