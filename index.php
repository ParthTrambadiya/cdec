<?php
include './header.php';
require_once './Database/CSRF.php';
$session_id = session_id();
?>
        <!--Navbar-->
        <header id="header" class="hd">
            <nav class="navbar navbar-expand-lg fixed-top">
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
                <a class="navbar-brand font-baloo" href="index">
                    <img src="./assets/logo.png" width="40" height="40" class="d-inline-block align-top" alt="" loading="lazy">
                    <span class="font-audiowide font-size-27">CDEC</span>
                </a>
                <button class="navbar-toggler color-blue-bg" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mx-auto py-2">
                        <li class="nav-item">
                            <a class="nav-link font-baloo font-weight-bold font-weight-bold px-3 activemenu" href="index">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu font-baloo font-weight-bold font-weight-bold px-3" href="leaderboard">Leaderboard</a>
                        </li>
                        <?php
                        $d1 = '';
                        $d2 = '';
                        include './Database/resultTime.php';
                        if($d1 > $d2)
                        {
                            ?>
                            <li class="nav-item">
                                <a class="nav-link menu font-baloo font-weight-bold px-3" href="result">Result</a>
                            </li>
                            <?php
                        }
                        ?>
                        <li class="nav-item">
                            <a class="nav-link menu font-baloo font-weight-bold px-3" href="aboutus">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu font-baloo font-weight-bold px-3" href="contactus">Contact Us</a>
                        </li>
                        <?php
                            if(isset($_SESSION['checklogin']))
                            {
                                ?>
                                <div id="checkSession" style="display: none">
                                    <div id="isLoggedIn">true</div>
                                    <div id="sessionCheck">
                                    <?php echo $session_id;
                                    ?>
                                    </div>
                                    <div id="sessionEmail">
                                    <?php if(isset($_SESSION['emailUser'])) {
                                        echo $_SESSION['emailUser'];
                                    }
                                    ?>
                                    </div>
                                </div>
                                <li class="nav-item">
                                    <a class="nav-link menu font-baloo font-weight-bold px-3" href="session">Session</a>
                                </li>
                                <?php
                            } else {
                                ?>
                                <div id="checkSession" style="display: none">
                                    <div id="isLoggedIn">false</div>
                                </div>
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
        <main id="main-part">
            <!--Landing Photo-->
            <div class="landing-photo overlay" id="banner-part" style="background: url('./assets/bg1.jpg');" data-stellar-background-ratio="0.5">
                <div class="container">
                    <div class="row pt-5 align-items-center justify-content-center">
                        <div class="col-md-8 m-auto">
                            <div class="d-flex align-items-center justify-content-center">
                                <img src="./assets/logo.png" class="img-fluid" style="max-width: 67px; max-height: 67px;">
                                <h1 class="text-white font-audiowide font-size-70 text-center">CDEC</h1>
                            </div>
                            <h1 class="text-white font-roboto py-3 text-center">Now login is opened.</h1>
                            <!--<div class="flipper mx-5"-->
                            <!--     data-datetime="2020-09-12 09:00:00"-->
                            <!--     data-template="dd|HH|ii|ss"-->
                            <!--     data-labels="Days|Hours|Minutes|Seconds"-->
                            <!--     data-reverse="true" id="myFlipper" style="font-family: 'Baloo Thambi 2', cursive;;">-->
                            <!--</div>-->

                            <div class="font-baloo learn-more">
                                <h2 class="color-primary text-center text-white">Explore More</h2>
                            </div>

                            <a href="#about-event" class="arrow">
                                <div class="box">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <?php
                            if (isset($_SESSION['checklogin']))
                            {
                                ?>
                                <div class="login py-4 px-3 mb-3 text-center">
                                    <h6 class="font-baloo text-center">Hi,user</h6>
                                    <h5 class="text-center font-baloo">Enjoy Knowledge Fight</h5>
                                    <h4 class="font-baloo text-center pt-2"><?php echo $_SESSION['fnameUser']?> <?php echo $_SESSION['lnameUser']?></h4>
                                    <a href="./Database/logout.php"><button class="btn btn-hover color">Logout</button></a>
                                </div>
                                <?php
                            }
                            else
                            {
                                ?>
                                <div class="login py-4 px-3 mb-3">
                                    <h4 class="font-roboto text-right">Welcome back,</h4>
                                    <h6 class="font-roboto text-right">Please Sign in into your account</h6>
                                    <form id="loginHome" method="post" class="font-baloo">
                                        <?php CSRF::create_token(); ?>
                                        <div class="form-group">
                                            <input type="email" class="form-control email shadow-none" id="emailHome" maxlength="35" required>
                                            <label for="email">Email</label>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control password shadow-none" id="passwordHome" maxlength="20" required>
                                            <label for="password">Password</label>
                                            <span id="eye" style="position: absolute; right: 10px; top: 10px;">
                                                <i class="fa fa-eye"></i>
                                            </span>
                                            <a href="forgotpswd" class="text-decoration-none"><small>Forgot Password?</small></a>
                                        </div>
                                        <button type="submit" id="homeLoginbtn" class="btn btn-hover color d-block mx-auto">Login</button>
                                    </form>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <!--!Landing Photo-->

            <!--About Event-->
            <section id="about-event" class="aboutevent">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <h1 class="font-roboto font-size-50 text-center mt-5 color-blue text-uppercase">About CDec</h1>
                            <h1 class="font-roboto font-size-60 wm-aboutcdec text-uppercase">About CDec</h1>
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-lg-6 gif-container" >
                            <img src="./assets/event.gif" class="img-fluid cdecevent my-4 " data-aos="fade-up" data-aos-duration="1000" data-tilt>
                        </div>
                        <div class="col-sm-12 col-lg-6 py-5 text-justify" style="align-self: center" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="700">
                            <p class="font-baloo px-3">
                                Developed in 2020, CDEC is an acronym of Charusat Decryptonite
                                which is an Informational Technology-based decrypt hunt for all
                                the CHARUSAT students despite from Tech or Non-Tech Branches where
                                an individual will compete with each other to challenge their own
                                potential.
                            </p>
                            <p class="font-baloo px-3">
                                It is a 36-hours decrypt hunt. Consisting of 100 levels in the form
                                of riddles. Answer to which is in the form of the fill in the blank.
                                Hints would be provided but it will cost the credits.
                            </p>
                            <p class="font-baloo px-3">
                                The event will be hosted on the 12-13th September 2020 (Sat 9am to Sun 9pm).
                            </p>
                        </div>
                    </div>
                </div>
            </section>
            <!--!About Event-->

            <!--Department Slider-->
            <section id="department" class="dept">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <h1 class="font-roboto font-size-50 text-center text-white mt-5 text-uppercase">Institutes</h1>
                            <h1 class="font-roboto font-size-60 wm-department text-uppercase">Institutes</h1>
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="swiper-container mt-4">
                                <div class="swiper-wrapper mb-5">
                                    <div class="swiper-slide">
                                        <div class="carousel-card py-4 px-3 d-flex align-items-center justify-content-center">
                                            <img src="./assets/department/1.jpeg" class="img-fluid">
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="carousel-card py-4 px-3 d-flex align-items-center justify-content-center">
                                            <img src="./assets/department/2.jpeg" class="img-fluid d-block mx-auto">
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="carousel-card py-4 px-3 d-flex align-items-center justify-content-center">
                                            <img src="./assets/department/3.jpeg" class="img-fluid d-block mx-auto">
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="carousel-card py-4 px-3 d-flex align-items-center justify-content-center">
                                            <img src="./assets/department/4.jpeg" class="img-fluid d-block mx-auto">
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="carousel-card py-4 px-3 d-flex align-items-center justify-content-center">
                                            <img src="./assets/department/5.jpeg" class="img-fluid d-block mx-auto">
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="carousel-card py-4 px-3 d-flex align-items-center justify-content-center">
                                            <img src="./assets/department/6.jpeg" class="img-fluid d-block mx-auto">
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="carousel-card py-4 px-3 d-flex align-items-center justify-content-center">
                                            <img src="./assets/department/7.jpeg" class="img-fluid d-block mx-auto">
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="carousel-card py-4 px-3 d-flex align-items-center justify-content-center">
                                            <img src="./assets/department/8.jpeg" class="img-fluid d-block mx-auto">
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="carousel-card py-4 px-3 d-flex align-items-center justify-content-center">
                                            <img src="./assets/department/9.jpeg" class="img-fluid d-block mx-auto">
                                        </div>
                                    </div>
                                </div>
                                <!-- If we need pagination -->
                                <div class="swiper-pagination"></div>

                                <!-- If we need navigation buttons -->
                                <div class="swiper-button-prev"></div>
                                <div class="swiper-button-next"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!--!Department Slider-->

            <!--Banner Contact-->
            <section id="banner-contact" class="b-contact overlay" style="background: url('./assets/bg2.jpg');">
                <div class="container-fluid">
                    <div class="row align-items-center justify-content-center">
                        <div class="col-md-7" data-aos="fade-up" data-aos-duration="1000">
                            <h1 class="text-center text-white font-baloo">For any query</h1><br>
                            <a href="contactus" class="text-decoration-none"><button class="btn btn-hover color text-white font-baloo d-block mr-auto ml-auto">Contact Us</button></a>
                        </div>
                    </div>
                </div>
            </section>
            <!--!Banner Contact-->
        </main>
<?php
    include 'footer.php';
?>