<?php include_once 'functions.php'; ?>

<!-- Sidebar -->
<ul class="sidebar navbar-nav">
    <li class="nav-item">
        <a class="nav-link" href="index.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Home</span>
        </a>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-fw fa-folder"></i>
            <span>Messages</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
            <!-- <h6 class="dropdown-header">Login Screens:</h6> -->
            <a class="dropdown-item" href="messages.php?dir=inbox">Inbox</a>
            <a class="dropdown-item" href="messages.php?dir=sent">Sent</a>
            <!-- <div class="dropdown-divider"></div>
            <h6 class="dropdown-header">Other Pages:</h6>
            <a class="dropdown-item" href="404.html">404 Page</a>
            <a class="dropdown-item" href="blank.html">Blank Page</a> -->

        </div>
    </li>

    <?php if (isAdmin()) { ?>

    <li class="nav-item active">
        <a class="nav-link" href="users.php">
            <i class="fas fa-fw fa-table"></i>
            <span>Utilisateurs</span></a>
    </li>

    <?php } ?>

    <li class="nav-item active">
        <a class="nav-link" href="login.php">
            <i class="fas fa-fw fa-table"></i>
            <span>Logout</span></a>
    </li>
</ul>