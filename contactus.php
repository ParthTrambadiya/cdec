<?php
    include 'header.php';
    require_once "./Database/CSRF.php";
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
                        <a class="nav-link menu font-baloo color-black font-weight-bold px-3" href="aboutus">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-baloo color-black font-weight-bold px-3 activemenu" href="contactus">Contact Us</a>
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
    <main id="main-part" class="contactus">
        <div class="container">
            <div class="row pt-5 mt-3">
                <div class="col-12 text-center">
                    <h1 class="font-roboto font-weight-bold text-white font-size-40 mt-5 text-uppercase">Contact Us</h1>
                    <h1 class="font-roboto font-weight-bold text-white font-size-50 wm-contactus text-uppercase">Contact Us</h1>
                </div>
            </div>
            <div class="row">
                <div class="card border-0 w-100 mt-3 mb-5 mx-auto" style="box-shadow: .1px 1px 10px 0 rgba(255, 255, 255, 1);" data-aos="fade-up" data-aos-duration="1000">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 col-lg-7 d-flex align-items-center justify-content-center px-5">
                                <img src="./assets/contact_us.svg" class="img-fluid">
                            </div>
                            <div class="col-sm-12 col-lg-5">
                                <form action="./Database/contact.php" method="post" id="contactform">
                                    <?php CSRF::create_token(); ?>
                                    <div class="row form-group font-baloo">
                                        <div class="col-md-12 mb-3 mb-md-0">
                                            <label class="color-second" for="fullname">Full Name</label>
                                            <input type="text" id="fullnameCTemp" name="fnameCTemp" class="form-control rounded" maxlength="25">
                                            <input type="text" id="fullnameC" name="fnameC" hidden class="form-control rounded">
                                        </div>
                                    </div>

                                    <div class="row form-group font-baloo">
                                        <div class="col-md-12">
                                            <label class="color-second" for="email">Email</label>
                                            <input type="email" id="emailCTemp" name="emailCTemp" class="form-control rounded" maxlength="30">
                                            <input type="email" id="emailC" name="emailC" hidden class="form-control rounded">
                                        </div>
                                    </div>

                                    <div class="row form-group font-baloo">
                                        <div class="col-md-6">
                                            <label class="color-second" for="sid">Student ID</label>
                                            <input type="sid" id="sidCTemp" name="sidCTemp" class="form-control rounded" maxlength="15">
                                            <input type="sid" id="sidC" name="sidC" hidden class="form-control rounded">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="color-second" for="subject">Subject</label>
                                            <input type="subject" id="subjectCTemp" name="subjectCTemp" class="form-control rounded" maxlength="30">
                                            <input type="subject" id="subjectC" name="subjectC" hidden class="form-control rounded">
                                        </div>
                                    </div>

                                    <div class="row form-group font-baloo">
                                        <div class="col-md-12">
                                            <label class="color-second" for="message">Message</label>
                                            <textarea id="messageCTemp" name="messageCTemp" cols="30" rows="7" class="form-control rounded" maxlength="200" placeholder="Write your notes or questions here..."></textarea>
                                            <textarea id="messageC" name="messageC" cols="30" rows="7" hidden class="form-control rounded" placeholder="Write your notes or questions here..."></textarea>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-md-12">
                                            <button type="submit" name="sendbtn" class="btn btn-hover color text-white font-baloo">Send Message</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
<?php
    include 'footer.php';
?>