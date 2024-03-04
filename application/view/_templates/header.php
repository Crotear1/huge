<!doctype html>
<html>
<head>
    <title>HUGE</title>
    <!-- META -->
    <meta charset="utf-8">
    <!-- send empty favicon fallback to prevent user's browser hitting the server for lots of favicon requests resulting in 404s -->
    <link rel="icon" href="data:;base64,=">
    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo Config::get('URL'); ?>css/style.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">


</head>
<body>
    <!-- wrapper, to center website -->
    <div class="wrapper">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="<?php echo Config::get('URL'); ?>index/index">Meine Webseite</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item <?php if (View::checkForActiveController($filename, "index")) { echo 'active'; } ?>">
                <a class="nav-link" href="<?php echo Config::get('URL'); ?>index/index">Index</a>
            </li>
            <li class="nav-item <?php if (View::checkForActiveController($filename, "profile")) { echo 'active'; } ?>">
                <a class="nav-link" href="<?php echo Config::get('URL'); ?>profile/index">Profiles</a>
            </li>
            <?php if (Session::userIsLoggedIn()) { ?>
                <li class="nav-item <?php if (View::checkForActiveController($filename, "dashboard")) { echo 'active'; } ?>">
                    <a class="nav-link" href="<?php echo Config::get('URL'); ?>dashboard/index">Dashboard</a>
                </li>
                <li class="nav-item <?php if (View::checkForActiveController($filename, "note")) { echo 'active'; } ?>">
                    <a class="nav-link" href="<?php echo Config::get('URL'); ?>note/index">My Notes</a>
                </li>
            <?php } else { ?>
                <!-- for not logged in users -->
                <li class="nav-item <?php if (View::checkForActiveControllerAndAction($filename, "login/index")) { echo 'active'; } ?>">
                    <a class="nav-link" href="<?php echo Config::get('URL'); ?>login/index">Login</a>
                </li>
            <?php } ?>
        </ul>
           <!-- my account -->
        <ul class="navigation right" style="margin-left: auto;" >
            <?php if (Session::userIsLoggedIn()) : ?>
                <li <?php if (View::checkForActiveController($filename, "user")) { echo ' class="active" '; } ?> >
                    <a href="<?php echo Config::get('URL'); ?>user/index">My Account</a>
                    <ul class="navigation-submenu">
                        <li <?php if (View::checkForActiveController($filename, "user")) { echo ' class="active" '; } ?> >
                            <a href="<?php echo Config::get('URL'); ?>user/changeUserRole">Change account type</a>
                        </li>
                        <li <?php if (View::checkForActiveController($filename, "user")) { echo ' class="active" '; } ?> >
                            <a href="<?php echo Config::get('URL'); ?>user/editAvatar">Edit your avatar</a>
                        </li>
                        <li <?php if (View::checkForActiveController($filename, "user")) { echo ' class="active" '; } ?> >
                            <a href="<?php echo Config::get('URL'); ?>user/editusername">Edit my username</a>
                        </li>
                        <li <?php if (View::checkForActiveController($filename, "user")) { echo ' class="active" '; } ?> >
                            <a href="<?php echo Config::get('URL'); ?>user/edituseremail">Edit my email</a>
                        </li>
                        <li <?php if (View::checkForActiveController($filename, "user")) { echo ' class="active" '; } ?> >
                            <a href="<?php echo Config::get('URL'); ?>user/changePassword">Change Password</a>
                        </li>
                        <li <?php if (View::checkForActiveController($filename, "login")) { echo ' class="active" '; } ?> >
                            <a href="<?php echo Config::get('URL'); ?>login/logout">Logout</a>
                        </li>
                    </ul>
                </li>
                <?php if (Session::get("user_account_type") == 7) : ?>
                    <li <?php if (View::checkForActiveController($filename, "admin")) {
                        echo ' class="active" ';
                    } ?> >
                        <a href="<?php echo Config::get('URL'); ?>admin/">Admin</a>
                    </li>
                    <li <?php if (View::checkForActiveController($filename, "register/index")) { echo ' class="active" '; } ?> >
                        <a href="<?php echo Config::get('URL'); ?>register/index">Register</a>
                    </li>
                <?php endif; ?>
            <?php endif; ?>
            </ul>
        </div>
    </nav>


