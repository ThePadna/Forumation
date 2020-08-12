<html>

<head>
    <link rel="stylesheet" href="{{asset('css/home.css')}}">
    <script src="{{asset('js/forum_layout.js')}}"> </script>
</head>
<div id="header">
    <h1 id="title"> Forumation </h1>
</div>
<div class="carousel-wrapper">
<div id="carousel" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#carousel" data-slide-to="0" class="active"></li>
        <li data-target="#carousel" data-slide-to="1"></li>
        <li data-target="#carousel" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="{{asset('img/untitled.png')}}" class="d-block w-100 img-fluid" alt="...">
            <div class="carousel-caption d-none d-md-block">
                <h5 style="color: white;">Elegance</h5>
            </div>
        </div>
        <div class="carousel-item">
            <img src="{{asset('img/untitled.png')}}" class="d-block w-100 img-fluid" alt="...">
            <div class="carousel-caption d-none d-md-block">
                <h5>Highly Customizable</h5>
            </div>
        </div>
        <div class="carousel-item">
            <img src="{{asset('img/untitled.png')}}" class="d-block w-100 img-fluid" alt="...">
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

</html>