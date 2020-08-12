<html>

<head>
    <link rel="stylesheet" href="{{asset('css/forum_layout.css')}}">
    <meta name="csrf-token" content="{{csrf_token()}}">
    @auth
    <meta name="avatar" content="{{Auth::user()->getAvatar()}}">
    <meta name="username" content="{{Auth::user()->name}}">
    @endauth
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
        @php 
        $unread = 0;
        @endphp
        @auth
        <div class="inbox">
            <i class="fas fa-inbox"></i>
            <div class="notification-circle">
                <p class="notifications"> </p>
            </div>
        </div>
        @endauth
    </div>
    @auth
    <div id="messages" class="message-popup" style="background: {{App\Models\Settings::first()->color}}">
        <div class="compose">
            <p class="compose-header"> <i class="far fa-envelope"></i> Compose </p>
        </div>
        <div class="conversations">
        @foreach(Auth::user()->getConversations() as $c)
        @if($c->getUnread() > 0)
        <div class="conversation unread" user-1="{{$c->getUser1()}}" user-2="{{$c->getUser2()}}">
        @else 
        <div class="conversation" user-1="{{$c->getUser1()}}" user-2="{{$c->getUser2()}}">
        @endif
            <div class="avatar">
                @php
                if($c->getUnread() > 0) $unread++;
                $sender = $c->getLatest()->getSender();
                $user = App\User::find($sender);
                $avatar = $user->getAvatar();
                $status = $user->isOnline() ? 'green' : 'red';
                @endphp
                <div class="status" style="background: {{$status}}"> </div>
                <div class="avatar-wrapper">
                <img src="{{$avatar}}" />
                </div>
            </div>
            <div class="content">
                <p> {{$c->getLatest()->contents}} </p>
            </div>
        </div>
        @endforeach
        </div>
        <div class="scroll-up">
            <i class="fas fa-chevron-up"></i>
        </div>
    </div>
    @endauth
    <meta name="unread" content="{{$unread}}">
    <script src="{{asset('js/forum_layout.js')}}"> </script>
</head>
@yield('content')
</html>