<?php

    include_once("db-config.php");

$dbObj = new DBConfig();

$pdo = $dbObj->getPdo();
    session_start();
    $session_id = session_id();
    
    $table_check = $pdo->prepare("SELECT * FROM admin");
    $table_check->execute();
    $result = $table_check->rowCount();
	if($result == 0) {
        // return TRUE;
        header("Location: index.php");
    } else {
        $adm = $table_check->fetch();
        $admin = $adm['email'];
    }
    
    if(!isset($_SESSION['email']) || $_SESSION['email'] != $admin) {
        header("Location: logout.php");
    }

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Messages - CDEC</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="Admin - Levels - CDEC">
    <meta name="msapplication-tap-highlight" content="no">

    <link rel="stylesheet" href="./assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="./assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="./assets/plugins/toastr/build/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js" integrity="sha512-nOQuvD9nKirvxDdvQ9OMqe2dgapbPB7vYAMrzJihw5m+aNcf0dX53m6YxM4LgA9u8e9eg9QX+/+mPu8kCNpV2A==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/aes.min.js" integrity="sha512-eqbQu9UN8zs1GXYopZmnTFFtJxpZ03FHaBMoU3dwoKirgGRss9diYqVpecUgtqW2YRFkIVgkycGQV852cD46+w==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/enc-hex.min.js" integrity="sha512-jDU0YCduSP8z0cvjfPFm7/zN/viOcmNWlq0GUIcjVhuv4WoKcMppghamg4aeuBtJaA0wjtYfxwQjPpVuYGEsBA==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/pad-zeropadding.min.js" integrity="sha512-txZjFJoDvbM8FJj9HuAHasxA/M76UjnMCXLHwuciIGDKUW9EB9PJVA6foG0vymuK9hu2gdpL60imO9VrTlEF7w==" crossorigin="anonymous"></script>
    <script src="./assets/plugins/jquery/jquery.min.js"></script>
    <script src="./assets/plugins/popper/umd/popper.min.js"></script>
    <script src="./assets/plugins/toastr/build/toastr.min.js"></script>
    <link rel="stylesheet" href="./assets/plugins/summernote/summernote-lite.min.css">

