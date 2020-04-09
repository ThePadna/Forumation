@extends('layouts/forum_layout')
@section('content')

<head>
    <link rel="stylesheet" href="{{asset('css/ranks.css')}}">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"> </script>
</head>
<table>
    <tr>
        <th>Rank</th>
        <th>Color</th>
        <th>Permissions</th>
    </tr>
    @foreach($ranks as $r)
    <tr>
        <td><input value="{{$r->name}}"></input></td>
        <td><div class="pickr-wrapper"><div style="color:{{$r->color}}" id="color{{$r->id}}" class="color"></div></div></td>
        <td>
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    3
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <p> hi </p>
                </div>
            </div>
        </td>
    </tr>
    <script>
    let permissions = "{{implode("_", unserialize($r->permissions))}}";
    let permsSplit = permissions.split("_");
    for(let i = 0; i < permsSplit.length; i++) {
        $('#' + permsSplit[i]).append('<i class="fas fa-check"></i>');
    }
    </script>
    @endforeach
</table>
<meta name="color" content="{{$settings->color}}">
<script src="{{asset('js/ranks.js')}}"> </script>
<meta name="csrf" content="{{csrf_token()}}">
@stop