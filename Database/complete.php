<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CDEC</title>

    <link rel="icon" href="../assets/logo.png">

    <!--Bootstrap CSS CDN-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <style>
        .complete {
            background: linear-gradient(135deg, #25aae1, #4481eb, #04befe, #3f86ed);
        }
    </style>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
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
<!--OTP-->
<section class="complete">
    <div class="container">
        <div class="row align-items-center justify-content-center" style="height: 100vh;">
            <div class="col-md-7">
                <div class="card" style="box-shadow: .1px 1px 10px 0 rgba(255, 255, 255, 1);">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-center">
                                    <img src="../assets/logo.png" class="img-fluid my-3" style="max-width: 45px; max-height: 45px;">
                                    <h1 class="font-audiowide my-3">CDEC</h1>
                                </div>
                                <h1 class="text-center color-blue font-roboto mb-4">Congratulation</h1>
                                <h3 class="text-center font-baloo mb-3">You have completed the event, we will announce the result soon.</h3>
                                <a href="logout.php" class="text-decoration-none"><button class="btn btn-hover color d-block mx-auto">Logout</button></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--!OTP-->
<!--JS-->
<script src="../jquery-3.3.1.min.js"></script>
<script src="../jquery-migrate-3.0.1.min.js"></script>

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
