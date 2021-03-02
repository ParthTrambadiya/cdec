<?php
    include 'header.php';
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
                            <a class="nav-link menu color-black font-baloo font-weight-bold px-3" href="result">Result</a>
                        </li>
                        <?php
                    }
                    ?>
                    <li class="nav-item">
                        <a class="nav-link font-baloo color-black font-weight-bold px-3 activemenu" href="aboutus">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu font-baloo color-black font-weight-bold px-3" href="contactus">Contact Us</a>
                    </li>
                    <?php
                    if(isset($_SESSION['checklogin']))
                    {
                        ?>
                        <li class="nav-item">
                            <a class="nav-link menu font-baloo color-black font-weight-bold px-3" href="session">Session</a>
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
    <main id="main-part" class="aboutus">
        <div class="container">
            <div class="row pt-5 mt-3">
                <div class="col-12 text-center">
                    <h1 class="font-roboto font-weight-bold text-white font-size-40 mt-5 text-uppercase">About Us</h1>
                    <h1 class="font-roboto font-weight-bold text-white font-size-50 wm-aboutus text-uppercase">About Us</h1>
                </div>
            </div>
            <div class="row pt-3">
                <div class="col-md-4 col-sm-12 col-xs-12 light">
                    <div class="our-team mx-auto" data-aos="fade-up" data-aos-duration="1000">
                        <div class="picture">
                            <img class="img-fluid" src="./assets/team/shivam.jpg">
                        </div>
                        <div class="team-content">
                            <h6 class="name font-baloo font-weight-bold text-capitalize">Shivam Bhanvadia</h6>
                            <h6 class="title font-baloo">Lead</h6>
                        </div>
                        <ul class="social">
                            <li><a href="https://www.linkedin.com/in/shivam-bhanvadia/" target="_blank" aria-hidden="true"><i class="fab fa-linkedin-in"></i></a></li>
                            <li><a href="https://www.instagram.com/shivam_bhanvadia/" target="_blank" aria-hidden="true"><i class="fab fa-instagram"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12 col-xs-12 light">
                    <div class="our-team mx-auto" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="150">
                        <div class="picture">
                            <img class="img-fluid" src="./assets/team/bhavna.jpg">
                        </div>
                        <div class="team-content">
                            <h6 class="name font-baloo font-weight-bold text-capitalize">Bhavna Tahelyani</h6>
                            <h6 class="title font-baloo">Full Stack Developer</h6>
                        </div>
                        <ul class="social">
                            <li><a href="https://www.linkedin.com/in/bhavna-tahelyani" target="_blank" aria-hidden="true"><i class="fab fa-linkedin-in"></i></a></li>
                            <li><a href="https://www.instagram.com/t.bhavna.288_/" target="_blank" aria-hidden="true"><i class="fab fa-instagram"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12 col-xs-12 light">
                    <div class="our-team mx-auto" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="300">
                        <div class="picture">
                            <img class="img-fluid" src="./assets/team/parth.jpg">
                        </div>
                        <div class="team-content">
                            <h6 class="name font-baloo font-weight-bold text-capitalize">Parth Trambadiya</h6>
                            <h6 class="title font-baloo">Full Stack Developer</h6>
                        </div>
                        <ul class="social">
                            <li><a href="https://www.linkedin.com/in/parth-trambadiya" target="_blank" aria-hidden="true"><i class="fab fa-linkedin-in"></i></a></li>
                            <li><a href="https://www.instagram.com/_parth_jt" target="_blank" aria-hidden="true"><i class="fab fa-instagram"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row pt-3">
                <div class="col-md-4 col-sm-12 col-xs-12 light">
                    <div class="our-team mx-auto" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="150">
                        <div class="picture">
                            <img class="img-fluid" src="./assets/team/hardik.jpg">
                        </div>
                        <div class="team-content">
                            <h6 class="name font-baloo font-weight-bold text-capitalize">Hardik Thakor</h6>
                            <h6 class="title font-baloo">Backend Developer</h6>
                        </div>
                        <ul class="social">
                            <li><a href="https://www.linkedin.com/in/hardik-thakor-1a97a61a4" target="_blank" aria-hidden="true"><i class="fab fa-linkedin-in"></i></a></li>
                            <li><a href="https://instagram.com/thakor_hardik_2309?igshid=1qjhqldhn3tq3" target="_blank" aria-hidden="true"><i class="fab fa-instagram"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12 col-xs-12 light">
                    <div class="our-team mx-auto" data-aos="fade-up" data-aos-duration="1000">
                        <div class="picture">
                            <img class="img-fluid" src="./assets/team/harsh.jpg">
                        </div>
                        <div class="team-content">
                            <h6 class="name font-baloo font-weight-bold text-capitalize">Harsh Kansagra</h6>
                            <h6 class="title font-baloo">Graphics Designer</h6>
                        </div>
                        <ul class="social">
                            <li><a href="https://www.linkedin.com/in/harsh-kansagra-1501b219a" target="_blank" aria-hidden="true"><i class="fab fa-linkedin-in"></i></a></li>
                            <li><a href="https://www.instagram.com/harsh17_03/" target="_blank" aria-hidden="true"><i class="fab fa-instagram"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12 col-xs-12 light">
                    <div class="our-team mx-auto" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="300">
                        <div class="picture">
                            <img class="img-fluid" src="./assets/team/yash.jpg">
                        </div>
                        <div class="team-content">
                            <h6 class="name font-baloo font-weight-bold text-capitalize">Yash Vaghani</h6>
                            <h6 class="title font-baloo">Frontend Developer</h6>
                        </div>
                        <ul class="social">
                            <li><a href="https://www.linkedin.com/in/yash-vaghani-9535a51a7" target="_blank" aria-hidden="true"><i class="fab fa-linkedin-in"></i></a></li>
                            <li><a href="https://instagram.com/itz._.yashvaghani?igshid=10xl2r7e0g0rv" target="_blank" aria-hidden="true"><i class="fab fa-instagram"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row pt-3">
                <div class="col-md-4 col-sm-12 col-xs-12 light">
                    <div class="our-team mx-auto" data-aos="fade-up" data-aos-duration="1000">
                        <div class="picture">
                            <img class="img-fluid" src="./assets/team/keyur.jpg">
                        </div>
                        <div class="team-content">
                            <h6 class="name font-baloo font-weight-bold text-capitalize">Keyur Talati</h6>
                            <h6 class="title font-baloo">Cybersecurity Expert</h6>
                        </div>
                        <ul class="social">
                            <li><a href="https://www.linkedin.com/in/keyur-talati-99801b179" target="_blank" aria-hidden="true"><i class="fab fa-linkedin-in"></i></a></li>
                            <li><a href="https://www.instagram.com/keyur_talati_/" target="_blank" aria-hidden="true"><i class="fab fa-instagram"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12 col-xs-12 light">
                    <div class="our-team mx-auto" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="150">
                        <div class="picture">
                            <img class="img-fluid" src="./assets/team/aniket.jpg">
                        </div>
                        <div class="team-content">
                            <h6 class="name font-baloo font-weight-bold text-capitalize">Aniket Patel</h6>
                            <h6 class="title font-baloo">Backend Developer</h6>
                        </div>
                        <ul class="social">
                            <li><a href="https://www.linkedin.com/in/aniket-patel-2a52851a3" target="_blank" aria-hidden="true"><i class="fab fa-linkedin-in"></i></a></li>
                            <li><a href="https://www.instagram.com/p/B7JOC42J0iIZ7V6vsCKCin5DZ7NZolagdLwqMk0/?igshid=1b5q6o5b31z72" target="_blank" aria-hidden="true"><i class="fab fa-instagram"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12 col-xs-12 light">
                    <div class="our-team mx-auto" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="300">
                        <div class="picture">
                            <img class="img-fluid" src="./assets/team/meet.jpg">
                        </div>
                        <div class="team-content">
                            <h6 class="name font-baloo font-weight-bold text-capitalize">Meet Suvariya</h6>
                            <h6 class="title font-baloo">Frontend Developer</h6>
                        </div>
                        <ul class="social">
                            <li><a href="https://www.linkedin.com/in/meet-suvariya-65b286194" target="_blank" aria-hidden="true"><i class="fab fa-linkedin-in"></i></a></li>
                            <li><a href="https://www.instagram.com/meetpatel2506/" target="_blank" aria-hidden="true"><i class="fab fa-instagram"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <h3 class="font-baloo text-center py-3 text-white" data-aos="fade-up" data-aos-duration="1000">Backed By</h3>
                </div>
            </div>
            <div class="row pt-2 pb-5">
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 pt-4 ml-auto prolight">
                    <div class="our-team mx-auto w-75" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="150">
                        <div class="picture">
                            <img class="img-fluid" src="./assets/team/rpp.jpg">
                        </div>
                        <div class="team-content">
                            <h6 class="name font-weight-bold text-capitalize font-baloo px-2">Dr. Ritesh Patel</h6>
                            <h6 class="title font-baloo text-capitalize">Convener</h6>
                        </div>
                        <ul class="social">
                            <li><a href="https://www.linkedin.com/in/ritesh-patel-462b0b11/" target="_blank" aria-hidden="true"><i class="fab fa-linkedin-in"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 pt-4 mr-auto prolight">
                    <div class="our-team mx-auto w-75" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="300">
                        <div class="picture">
                            <img class="img-fluid" src="./assets/team/dab.jpg">
                        </div>
                        <div class="team-content">
                            <h6 class="name font-weight-bold text-capitalize font-baloo px-2">Prof. Dhaval Bhoi</h6>
                            <h6 class="title font-baloo text-capitalize">Coordinator</h6>
                        </div>
                        <ul class="social">
                            <li><a href="https://www.linkedin.com/in/dhaval-bhoi-64114bab/" target="_blank" aria-hidden="true"><i class="fab fa-linkedin-in"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>

<?php
    include 'footer.php';
?>