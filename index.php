<?php

/**
 * @file        login.php
 *
 * @description This file displays the login page. It verifies that the user has entered an email address.
 *              Then it makes a request to the database to check if the user credentials are correct or not.
 *              If the credentials are correct the home page is displayed otherwise an error message is
 *              displayed in the login page.
 *
 * @version     PHP version 5.5.9
 *
 * @author      Francine Vanessa Youndzo Kengne
 * @author      Cyril de Bourgues
 * @author      Nuno Miguel Cerca Abrantes Sivla
 */
?>

<?php include_once 'includes/auth.php'; ?>
<?php include_once 'includes/header.php'; ?>

  <body id="page-top">

  <?php include_once 'includes/banner.php'; ?>

    <div id="wrapper">

    <?php include_once 'includes/sidebar.php'; ?>

      <div id="content-wrapper">

        <div class="container-fluid">

        </div>
        <!-- /.container-fluid -->

        <?php include_once 'includes/copyright.php'; ?>

      </div>
      <!-- /.content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>

  <?php include_once 'includes/footer.php'; ?>
