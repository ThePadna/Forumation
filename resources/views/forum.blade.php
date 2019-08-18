<html>
@foreach($threads as $thread)
    <div id="{{ $thread->id }}" class="thread" style="height:{{$thread->posts}}%; width:{{$thread->posts}}%; background-color:gray;">
        <h1 class="thread-title" style="font-size:{{$thread->posts}};"> {{ $thread->title }} </h1>
        <h2 class="thread-op" style="font-size:{{$thread->posts / 2}};"> Submitted by {{ $thread->op }} </h2>
    </div>
@endforeach
<style>
html, body {
    height: 100%;
    width: 100%;
    border: 0;
    margin: 0;
}
h1 {
    color:#0000CD;
}
.thread-op {
    font-style: italic;
}
.thread {
    border: 1px solid red;
}
</style>
</html>