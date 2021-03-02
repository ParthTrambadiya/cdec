<?php
    include 'header.php';
    header("location:unmain");
?>
    <!--Navbar-->
    <header id="header" class="hd">
        <nav class="navbar navbar-expand-lg fixed-top bg-white">
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
            <a class="navbar-brand font-baloo color-black" href="index">
                <img src="./assets/logo.png" width="40" height="40" class="d-inline-block align-top" alt="" loading="lazy">
                <span class="font-audiowide font-size-27">CDEC</span>
            </a>
            <button class="navbar-toggler color-blue-bg" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto py-2">
                    <li class="nav-item">
                        <a class="nav-link menu font-baloo font-weight-bold color-black px-3" href="index">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu font-baloo color-black font-weight-bold px-3" href="leaderboard">Leaderboard</a>
                    </li>
                    <?php
                    $d1 = '';
                    $d2 = '';
                    include './Database/resultTime.php';
                    if($d1 > $d2)
                    {
                        ?>
                        <li class="nav-item">
                            <a class="nav-link color-black font-baloo font-weight-bold activemenu px-3" href="result">Result</a>
                        </li>
                        <?php
                    }
                    ?>
                    <li class="nav-item">
                        <a class="nav-link menu font-baloo color-black font-weight-bold px-3" href="aboutus">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu font-baloo color-black font-weight-bold px-3" href="contactus">Contact Us</a>
                    </li>
                    <?php
                    if(isset($_SESSION['checklogin']))
                    {
                        ?>
                        <li class="nav-item">
                            <a class="nav-link font-baloo menu color-black font-weight-bold px-3" href="session">Session</a>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
                <?php
                if(!isset($_SESSION['checklogin']))
                {
                    ?>
                    <button class="btn btn-hover color font-baloo" data-toggle="modal" data-target=".registerModal">Register Now</button>
                    <?php
                }
                ?>
            </div>
        </nav>

        <?php include './modals.php'?>
    </header>
    <!--!Navbar-->
    <!--Main-Site-->
    <main id="main-part" class="result">
        <div class="container">
            <div class="row pt-5 mt-3">
                <div class="col-12 text-center">
                    <h1 class="font-roboto font-weight-bold text-white font-size-40 mt-5 text-uppercase">Result</h1>
                    <h1 class="font-roboto font-weight-bold text-white font-size-50 wm-result text-uppercase">Result</h1>
                </div>
            </div>
            <div class="row mt-5 pb-5">
                <div class="col-sm-12 col-lg-4 col-xl-4 py-2 py-lg-0">
                    <div class="rank-card w-75 m-auto rank-two" data-aos="fade-up" data-aos-duration="1000">
                        <img src="./assets/rank2.png" class="rank-img">
                        <img src="./assets/resultimg.jpg" class="rank-card-img">
                        <div class="rank-card-name"><h1>Parth Trambadiya</h1></div>
                        <div class="rank-card-institute text-uppercase"><i class="fas fa-university px-1"></i><span>cspit</span></div>
                        <div class="rank-card-dept text-uppercase"><i class="fas fa-building px-1"></i><span>ce</span></div>
                        <div class="rank-card-sid text-uppercard"><i class="fas fa-portrait px-1"></i><span></span>18ce130</div>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-4 col-xl-4 py-2 py-lg-0">
                    <div class="rank-card w-75 m-auto rank-one" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                        <img src="./assets/rank1.png" class="rank-img">
                        <img src="./assets/resultimg.jpg" class="rank-card-img">
                        <div class="rank-card-name"><h1>Parth Trambadiya</h1></div>
                        <div class="rank-card-institute text-uppercase"><i class="fas fa-university px-1"></i><span>cspit</span></div>
                        <div class="rank-card-dept text-uppercase"><i class="fas fa-building px-1"></i><span>ce</span></div>
                        <div class="rank-card-sid text-uppercard"><i class="fas fa-portrait px-1"></i><span></span>18ce130</div>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-4 col-xl-4 py-2 py-lg-0">
                    <div class="rank-card w-75 m-auto rank-three" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
                        <img src="./assets/rank3.png" class="rank-img">
                        <img src="./assets/resultimg.jpg" class="rank-card-img">
                        <div class="rank-card-name"><h1>Parth Trambadiya</h1></div>
                        <div class="rank-card-institute text-uppercase"><i class="fas fa-university px-1"></i><span>cspit</span></div>
                        <div class="rank-card-dept text-uppercase"><i class="fas fa-building px-1"></i><span>ce</span></div>
                        <div class="rank-card-sid text-uppercard"><i class="fas fa-portrait px-1"></i><span></span>18ce130</div>
                    </div>
                </div>
            </div>
        </div>

        <!--Confetti.js-->
        <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.2.0/dist/confetti.browser.min.js"></script>

        <script>
            var end = Date.now() + (15 * 100001);

            // go Buckeyes!
            var colors = ['#ff0000', '#ffffff', '#0017ff', '#ffff00', '#27ff00', '#ff0074', '#b200ff'];

            (function frame() {
                confetti({
                    particleCount: 7,
                    angle: 60,
                    spread: 50,
                    origin: { x: 0 },
                    colors: colors
                });
                confetti({
                    particleCount: 7,
                    angle: 120,
                    spread: 50,
                    origin: { x: 1 },
                    colors: colors
                });

                if (Date.now() < end) {
                    requestAnimationFrame(frame);
                }
            }());
        </script>
    </main>
<?php
    include 'footer.php';
?>
