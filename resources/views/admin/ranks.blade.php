@extends('layouts/forum_layout')
@section('content')

<head>
    <link rel="stylesheet" href="{{asset('css/ranks.css')}}">
</head>
<script>
function fillPermissions(perms, id) {
    for (let i = 0; i < perms.length; i++) {
        if (perms[i].length == 0) continue;
        let $obj = $('#' + id).find('#' + perms[i].trim());
        $obj.removeClass('unselected');
        $obj.addClass('selected');
    }
}
</script>
<table>
    <tr>
        <th>Rank</th>
        <th>Color</th>
        <th>Permissions</th>
    </tr>
    @foreach($ranks as $r)
    <tr class="rank" id="{{$r->id}}" updated-hex="{{$r->color}}">
        <td class="namecell"><i class="fas fa-tags"></i><input class="name" value="{{$r->name}}" autocomplete="off"
                index="{{$r->id}}"></input></td>
        <td>
            <div class="pickr-wrapper">
                <div class="color" style="color:{{$r->color}}" id="color{{$r->id}}" hex="{{$r->color}}" class="color">
                </div>
            </div>
        </td>
        <td>
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{sizeof(unserialize($r->permissions))}}
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="color: white !important;">
                    <p id="sendmessage" class="permission unselected"> Send Message </p>
                    <p id="editownprofile" class="permission unselected"> Edit Own Profile </p>
                    <p id="postcreate" class="permission unselected"> Create Post </p>
                    <p id="poststar" class="permission unselected"> Star Post </p>
                    <p id="posteraseself" class="permission unselected"> Erase Own Post </p>
                    <p id="threadcreate" class="permission unselected"> Create Thread </p>
                    <p id="threadlock" class="permission unselected"> Lock Thread </p>
                    <p id="threaddelete" class="permission unselected"> Delete Thread </p>
                    <p id="posterase" class="permission unselected"> Erase Post </p>
                    <p id="editotherprofile" class="permission unselected"> Edit Any Profile </p>
                    <p id="ban" class="permission unselected"> Ban Users </p>
                    <p id="categoryedit" class="permission unselected"> Edit Category </p>
                    <p id="categorydelete" class="permission unselected"> Delete Category </p>
                    <p id="categoryswitch" class="permission unselected"> Switch Category </p>
                    <p id="categoryadd" class="permission unselected"> Add Category </p>
                    <p id="admin" class="permission unselected"> Admin Panel </p>
                </div>
                <i style="font-size: 3vh;position: relative; top:1vh; left: 7vw;" class="trash fas fa-trash"></i>
            </div>
        </td>
    </tr>
    <script>
    fillPermissions('{{implode(', ', unserialize($r->permissions))}}'.split(","), '{{$r->id}}');
    </script>
    @endforeach
</table>
<div id="menu">
    <div class="add"> <i class="fas fa-plus"></i>
        <p> New Rank </p>
    </div>
    <div class="save"><svg class="bi bi-person-check-fill" width="1em" height="1em" viewBox="0 0 16 16"
            fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd"
                d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 100-6 3 3 0 000 6zm9.854-2.854a.5.5 0 010 .708l-3 3a.5.5 0 01-.708 0l-1.5-1.5a.5.5 0 01.708-.708L12.5 7.793l2.646-2.647a.5.5 0 01.708 0z"
                clip-rule="evenodd" />
        </svg>
        <p> Save All </p>
        <p class="result"> </p>
    </div>
    <div class="default">
        <div class="dropdown">
            <h1 class="option"> Default Rank </h1>
            @php
            $default = $settings->default_rank;
            $rank = App\Models\Rank::find($default);
            $defRank = "No default selected";
            $id = -1;
            if($rank != null) {
            $defRank = $rank->name;
            $id = $rank->name;
            }
            @endphp
            <button rankId="{{$id}}" class="selected-rank value btn btn-secondary dropdown-toggle" type="button"
                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{$defRank}}
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                @foreach($ranks as $r)
                <a id="{{$r->id}}" class="dropdown-item" href="#"> {{$r->name}} </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
<meta name="color" content="{{$settings->color}}">
<script src="{{asset('js/app.js')}}" charset="utf-8"></script>
<script src="{{asset('js/ranks.js')}}"> </script>
<meta name="csrf" content="{{csrf_token()}}">
@stop