<?php

/**
 * @file        copyright.php
 *
 * @description This file is the sidebar of the application. There are the links for the different
 *              pages of the application and for the logout.
 *
 * @version     PHP version 5.5.9
 *
 * @author      Francine Vanessa Youndzo Kengne
 * @author      Cyril de Bourgues
 * @author      Nuno Miguel Cerca Abrantes Sivla
 */
?>

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
            <a class="dropdown-item" href="messages.php?dir=inbox">Inbox</a>
            <a class="dropdown-item" href="messages.php?dir=sent">Sent</a>
            <a class="dropdown-item" href="formulaire.php?dir=sent">Compose</a>
        </div>
    </li>

    <?php if (isAdmin()) { ?>

    <li class="nav-item active">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-fw fa-folder"></i>
            <span>Utilisateurs</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
            <a class="dropdown-item" href="users.php">Lister</a>
            <a class="dropdown-item" href="register.php">Ajouter</a>
        </div>
    </li>

    <?php } else { ?>

    <li class="nav-item active">
        <a class="nav-link" href="register.php?action=passwd&uID=<?php echo $_SESSION['user']['id']; ?>">
            <i class="fas fa-fw fa-table"></i>
            <span>Change password</span></a>
    </li>

    <?php } ?>

    <li class="nav-item active">
        <a class="nav-link" href="login.php?action=logout">
            <i class="fas fa-fw fa-table"></i>
            <span>Logout</span></a>
    </li>
</ul>