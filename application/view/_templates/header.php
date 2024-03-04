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
<!-- Bootstrap JS, Popper.js, and jQuery -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

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
           <nav class="navbar navbar-expand-lg ml-auto navbar-light bg-light">

            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ml-auto">
                <?php if (Session::userIsLoggedIn()) : ?>
                    <li class="nav-item dropdown <?php if (View::checkForActiveController($filename, "user")) { echo ' active'; } ?>">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        My Account
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="<?php echo Config::get('URL'); ?>user/changeUserRole">Change account type</a>
                        <a class="dropdown-item" href="<?php echo Config::get('URL'); ?>user/editAvatar">Edit your avatar</a>
                        <a class="dropdown-item" href="<?php echo Config::get('URL'); ?>user/editusername">Edit my username</a>
                        <a class="dropdown-item" href="<?php echo Config::get('URL'); ?>user/edituseremail">Edit my email</a>
                        <a class="dropdown-item" href="<?php echo Config::get('URL'); ?>user/changePassword">Change Password</a>
                        <a class="dropdown-item" href="<?php echo Config::get('URL'); ?>login/logout">Logout</a>
                    </div>
                    </li>
                    <?php if (Session::get("user_account_type") == 7) : ?>
                    <li class="nav-item <?php if (View::checkForActiveController($filename, "admin")) { echo ' active'; } ?>">
                        <a class="nav-link" href="<?php echo Config::get('URL'); ?>admin/">Admin</a>
                    </li>
                    <li class="nav-item <?php if (View::checkForActiveController($filename, "register/index")) { echo ' active'; } ?>">
                        <a class="nav-link" href="<?php echo Config::get('URL'); ?>register/index">Register</a>
                    </li>
                    <?php endif; ?>
                <?php endif; ?>
                </ul>
            </div>
            </nav>
        </div>
    </nav>


