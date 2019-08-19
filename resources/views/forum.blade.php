<html>
<div id="container">
<canvas id="threads" style="width:100%; height:500px;" />
</div>
<script>
var canv = document.getElementById("threads");
var ctx = canv.getContext("2d");
ctx.lineWidth = (40 / this.size);
ctx.fillStyle = 'black;';
ctx.fillRect(0, 0, 800, 800);
</script>
<style>
html, body {
    height: 100%;
    width: 100%;
    border: 0;
    margin: 0;
}
#container {
  position: fixed;
  left: 0;
  top: 0;
  width: 100vw;
  height: 100vh;
  background-color: white;
  display: flex;
}
#threads {
  margin: auto;
  width: 10em;
  height: 5em;
  background-color: white;
  box-shadow: 1px 1px 10px rgba(0, 0, 0, .4);
}
</style>
</html>