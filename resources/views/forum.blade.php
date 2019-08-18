<html>
@foreach($threads as $thread)
    <div id="{{ $thread->id }}" class="thread">
        <h1 class="thread-title"> {{ $thread->title }} </h1>
        <h2 class="thread-op"> Submitted by {{ $thread->op }} </h2>
    </div>
@endforeach
<style>
h1 {
    color:#0000CD;
}
.thread-op {
    font-style: italic;
}
.thread {
    width: 50%;
    height: 15%;
    border: 1px solid navy;
}
</style>
</html>