<link href="./main.css" rel="stylesheet">
<link rel="stylesheet" href='./assets/plugins/select2/css/select2.min.css'>
</head>
<body>
    <div id="checkSession" style="display: none">
        <div id="sessionCheck">
        <?php echo $session_id;
        ?>
        </div> 
    </div>
    <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
        <div class="app-header header-shadow">
            <div class="app-header__logo">
                <div class="logo-src mb-3">
                    <img src="./assets/images/logo.png" class="ml-2">
                </div>
                <div class="header__pane ml-auto">
                    <div>
                        <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="app-header__mobile-menu">
                <div>
                    <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                    </button>
                </div>
            </div>
            <div class="app-header__menu">
                <span>
                    <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                        <span class="btn-icon-wrapper">
                            <i class="fa fa-ellipsis-v fa-w-6"></i>
                        </span>
                    </button>
                </span>
            </div>    <div class="app-header__content">
                <div class="app-header-right">
                    <div class="header-btn-lg pr-0">
                        <div class="widget-content p-0">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left">
                                    <div class="btn-group">
                                        <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn">
                                            <img width="42" class="rounded-circle" src="assets/images/avatars/<?php echo $_SESSION['img'];?>" alt="">
                                            <i class="fa fa-angle-down ml-2 opacity-8"></i>
                                        </a>
                                        <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
                                            <a href="account.php" tabindex="0" class="dropdown-item">Admin Account</a>
                                            <div tabindex="-1" class="dropdown-divider"></div>
                                            <a href="logout.php" tabindex="0" class="dropdown-item">Logout</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content-left  ml-3 header-user-info">
                                    <div class="widget-heading">
                                        <?php echo $_SESSION['fullname'];?>
                                    </div>
                                    <div class="widget-subheading">
                                        CDEC Administrator
                                    </div>
                                </div>
                                <div class="widget-content-right header-user-info ml-3">
                                    <button type="button" class="btn-shadow p-1 btn btn-primary btn-sm show-toastr-example">
                                        <i class="fa text-white fa-calendar pr-1 pl-1"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>        </div>
            </div>
        </div>        <div class="ui-theme-settings">
            <button type="button" id="TooltipDemo" class="btn-open-options btn btn-warning">
                <i class="fa fa-cog fa-w-16 fa-spin fa-2x"></i>
            </button>
            <div class="theme-settings__inner">
                <div class="scrollbar-container">
                    <div class="theme-settings__options-wrapper">
                        <h3 class="themeoptions-heading">Layout Options
                        </h3>
                        <div class="p-3">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <div class="widget-content p-0">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left mr-3">
                                                <div class="switch has-switch switch-container-class" data-class="fixed-header">
                                                    <div class="switch-animate switch-on">
                                                        <input type="checkbox" checked data-toggle="toggle" data-onstyle="success">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="widget-content-left">
                                                <div class="widget-heading">Fixed Header
                                                </div>
                                                <div class="widget-subheading">Makes the header top fixed, always visible!
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="widget-content p-0">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left mr-3">
                                                <div class="switch has-switch switch-container-class" data-class="fixed-sidebar">
                                                    <div class="switch-animate switch-on">
                                                        <input type="checkbox" checked data-toggle="toggle" data-onstyle="success">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="widget-content-left">
                                                <div class="widget-heading">Fixed Sidebar
                                                </div>
                                                <div class="widget-subheading">Makes the sidebar left fixed, always visible!
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="widget-content p-0">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left mr-3">
                                                <div class="switch has-switch switch-container-class" data-class="fixed-footer">
                                                    <div class="switch-animate switch-off">
                                                        <input type="checkbox" data-toggle="toggle" data-onstyle="success">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="widget-content-left">
                                                <div class="widget-heading">Fixed Footer
                                                </div>
                                                <div class="widget-subheading">Makes the app footer bottom fixed, always visible!
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <h3 class="themeoptions-heading">
                            <div>
                                Header Options
                            </div>
                            <button type="button" class="btn-pill btn-shadow btn-wide ml-auto btn btn-focus btn-sm switch-header-cs-class" data-class="">
                                Restore Default
                            </button>
                        </h3>
                        <div class="p-3">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <h5 class="pb-2">Choose Color Scheme
                                    </h5>
                                    <div class="theme-settings-swatches">
                                        <div class="swatch-holder bg-primary switch-header-cs-class" data-class="bg-primary header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-secondary switch-header-cs-class" data-class="bg-secondary header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-success switch-header-cs-class" data-class="bg-success header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-info switch-header-cs-class" data-class="bg-info header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-warning switch-header-cs-class" data-class="bg-warning header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-danger switch-header-cs-class" data-class="bg-danger header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-light switch-header-cs-class" data-class="bg-light header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-dark switch-header-cs-class" data-class="bg-dark header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-focus switch-header-cs-class" data-class="bg-focus header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-alternate switch-header-cs-class" data-class="bg-alternate header-text-light">
                                        </div>
                                        <div class="divider">
                                        </div>
                                        <div class="swatch-holder bg-vicious-stance switch-header-cs-class" data-class="bg-vicious-stance header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-midnight-bloom switch-header-cs-class" data-class="bg-midnight-bloom header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-night-sky switch-header-cs-class" data-class="bg-night-sky header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-slick-carbon switch-header-cs-class" data-class="bg-slick-carbon header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-asteroid switch-header-cs-class" data-class="bg-asteroid header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-royal switch-header-cs-class" data-class="bg-royal header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-warm-flame switch-header-cs-class" data-class="bg-warm-flame header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-night-fade switch-header-cs-class" data-class="bg-night-fade header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-sunny-morning switch-header-cs-class" data-class="bg-sunny-morning header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-tempting-azure switch-header-cs-class" data-class="bg-tempting-azure header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-amy-crisp switch-header-cs-class" data-class="bg-amy-crisp header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-heavy-rain switch-header-cs-class" data-class="bg-heavy-rain header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-mean-fruit switch-header-cs-class" data-class="bg-mean-fruit header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-malibu-beach switch-header-cs-class" data-class="bg-malibu-beach header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-deep-blue switch-header-cs-class" data-class="bg-deep-blue header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-ripe-malin switch-header-cs-class" data-class="bg-ripe-malin header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-arielle-smile switch-header-cs-class" data-class="bg-arielle-smile header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-plum-plate switch-header-cs-class" data-class="bg-plum-plate header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-happy-fisher switch-header-cs-class" data-class="bg-happy-fisher header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-happy-itmeo switch-header-cs-class" data-class="bg-happy-itmeo header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-mixed-hopes switch-header-cs-class" data-class="bg-mixed-hopes header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-strong-bliss switch-header-cs-class" data-class="bg-strong-bliss header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-grow-early switch-header-cs-class" data-class="bg-grow-early header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-love-kiss switch-header-cs-class" data-class="bg-love-kiss header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-premium-dark switch-header-cs-class" data-class="bg-premium-dark header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-happy-green switch-header-cs-class" data-class="bg-happy-green header-text-light">
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <h3 class="themeoptions-heading">
                            <div>Sidebar Options</div>
                            <button type="button" class="btn-pill btn-shadow btn-wide ml-auto btn btn-focus btn-sm switch-sidebar-cs-class" data-class="">
                                Restore Default
                            </button>
                        </h3>
                        <div class="p-3">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <h5 class="pb-2">Choose Color Scheme
                                    </h5>
                                    <div class="theme-settings-swatches">
                                        <div class="swatch-holder bg-primary switch-sidebar-cs-class" data-class="bg-primary sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-secondary switch-sidebar-cs-class" data-class="bg-secondary sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-success switch-sidebar-cs-class" data-class="bg-success sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-info switch-sidebar-cs-class" data-class="bg-info sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-warning switch-sidebar-cs-class" data-class="bg-warning sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-danger switch-sidebar-cs-class" data-class="bg-danger sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-light switch-sidebar-cs-class" data-class="bg-light sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-dark switch-sidebar-cs-class" data-class="bg-dark sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-focus switch-sidebar-cs-class" data-class="bg-focus sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-alternate switch-sidebar-cs-class" data-class="bg-alternate sidebar-text-light">
                                        </div>
                                        <div class="divider">
                                        </div>
                                        <div class="swatch-holder bg-vicious-stance switch-sidebar-cs-class" data-class="bg-vicious-stance sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-midnight-bloom switch-sidebar-cs-class" data-class="bg-midnight-bloom sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-night-sky switch-sidebar-cs-class" data-class="bg-night-sky sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-slick-carbon switch-sidebar-cs-class" data-class="bg-slick-carbon sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-asteroid switch-sidebar-cs-class" data-class="bg-asteroid sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-royal switch-sidebar-cs-class" data-class="bg-royal sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-warm-flame switch-sidebar-cs-class" data-class="bg-warm-flame sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-night-fade switch-sidebar-cs-class" data-class="bg-night-fade sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-sunny-morning switch-sidebar-cs-class" data-class="bg-sunny-morning sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-tempting-azure switch-sidebar-cs-class" data-class="bg-tempting-azure sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-amy-crisp switch-sidebar-cs-class" data-class="bg-amy-crisp sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-heavy-rain switch-sidebar-cs-class" data-class="bg-heavy-rain sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-mean-fruit switch-sidebar-cs-class" data-class="bg-mean-fruit sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-malibu-beach switch-sidebar-cs-class" data-class="bg-malibu-beach sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-deep-blue switch-sidebar-cs-class" data-class="bg-deep-blue sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-ripe-malin switch-sidebar-cs-class" data-class="bg-ripe-malin sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-arielle-smile switch-sidebar-cs-class" data-class="bg-arielle-smile sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-plum-plate switch-sidebar-cs-class" data-class="bg-plum-plate sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-happy-fisher switch-sidebar-cs-class" data-class="bg-happy-fisher sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-happy-itmeo switch-sidebar-cs-class" data-class="bg-happy-itmeo sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-mixed-hopes switch-sidebar-cs-class" data-class="bg-mixed-hopes sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-strong-bliss switch-sidebar-cs-class" data-class="bg-strong-bliss sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-grow-early switch-sidebar-cs-class" data-class="bg-grow-early sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-love-kiss switch-sidebar-cs-class" data-class="bg-love-kiss sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-premium-dark switch-sidebar-cs-class" data-class="bg-premium-dark sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-happy-green switch-sidebar-cs-class" data-class="bg-happy-green sidebar-text-light">
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <h3 class="themeoptions-heading">
                            <div>Main Content Options</div>
                            <button type="button" class="btn-pill btn-shadow btn-wide ml-auto active btn btn-focus btn-sm">Restore Default
                            </button>
                        </h3>
                        <div class="p-3">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <h5 class="pb-2">Page Section Tabs
                                    </h5>
                                    <div class="theme-settings-swatches">
                                        <div role="group" class="mt-2 btn-group">
                                            <button type="button" class="btn-wide btn-shadow btn-primary btn btn-secondary switch-theme-class" data-class="body-tabs-line">
                                                Line
                                            </button>
                                            <button type="button" class="btn-wide btn-shadow btn-primary active btn btn-secondary switch-theme-class" data-class="body-tabs-shadow">
                                                Shadow
                                            </button>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>        <div class="app-main">
                <div class="app-sidebar sidebar-shadow">
                    <div class="app-header__logo">
                        <img src="assets/images/logo.png">
                        <div class="header__pane ml-auto">
                            <div>
                                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                                    <span class="hamburger-box">
                                        <span class="hamburger-inner"></span>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="app-header__mobile-menu">
                        <div>
                            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                    <div class="app-header__menu">
                        <span>
                            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                                <span class="btn-icon-wrapper">
                                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                                </span>
                            </button>
                        </span>
                    </div>    <div class="scrollbar-sidebar">
                        <div class="app-sidebar__inner">
                            <ul class="vertical-nav-menu mt-4">
                                <li>
                                    <a href="dashboard.php">
                                        <i class="metismenu-icon pe-7s-display2"></i>
                                        Dashboard
                                    </a>
                                </li>
                                <li>
                                    <a href="levels.php">
                                        <i class="metismenu-icon pe-7s-ribbon"></i>
                                        Levels
                                    </a>
                                </li>
                                <li>
                                    <a href="leaderboard.php">
                                        <i class="metismenu-icon pe-7s-graph1"></i>
                                        Leaderboard
                                    </a>
                                </li>
                                <li>
                                    <a href="users.php">
                                        <i class="metismenu-icon pe-7s-user"></i>
                                        Users
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="mm-active">
                                        <i class="metismenu-icon pe-7s-mail"></i>
                                        Messages
                                        <span id="unread_badge">
                                        <?php
                                            $stmt = $pdo->prepare("SELECT count(*) as num FROM contactus WHERE read_stat = 'unread'");
                                            if($stmt->execute()) {
                                                $res = $stmt->fetch();
                                                $num = $res['num'];
                                                if($num > 0) {
                                                    echo "<span class='badge badge-pill badge-success ml-3'>$num</span>";
                                                }
                                            }
                                        ?></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>    <div class="app-main__outer">
                    <div class="app-main__inner">
                        <div class="app-page-title bg-heavy-rain">
                            <div class="page-title-wrapper">
                                <div class="page-title-heading">
                                    <div class="page-title-icon">
                                        <i class="pe-7s-mail icon-gradient bg-warm-flame">
                                        </i>
                                    </div>
                                    <div>Mailbox
                                        <div class="page-title-subheading">Send mails to users and view mails sent by users using contact us form.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav">
                            <li class="nav-item">
                                <a role="tab" class="nav-link" id="tab-0" data-toggle="tab" href="#compose-tab">
                                    <span>Compose</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a role="tab" class="nav-link active" id="tab-1" data-toggle="tab" href="#inbox-tab">
                                    <span>Inbox</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a role="tab" class="nav-link" id="tab-2" data-toggle="tab" href="#sent-tab">
                                    <span>Sent</span>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane tabs-animation fade" id="compose-tab" role="tabpanel">
                                <form id="sendMsgForm" action="sendMail.php" method="POST">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder="Subject" required name="subjectI" id="subjectI">
                                                <input type="text" id="subjectOriginal" name="subject" hidden>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <select class="select2" name="mailToSelect" id="mailToSelect" style="width:100%" required>
                                                    <?php
                                                        $stmt = $pdo->prepare("SELECT id, CONCAT(firstname, ' ', lastname, ' - ', stid) AS fullname FROM users");
                                                        $stmt->execute();
                                                        if($stmt->rowCount() > 0) {
                                                            echo "<option value='allusers'>All users</option>";
                                                            while($user = $stmt->fetch()) {
                                                                ?>
                                                                    <option value="user.<?php echo $user['id'];?>"><?php echo $user['fullname'];?></option>
                                                                <?php
                                                            }
                                                        }
                                                        $stmt = $pdo->prepare("SELECT count(*) as num FROM users WHERE level >= 25 AND level < 50");
                                                        $stmt->execute();
                                                        $num = $stmt->fetch();
                                                        if($num['num'] > 0) {
                                                            echo "<option value='level25up'>Level 25-50 users</option>";
                                                        }
                                                        $stmt = $pdo->prepare("SELECT count(*) as num FROM users WHERE level > 50");
                                                        $stmt->execute();
                                                        $num = $stmt->fetch();
                                                        if($num['num'] > 0) {
                                                            echo "<option value='level50up'>Level 50 up users</option>";
                                                        }
                                                    ?>
                                                </select>
                                                <input type="text" id="mailToOriginal" name="mailTo" hidden>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-xl-12 col-sm-12">
                                            <textarea name="messageI" id="summernote"></textarea>
                                            <textarea name="message" id="messageOriginal" hidden></textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="position-relative form-group m-4">
                                                <label for="schedule" class="form-check-label">
                                                    <input type="checkbox" class="form-check-input" name="schedule" id="schedule" value=1>
                                                    Schedule
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mt-4 schDiv">
                                            <input type="date" class="form-control schInp" id="date" name="dateI">
                                            <input type="text" id="dateOriginal" name="date" hidden>
                                        </div>
                                        <div class="col-md-3 mt-4 schDiv">
                                            <input type="time" class="form-control schInp" id="time" name="timeI">
                                            <input type="text" id="timeOriginal" name="time" hidden>
                                        </div>
                                        <div class="col-md-12 mt-2 mb-5">
                                            <input type="submit" class="btn btn-success btn-lg" id="submitBtn" name="submit" value="Send">
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane tabs-animation fade show active" id="inbox-tab" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-12 col-xl-12 col-sm-12">
                                        <div class="main-card mb-3 card">
                                            <div class="bg-white">
                                                <div class="table-responsive">
                                                    <table class="table table-hover table-lg">
                                                        <thead>
                                                            <tr>
                                                                <th width="15%">Message From</th>
                                                                <th width="65%">Message</th>
                                                                <th width="15%">Asked on</th>
                                                                <th width="15%">Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                                $stmt = $pdo->prepare("SELECT * FROM contactus");
                                                                if($stmt->execute()) {
                                                                    while($row = $stmt->fetch()) {
                                                                ?>
                                                                <tr class="msgRow" data-toggle="modal" data-id="<?php echo $row['id'];?>" data-target="#messageModal">
                                                                    <td>
                                                                        <div class="widget-content p-0">
                                                                            <div class="widget-content-wrapper">
                                                                                <div class="widget-content-left">
                                                                                    <div class="widget-heading"><?php echo $row['fullname'];?></div>
                                                                                    <div class="widget-subheading"><?php echo $row['subject'];?></div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="widget-content-left">
                                                                            <div class="text-left"><?php echo $row['message'];?></div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="widget-content-left">
                                                                            <div class="text-left"><?php echo $row['reg_date'];?></div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div style="font-size: 25px">
                                                                            <?php 
                                                                            if($row['read_stat'] == "read") {
                                                                                echo "<i class='pe-7s-mail-open mail_stat' data-id=" . $row['id'] . "></i>";
                                                                            } else {
                                                                                echo "<i class='pe-7s-mail mail_stat' data-id=" . $row['id'] . "></i>";
                                                                            }
                                                                            ?>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                                    }
                                                                }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane tabs-animation fade" id="sent-tab" role="tabpanel">
                                <div class="row">
                                <div class="col-md-12 col-xl-12 col-sm-12">
                                        <div class="main-card mb-3 card">
                                            <div class="bg-white">
                                                <div class="table-responsive">
                                                    <table class="table table-hover table-lg">
                                                        <thead>
                                                            <tr>
                                                                <th width="15%">Mailed To</th>
                                                                <th width="65%">Message</th>
                                                                <th width="15%">Mailed on</th>
                                                                <th width="15%">Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                                $stmt = $pdo->prepare("SELECT * FROM sendmails");
                                                                if($stmt->execute()) {
                                                                    while($row = $stmt->fetch()) {
                                                                ?>
                                                                <tr class="mailRow" data-toggle="modal" data-id="<?php echo $row['id'];?>" data-target="#sentMessageModal">
                                                                    <td>
                                                                        <div class="widget-content p-0">
                                                                            <div class="widget-content-wrapper">
                                                                                <div class="widget-content-left">
                                                                                    <div class="widget-heading showName">
                                                                                        <?php
                                                                                        if($row['mailto'] == 'level50up') {
                                                                                            echo "Level 50 up users";
                                                                                        } elseif($row['mailto'] == 'level25up') {
                                                                                            echo "Level 25-50 users";
                                                                                        } elseif($row['mailto'] =='allusers') {
                                                                                            echo "All users";
                                                                                        } elseif(substr($row['mailto'], 0, 5) == 'user.') {
                                                                                            $us = $pdo->prepare("SELECT id, CONCAT(firstname, ' ', lastname) AS fullname, stid FROM users WHERE id=?");
                                                                                            $us->execute([substr($row['mailto'], 5)]);
                                                                                            $res = $us->fetch();
                                                                                            echo $res['fullname'] . " " . 
                                                                                            $res['stid'];
                                                                                        }
                                                                                        ?>
                                                                                    </div>
                                                                                    <div class="widget-subheading"><?php echo $row['subject'];?></div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="widget-content-left">
                                                                            <div class="text-left"><?php echo $row['message'];?></div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="widget-content-left">
                                                                            <div class="text-left"><?php echo $row['reg_date'];?></div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div style="font-size: 25px">
                                                                            <?php 
                                                                            if($row['status'] == "sent") {
                                                                                echo "<i class='pe-7s-check'></i>";
                                                                            } else {
                                                                                echo "<i class='pe-7s-loop'></i>";
                                                                            }
                                                                            ?>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                                    }
                                                                }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
          <!-- <script src="http://maps.google.com/maps/api/js?sensor=true"></script> -->
        </div>
    </div>

    <div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="m-1"><b>From: </b><span id="msgFrom" class="ml-2"></span></div>
                    <div class="m-1"><b>Student ID: </b><span id="stId" class="ml-2"></span></div>
                    <div class="m-1"><b>Email: </b><span id="emailMsg" class="ml-2"></span></div>
                    <div class="m-1 my-3"><b><u><span id="subjectMsg" style="font-size: 20px;"></span></b></u></div>
                    <div class="m-1"><span id="message" style="font-size: 16px;"></span></div>
                    <!-- <div>From: <span id="msgFrom"></span></div> -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="sentMessageModal" tabindex="-1" role="dialog" aria-labelledby="my2LargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="m-1"><b>Mail To: </b><span id="msgTo" class="ml-2"></span></div>
                    <div class="m-1"><b>Scheduled: </b><span id="sch" class="ml-2"></span></div>
                    <div class="m-1"><b>Scheduled time: </b><span id="sch-time" class="ml-2"></span></div>
                    <div class="m-1"><b>Message Status: </b><span id="msgStat" class="ml-2"></span></div>
                    <div class="m-1 my-3"><b><u><span id="subjectMail" style="font-size: 20px;"></span></b></u></div>
                    <div class="m-1"><span id="messageM" style="font-size: 16px;"></span></div>
                    <!-- <div>From: <span id="msgFrom"></span></div> -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="./assets/plugins/select2/js/select2.full.min.js"></script>

<script src="./assets/plugins/summernote/summernote-lite.min.js"></script>

<script src="./assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="./assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="./assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="./assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script type="text/javascript" src="./assets/scripts/main.js"></script>
<script type="text/javascript" src="./assets/scripts/messages.js"></script>
<script src="./assets/plugins/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>