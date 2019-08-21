<html>
@foreach($threads as $t)
<div id="wrapper">
<div id="threads">
<a href="/threads/{{$t->id}}">
<div id="thread">
<div id="title">
<p> {{$t->title}} we dwr wwwdwdw dw wdwd wd wd wd w</p>
</div>
<div id="op">
<p> Submitted by <span> {{$t->op}} </span> </p>
</div>
</div>
</a>
</div>
</div>
@endforeach
<style>
span {
  font-style: italic;
}
body {
  background-color:#cc9900;
}
a {
  text-decoration: none;
}
#wrapper {
  text-align:center;
  display:flex;
  justify-content: center;
}
#op>p {
  font-size: 10px;
}
#title>p {
  font-size: 30px;
}
p {
  color: black;
  background-color: white;
  border: 3px;
  border-radius: 3px;
  height: 20s%;
  width: 500px;
}
#thread {
  margin-top: 10px;
  border: 5px solid black;
  border-radius: 10px;
  background-color:  #ffff66;
}
</style>
</html>