<?php
    include 'header.php';
//    if(!isset($_SESSION['checklogin'])) {
//        header("location:index.php");
//    }
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
                        <a class="nav-link font-baloo color-black font-weight-bold px-3 activemenu" href="leaderboard">Leaderboard</a>
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
    <main id="main-part" class="leaderboard">
        <div class="container">
            <div class="row pt-5 mt-3">
                <div class="col-12 text-center">
                    <h1 class="font-roboto font-weight-bold text-white font-size-40 mt-5 text-uppercase">Leaderboard</h1>
                    <h1 class="font-roboto font-weight-bold text-white font-size-50 wm-leaderboard text-uppercase">Leaderboard</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card my-3 border-0" data-aos="fade-up" data-aos-duration="1000">
                        <div class="card-header text-center">
                            <div class="w-75 m-auto">
                                <div class="row form-group font-baloo mb-3">
                                    <div class="col-md-6">
                                        <label class="font-baloo">Institute</label>
                                        <select name="instLB" id="instLB" role="listbox" class="form-control rounded custom-select">
                                            <option value="all">All</option>
                                            <option value="CSPIT">CSPIT</option>
                                            <option value="DEPSTAR">DEPSTAR</option>
                                            <option value="CMPICA">CMPICA</option>
                                            <option value="RPCP">RPCP</option>
                                            <option value="IIIM">IIIM</option>
                                            <option value="PDPIAS">PDPIAS</option>
                                            <option value="ARIP">ARIP</option>
                                            <option value="MTIN">MTIN</option>
                                            <option value="CIPS">CIPS</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="font-baloo">Department</label>
                                        <select name="deptLB" id="deptLB" role="listbox" class="form-control rounded custom-select">
                                            <option value="">First Select Institue</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6 mx-auto">
                                    <div class="form-group">
                                        <div class="input-group d-flex justify-content-center justify-content-lg-end">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="searchIcon"><i class="fas fa-search"></i></span>
                                            </div>
                                            <input type="text" class="form-control" placeholder="Search here..." name="search_text" maxlength="20" id="search_text" aria-describedby="searchIcon">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 text-center font-baloo my-2">
                                    Please avoid plagiarism. We are strictly monitoring and no prize would be given in case of plagiarism even if you are at top 3.
                                </div>
                            </div>
                            <table id="leaderboardtb" style="max-height: 100vh; overflow-y: auto;" class="table table-hover text-center font-baloo table-responsive table-striped table-light">
                                <thead class="thead-dark" style="position: sticky; position: -webkit-sticky; top: 0;">
                                    <tr>
                                        <th style="width: 140px;">Rank</th>
                                        <th style="width: 120px;">Level</th>
                                        <th style="width: 380px;">Name</th>
                                        <th style="width: 190px;">StudentID</th>
                                        <th style="width: 170px;">Institute</th>
                                        <th style="width: 170px;">Department</th>
                                    </tr>
                                </thead>
                                <?php
                                date_default_timezone_set("Asia/Calcutta");
                                $date1 = new DateTime();
                                $d1 = $date1->format('Y-m-d H:i:s');

                                $date2 = new DateTime('2020-09-12 09:00:00');
                                $d2 = $date2->format('Y-m-d H:i:s');
                                if ($d1 >= $d2)
                                {
                                    ?>
                                    <tbody id="tbodyLB">

                                    </tbody>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <tbody id="tbodyOfLB">
                                        <tr>
                                            <td colspan="6">
                                                Hold on! until the event start  ;)
                                            </td>
                                        </tr>
                                    </tbody>
                                    <?php
                                }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

