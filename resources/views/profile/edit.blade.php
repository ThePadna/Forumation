@extends('layouts/forum_layout')
@section('content')
@auth
@if(Auth::user()->id == $user->id)
<script src="{{asset('js/profile_edit.js')}}"> </script>
<h1> form.. </h1>
@else
<h1> You do not have priveleges to edit this profile. </h1>
@endif
@else
<h1> You do not have priveleges to edit this profile. </h1>
@endauth
@stop