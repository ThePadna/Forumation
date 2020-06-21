<html>

<head>
    <script href="js/app.js"> </script>
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/forum_layout.css')}}">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <script src="{{asset('js/app.js')}}"> </script>
    <div id="header">
        @guest
        <div class="auth">
            <a href="{{ route('login') }}">{{ __('Login') }}</a>@if (Route::has('register')) | <a
                href="{{ route('register') }}">{{ __('Register') }}</a>
        </div>
        @endif
        @else
        @php
        $rank = null;
        if(Auth::check()) $rank = Auth::user()->getRank();
        @endphp
        @if($rank != null && $rank->hasPerm("admin"))
        <div class="admin">
        <a style="color:white; position:absolute; top:5px; left:5px;" href="/forum/admin"> <i
                class="admin-icon fas fa-cog"></i></a>
        </div>
        @endif
        <div class="title-container">
            <a href="/forum">
                <h1 id="title"> Forumation 1 </h1>
            </a>
        <div class="auth">
            <a id="username" style="color:white;"
                href="/forum/profile/{{Auth::user()->name}}">{{ Auth::user()->name }}</a>
            <a id="logout" href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                {{ __('logout') }}
            </a>
        </div>
        </div>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
        @endguest
        @auth
        <div class="inbox">
            <i class="fas fa-inbox"></i>
        </div>
        @endauth
    </div>
    @auth
    <div id="messages" class="message-popup">
        @foreach($conversations as $c)
        <div class="conversation">
            <div class="avatar">
                <img src="{{base64_decode(Auth::user()->getAvatar())}}" />
            </div>
            <div class="content">
                Lorem Ipsum..
            </div>
        </div>
        @endforeach
    </div>
    @endauth
</head>
@yield('content')
</html>