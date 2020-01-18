<head>
    <link rel="stylesheet" href="{{asset('css/admin.css')}}">
    <link rel="stylesheet" href="../../node_modules/@simonwep/pickr/dist/themes/classic.min.css">
</head>
<div id="container">
    <div id="settings">
        <div id="Example">
            <h1> Color Scheme </h1>
                <label class="switch">
                    <input type="checkbox" />
                    <div></div>
                </label>
        </div>
        <div id="color-scheme">
            <h1> Color Scheme </h1>
            <div class="pickr"> To be replaced </div>
        </div>
        

    </div>
    <div id="menu" class="row">
        <div class="col-sm-4">
            <a href="">
                <p> Users </p>
            </a>
        </div>
        <div class="col-sm-4">
            <a href="">
                <p> Threads </p>
            </a>
        </div>
        <div class="col-sm-4">
            <a href="">
                <p> Purge </p>
            </a>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"> </script>
<script type="module" src="../../node_modules/@simonwep/pickr"></script>
<meta name="csrf" content="{{csrf_token()}}">
<script src="{{asset('js/admin.js')}}"> </script>