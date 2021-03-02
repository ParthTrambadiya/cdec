<?php
    include 'header.php';
    require './Database/DB_Config.php';
    $session = new DB_Config();
    $session_id = session_id();
    if((!isset($_SESSION['checklogin']))) {
        header("location:index");
    }
    
    if(isset($_SESSION['level']) && $_SESSION['level'] == 100) {
        header("location:./Database/complete");
    }
    $session->conn = null;
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
                        <a class="nav-link menu font-baloo color-black font-weight-bold px-3" href="contactus">Contact Us</a>
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
                                    <a class="nav-link activemenu font-baloo color-black font-weight-bold px-3" href="session">Session</a>
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
    <main id="main-part" class="session">
        <section class="sessionPart">
            <div class="container-fluid w-100">
                <div class="row align-items-center font-baloo top-nav pt-5 mt-5 px-5">
                    <div class="col-sm-12 col-lg-4">
                        <div class="level text-center text-lg-left py-2 py-lg-0">
                            <h3>Level - <span id="levelNo"><?php echo $_SESSION['level']?></span></h3>
                            <h6 id="levelName"></h6>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-4">
                        <div class="time text-center py-2 py-lg-0">
                            <h5>Time Remaining</h5>
                        <div class="counter"></div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-4 py-2 py-lg-0 d-flex justify-content-center justify-content-lg-end">
                        <div class="userprofile">
                            <div class="d-flex align-items-baseline justify-content-center">
                                <div class="px-2 text-center d-flex">
                                    <div>
                                        <h5>Rank:&nbsp;</h5>
                                    </div>
                                    <div>
                                        <span id="rank"></span>
                                    </div>
                                </div>
                                <span>&nbsp;|&nbsp;</span>
                                <div class="pl-2 pr-3 text-center d-flex">
                                    <div>
                                        Credits:&nbsp;
                                    </div>
                                    <div>
                                        <span id="credits"><?php echo $_SESSION['credits']?>&nbsp;</span>
                                    </div>
                                    <i class="fas fa-info-circle" data-toggle="tooltip" data-placement="auto" title="This can be used for revealing the hint. Each hint will cost 1 credit."></i>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="d-flex align-items-baseline pb-2 dropdown" data-toggle="dropdown" role="button">
                                    <i class="fas fa-user-circle fa-2x"></i>
                                    <h5 class="px-2">Hi,&nbsp;<span class="username"><?php echo $_SESSION['fnameUser']?>&nbsp;<?php echo $_SESSION['lnameUser']?></span></h5>
                                    <i class="fas fa-chevron-circle-down"></i>
                                </div>
                                <div class="dropdown-menu border-0 rounded-0 profile-dropdown">
                                    <a class="dropdown-item" href="#">
                                        <div class="d-flex align-items-center flex-column overflow-hidden">
                                            <?php echo $_SESSION['fnameUser']?>&nbsp;<?php echo $_SESSION['lnameUser']?>
                                        </div>
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item text-center" href="./Database/logout.php"><i class="fas fa-sign-out-alt px-1"></i>Logout</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid font-baloo w-100 bg-white">
                <div class="row px-4 py-4">
                    <div class="col-sm-12 col-lg-10">
                        <div class="questiontext p-2 p-lg-3 text-center">
                            <div class="question">
                                <div class="card">
                                    <div class="card-body">
                                        <h1 class="font-roboto">Question</h1>
                                        <img src="./assets/levelImg/" style="max-height: 200px; width: auto" class="imgHide img-fluid d-none mx-auto" data-display="0" id="imgQus">
                                        <a id="downloadImg" href="./assets/levelImg/" class="text-decoration-none d-none" data-display="0" download><button class="btn btn-hover mt-2 color">Download</button></a>
                                        <p class="mt-2" id="question"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="anspart text-center mt-4">
                            <form method="post" id="answer">
                                <div class="form-group px-4">
                                    <label for="ans" class="h1 font-roboto">Answer</label>
                                    <input type="text" class="form-control" id="ans" rows="1" placeholder="Write your answer....">
                                </div>
                                <span class="font-baloo text-left" id="hintspan"></span>
                            </form>
                            <div>
                                <button class="btn btn-hover color my-1 my-lg-0 mx-2" form="answer" id="qusBtn">Submit</button>
                                <button class="btn btn-hover color my-1 my-lg-0 mx-2" id="hintwarning"><i class="fas fa-lightbulb"></i>&nbsp;Hint</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-lg-2">
                        <h1 class="cdectitle font-audiowide text-uppercase h-75 text-center font-weight-bolder" style="font-size: 100px;">Cdec</h1>
                    </div>
                </div>
            </div>
            <!--<div class="container">
                <div class="row">
                    <div class="col-12">
                        <hr style="background-color: #fff; box-shadow: 0px 0px 3px #007bff;">
                    </div>
                </div>
            </div>-->
            <a id="myLink" class="font-baloo" data-toggle="modal" data-target=".instruction" role="button">Instruction</a>
            <div class="modal fade instruction m-auto" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content rounded-0">
                        <div class="row">
                            <div class="col-12">
                                <div class="text-right">
                                        <span class="btn" data-dismiss="modal">
                                            <i class="fas fa-times-circle"></i>
                                        </span>
                                </div>
                                <h1 class="font-roboto text-center py-4">Instructions</h1>
                                <div class="shadow-none px-5 py-3">
                                    <ul class="font-baloo">
                                        <li>In case of multiple answers try all of them anyone would be the answer and don't report that another one is correct too. It is set so as to make you feel like a hunt.</li>
                                        <li>Please don't try to refresh your page.</li>
                                        <li>Please be comfortable with the page, look at all the widget and be comfortable with it.</li>
                                        <li>Hints, level name and level no., credits everything is displayed over there on the top bar.</li>
                                        <li>At the top center, counter timer is displayed which shows the remaining time.</li>
                                        <li>Once the timer will be at 00.00.00 automatically the user will get auto-logout after a message display.</li>
                                        <li>Kindly don't try to login after the event has ended. Doing such may disqualify you from the event. As, we can track your login activities.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
<script src="./jquery-3.3.1.min.js"></script>
<script src="./qus.js"></script>
<?php
    include 'footer.php';
?>