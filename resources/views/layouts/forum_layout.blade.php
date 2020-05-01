<html>

<head>
    <link href="{{ asset('bootstrap.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('css/forum_layout.css')}}">
    <div id="header">
    <a href="/forum">
        <div class="title-container" href="/forum">
            <h1 id="important-notice"> </h1>
            <h1 id="title"> Forumation </h1>
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
        $admin = false;
        if(Auth::check()) {
        $rank = App\Models\Rank::find(Auth::user()->rank);
        if($rank != null) {
        $perms = unserialize($rank->permissions);
        if(in_array("admin", $perms)) $admin = true;
        } else {
        $settings = App\Models\Settings::first();
        if($settings != null) {
        $default = $settings->default_rank;
        $rank = App\Models\Rank::find($default);
        if($rank != null) {
        $perms = unserialize($rank->permissions);
        if(in_array("admin", $perms)) $admin = true;
        }
        }
        }
        }
        @endphp
        @if($admin)
        <a id="admin" style="color:white; position:absolute; top:1vh; left:1vh;" href="/forum/admin"> <i
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
    </div>
</head>
<div id="container">
    @yield('content')
</div>

</html>