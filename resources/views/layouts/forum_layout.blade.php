<html>

<head>
    <div id="auth">
    @guest
        <a href="{{ route('login') }}">{{ __('Login') }}</a>@if (Route::has('register')) | <a href="{{ route('register') }}">{{ __('Register') }}</a>
    @endif
    @else
            {{ Auth::user()->name }}
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
    @endguest
    </div>
</head>

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
    font-size: 25px;
    position: relative;
    height: 2.5vh;
    width: 10vw;
    float: right;
}
</style>
</html>