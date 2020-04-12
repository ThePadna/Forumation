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
    <tr class="rank">
        <td><input class="name" value="{{$r->name}}"></input></td>
        <td><div class="pickr-wrapper"><div class="color" style="color:{{$r->color}}" id="color{{$r->id}}" class="color"></div></div></td>
        <td>
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{sizeof(unserialize($r->permissions))}}
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="color: white !important;">
                <p id="usereditownprofile" class="permission unselected"> Edit Own Profile </p>
                <p id="postcreate" class="permission unselected"> Create Post </p>
                <p id="poststar" class="permission unselected"> Star Post </p>
                <p id="posteraseself" class="permission unselected"> Erase Own Post </p>
                <p id="threadcreate" class="permission unselected"> Create Thread </p>
                <p id="threadlock" class="permission unselected"> Lock Thread </p>
                <p id="threaddelete" class="permission unselected"> Delete Thread </p>
                <p id="posterase" class="permission unselected"> Erase Post </p>
                <p id="categoryedit" class="permission unselected"> Edit Category </p>
                <p id="categorydelete" class="permission unselected"> Delete Category </p>
                <p id="categoryswitch" class="permission unselected"> Switch Category </p>
                <p id="categoryadd" class="permission unselected"> Add Category </p>
                <p id="admin" class="permission unselected"> Admin Panel </p>
                </div>
            </div>
        </td>
    </tr>
    @endforeach
    <script>
    perms1 = "{{implode("_", unserialize($r->permissions))}}";
    perms1 = perms1.split("_");
    for(let i = 0; i < perms1.length; i++) {
        let $obj = $('#' + perms1[i].split('.').join(""));
        $obj.removeClass('unselected').addClass('selected');
    }
    </script>
</table>
<p class="save"> SAVE </p>
<meta name="color" content="{{$settings->color}}">
<script src="{{asset('js/ranks.js')}}"> </script>
<meta name="csrf" content="{{csrf_token()}}">
@stop