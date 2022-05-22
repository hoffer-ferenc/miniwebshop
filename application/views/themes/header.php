<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>miniwebshop</title>
    <meta name="description" content="miniwebshop"/>
        <!--======== All Stylesheet =========-->
        <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">
        <script src="<?php echo base_url(); ?>assets/js/jquery-2.1.1.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
        <script src="https://kit.fontawesome.com/d6c7bf5478.js" crossorigin="anonymous"></script>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light" style="margin-bottom: 30px;">
    <a class="navbar-brand" href="<?php echo base_url('products'); ?>">Miniwebshop</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="<?php echo base_url('products'); ?>">Termékek</a>
            </li>
            <li class="cart">
                <a class="nav-link" href="<?php echo base_url('checkout'); ?>">
                    <i class="fas fa-shopping-cart"></i>
                    <span id="cart_value"><?php echo count($this->cart->contents()); ?></span>
                </a>
            </li>
            <?php if (isset($_SESSION['username']) && $_SESSION['logged_in'] === true) : ?>
                <li class="nav-item">
                    <a class="nav-link" href="#">Rendeléseim</a>
                </li>        
                <li class="logout">
                    <a class="nav-link" href="<?php echo base_url('logout'); ?>">Kijelentkezés</a>
                </li>
            <?php else : ?>
                <li class="register">
                    <a class="nav-link" href="<?php echo base_url('register'); ?>">Regisztráció</a>
                </li>
                <li class="login">
                    <a class="nav-link" href="<?php echo base_url('login'); ?>">Bejelentkezés</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>
