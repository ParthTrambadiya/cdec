<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CDEC</title>
    <link rel="icon" href="./assets/logo.png">

    <!--Bootstrap CSS CDN-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <!--Custom CSS-->
    <link rel="stylesheet" href="style.css">
    <style>
        .unmain
        {
            background: url("./assets/bg.jpg") no-repeat;
            background-size: cover;
        }
        .row
        {
            height: 100vh;
        }
    </style>
</head>
<body>
    <!--Main-Site-->
    <!--Preloader-->
    <div class="preloader">
        <div class="boxes">
            <div class="box">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
            <div class="box">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
            <div class="box">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
            <div class="box">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </div>
    <!--!Preloader-->
    <main id="main-part">
        <div class="container-fluid unmain">
            <div class="row align-items-center justify-content-center">
                <div class="col-md-7 m-auto text-center text-white">
                    <img src="./assets/cube.gif" class="d-block mx-auto img-fluid">
                    <h3 class="text-center font-baloo py-3">Thanks for participating, result will be declared soon.</h3>
                    <!--<a href="index"><button class="btn btn-hover color font-baloo">Go to Home</button></a>-->
                </div>
            </div>
        </div>
    </main>
    <!--!Main-Site-->
    <!--JS-->
    <script src="./jquery-3.3.1.min.js"></script>
    <script src="./jquery-migrate-3.0.1.min.js"></script>

    <!--Bootstrap JS CDN-->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

    <script>
        window.addEventListener("load", function(){
            const loader = document.querySelector(".preloader");
            loader.className += " hidden";
        });
    </script>
</body>
</html>