<!--!Main-Site-->
<!--Footer-->
<footer id="footer"class="ft">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-lg-4 text-center py-4">
                <h3 class="font-roboto">Follow Us</h3>
                <div class="mt-4 font-baloo color-blue">
                    <span class="px-3"><a href="https://www.instagram.com/cdeccharusat" target="_blank" class="text-decoration-none"><i class="fab fa-instagram fa-2x"></i></a></span>
                    <span class="px-3"><a href="https://www.linkedin.com/company/cdeccharusat/" target="_blank" class="text-decoration-none"><i class="fab fa-linkedin-in fa-2x"></i></a></span>
                    <span class="px-3"><a href="https://youtu.be/c2rLLhOw9PE" target="_blank" class="text-decoration-none"><i class="fab fa-youtube fa-2x"></i></a></span>
                </div>
            </div>
            <div class="col-sm-12 col-lg-4 text-center">
                <div class="d-flex justify-content-center">
                    <img src="./assets/logo.png" class="img-fluid my-5" style="max-width: 45px; max-height: 45px;">
                    <h1 class="font-audiowide my-5">CDEC</h1>
                </div>
            </div>
            <div class="col-sm-12 col-lg-4 text-center py-4">
                <h3 class="font-roboto">Powered By</h3>
                <div class="d-flex justify-content-center">
                    <a href="https://www.charusat.ac.in/" target="_blank"><img src="./assets/charusat.png" class="img-fluid d-block mx-auto" style="max-width: 250px;"></a>
                    &nbsp;&nbsp;
                    <a href="http://www.csi-india.org/" target="_blank"><img src="./assets/csilogo.png" class="img-fluid d-block mx-auto" style="max-width: 65px;"></a>
                </div>
            </div>
        </div>
        <div class="row copyright">
            <div class="col-12 text-center">
                <h6 class="font-baloo py-3">Copyright &copy; <script>document.write(new Date().getFullYear());</script> All rights reserved | <span class="font-audiowide">&nbsp;<img src="./assets/logo.png" class="img-fluid">CDEC</span></h6>
            </div>
        </div>
    </div>
</footer>
<!--!Footer-->

<!--JS-->
<script src="./jquery-3.3.1.min.js"></script>
<script src="./jquery-migrate-3.0.1.min.js"></script>

<script>
    setInterval(function() {
        var s_id = $('#sessionid').text();
        var email_user = $('#emailuser').text();
        //let hashId = CryptoJS.AES.encrypt(s_id, key, {iv: iv, padding: CryptoJS.pad.ZeroPadding}).toString();

        $.ajax({
            url: "./Database/check_session.php",
            type: "POST",
            data: {
                session: s_id,
                email: email_user
            },
            success: function(data) {
                if(data == "destroy") {
                    location.href = "./Database/logout.php";
                }
            },
            error: function(error) {
                console.log(responseText);
            }
        })
    }, 60000);
</script>

<!--Bootstrap JS CDN-->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

<!--Jquery Countdown JS-->
<script src="./plugins/responsive-flip-countdown/jquery.flipper-responsive.js"></script>

<!--Stellar JS-->
<script src="./plugins/stellar/jquery.stellar.min.js"></script>

<!--tilt.js-->
<script type="text/javascript" src="./plugins/tilt.js/vanilla-tilt.js"></script>

<!--Swiper Carousel-->
<script src="./plugins/swiper/swiper.min.js"></script>

<!--AOS-->
<script src="./plugins/aos/aos.js"></script>

<!--Bottom to Top-->
<script src="./plugins/Scroll-To-Top-Button/dist/jquery-backToTop.min.js"></script>

<!--Sweetalert-->
<script src="./plugins/sweetalert.min.js"></script>

<!--Floating Btn-->
<script src="./plugins/FloatingBtn/docked-link.js"></script>

<!--validation-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/additional-methods.min.js"></script>

<!--Floating Social-->
<script src="./plugins/floating-sidebar-social-contact/js/jquery.socialfloating.js"></script>

<!--Session Timer-->
<script src="./plugins/counter/npy-scorecount/npy-scorecount.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js" integrity="sha512-nOQuvD9nKirvxDdvQ9OMqe2dgapbPB7vYAMrzJihw5m+aNcf0dX53m6YxM4LgA9u8e9eg9QX+/+mPu8kCNpV2A==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/aes.min.js" integrity="sha512-eqbQu9UN8zs1GXYopZmnTFFtJxpZ03FHaBMoU3dwoKirgGRss9diYqVpecUgtqW2YRFkIVgkycGQV852cD46+w==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/enc-hex.min.js" integrity="sha512-jDU0YCduSP8z0cvjfPFm7/zN/viOcmNWlq0GUIcjVhuv4WoKcMppghamg4aeuBtJaA0wjtYfxwQjPpVuYGEsBA==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/pad-zeropadding.min.js" integrity="sha512-txZjFJoDvbM8FJj9HuAHasxA/M76UjnMCXLHwuciIGDKUW9EB9PJVA6foG0vymuK9hu2gdpL60imO9VrTlEF7w==" crossorigin="anonymous"></script>

<script src="lb.js"></script>
<!--Custom JS-->
<script src="./mainn.js"></script>
</body>
</html>
