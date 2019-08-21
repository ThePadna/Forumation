<html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
@foreach($threads as $t)
<div id="wrapper">
<div id="threads">
<a href="/threads/{{$t->id}}">
<div id="thread">
<div id="title">
<p> {{$t->title}}</p>
</div>
<div id="op">
<p> Submitted by &nbsp;<span> <span class="glyphicon glyphicon-user"> </span> {{$t->op}} &nbsp;  <span class="glyphicon glyphicon-fire">&nbsp;{{floor($t->posts)}}<span class="glyphicon glyphicon-envelope"> </span> </span></i></p>
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