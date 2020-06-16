<html>

<head>
    <script href="js/app.js"> </script>
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/forum_layout.css')}}">
    <div id="header">
        <a href="/forum">
            <div class="title-container">
                <h1 id="title"> Forumation 1 </h1>
            </div>
        </a>
        @guest
        <p class="auth">
            <a href="{{ route('login') }}">{{ __('Login') }}</a>@if (Route::has('register')) | <a
                href="{{ route('register') }}">{{ __('Register') }}</a>
        </p>
        @endif
        @else
        @php
        $rank = null;
        if(Auth::check()) $rank = Auth::user()->getRank();
        @endphp
        @if($rank != null && $rank->hasPerm("admin"))
        <a id="admin" style="color:white; position:absolute; top:5px; left:5px;" href="/forum/admin"> <i
                class="admin-icon fas fa-cog"></i></a>
        @endif
        <div class="auth">
            <a id="username" style="color:white;"
                href="/forum/profile/{{Auth::user()->name}}">{{ Auth::user()->name }}</a>
            <a id="logout" href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                {{ __('logout') }}
            </a>
        </div>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
        @endguest
        <div class="inbox">
            <i class="fas fa-inbox"></i>
        </div>
    </div>
</head>
@yield('content')
</html>