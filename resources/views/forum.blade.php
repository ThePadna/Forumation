<html>
@foreach($threads as $thread) {
    <div>
    <h1> $thread->title </h1>
    </div>
}
@endforeach
@stop
</html>