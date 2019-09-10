<html>

<head>

    <link href="https://fonts.googleapis.com/css?family=Yellowtail|Saira+Stencil+One&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link href="https://use.fontawesome.com/releases/v5.0.1/css/all.css" rel="stylesheet">
</head>
<div id="header">
    <h1 id="title"> Forumation </h1>
</div>
<div id="carousel" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#carousel" data-slide-to="0" class="active"></li>
        <li data-target="#carousel" data-slide-to="1"></li>
        <li data-target="#carousel" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="{{URL::to('/')}}/img/image1.jpg" class="d-block w-100 img-fluid" alt="...">
            <div class="carousel-caption d-none d-md-block">
                <h5 style="color: white;">Elegance</h5>
            </div>
        </div>
        <div class="carousel-item">
            <img src="{{URL::to('/')}}/img/image2.jpg" class="d-block w-100 img-fluid" alt="...">
            <div class="carousel-caption d-none d-md-block">
                <h5>Highly Customizable</h5>
            </div>
        </div>
        <div class="carousel-item">
            <img src="{{URL::to('/')}}/img/image3.jpg" class="d-block w-100 img-fluid" alt="...">
            <div class="carousel-caption d-none d-md-block">
                <h5>Completely Free</h5>
            </div>
        </div>
    </div>
    <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>
<div id="footer">
    <div class="row">
        <div class="col-sm-3">
            <a href="https://github.com/ThePadna/Forumation">
                <i class="fa fa-file-code"></i>
                <p> Source </p>
            </a>
        </div>
        <div class="col-sm-3">
            <a href="/faq">
                <i class="far fa-question-circle"></i>
                <p> F.A.Q. </p>
            </a>
        </div>
        <div class="col-sm-3">
            <a href="/forum">
                <i class="fas fa-laptop"></i>
                <p> Demo </p>
            </a>
        </div>
        <div class="col-sm-3">
            <a href="/guide">
                <i class="fas fa-info"></i>
                <p> Guide </p>
            </a>
        </div>
    </div>
</div>
<style>
html,
body {
    height: 100vh;
    width: 100vw;
    overflow-x: hidden;
    overflow-y: hidden;
}

a,
a:hover {
    color: inherit;
    text-decoration: none;
}

#header {
    background-color: #014952;
    height: 25vh;
    width: 100vw;
    text-align: center;
}

.row {
    position: relative;
    top: 50%;
    transform: translateY(-50%);
}

i {
    font-size: 100px;
    margin-bottom: 1vh;
}

.col-sm-3 {
    color: white;
    text-align: center;
    font-family: 'Yellowtail', cursive;
    font-weight: bold;
    font-size: 25px;
}

#footer {
    height: 25vh;
    width: 100vw;
    background-color: #0a4f57;
}

body {
    background-color: #669999;
}

.carousel-item img {
    max-height: 50vh;
}

#carousel {
    position: relative;
    width: 100vw;
    height: 50vh;
}

#title {
    background-color: #0a4f57;
    color: white;
    font-size: 10vh;
    text-align: center;
    position: relative;
    top: 50%;
    transform: translateY(-50%);
    font-family: 'Yellowtail', cursive;
}
</style>

</html>