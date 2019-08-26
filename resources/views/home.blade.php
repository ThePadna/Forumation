<html>

<head>

    <link href="https://fonts.googleapis.com/css?family=Permanent+Marker&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<div id="header">
        <h1> Forumation! </h1>
</div>
<div id="center-page">
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
                    <h5>First slide label</h5>
                    <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="{{URL::to('/')}}/img/image2.jpg" class="d-block w-100 img-fluid" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Second slide label</h5>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="{{URL::to('/')}}/img/image3.jpg" class="d-block w-100 img-fluid" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Third slide label</h5>
                    <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur.</p>
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
    <div class="col-sm-6" style="background-color:yellow;">
      <p>Lorem ipsum...</p>
    </div>
    <div class="col-sm-6" style="background-color:pink;">
      <p>Sed ut perspiciatis...</p>
    </div>
  </div>
</div>
<style>
body {
    background-color: #669999;
}
.carousel-item img {
    max-height: 600px;
}

#header {
    text-align: center;
}


#header h1 {
    font-size: 100px;
    font-family: 'Permanent Marker', cursive;
}

#center-page {
    width: 100%;
    height: 40%;
    background-color: gray;
}

#carousel {
    border: 20px solid white;
    border-left: 0;
    border-right: 0;
    position: relative;
    width: 100%;
}
</style>

</html>