<nav class="navbar navbar-expand navbar-dark bg-dark static-top">

    <a class="navbar-brand mr-1" href="<?php echo __APP_URL; ?>"><?php echo __SITE_NAME; ?></a>
    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
        <i class="fas fa-bars"></i>
    </button>

    <div class="float-right">
        <span style="color: white;"><?php echo $_SESSION['user']['email']; ?></span>
    </div>
</nav>