<?php

/**
 * @file        index.php
 *
 * @description This page is the home page. It is displayed after the login or when the user clicks on
 *              home link in the sidebar.
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

            <div class="row">
                <div class="col-auto">
                    <h4>Welcome back <?php echo $_SESSION['user']['email']; ?> !</h4>
                </div>
            </div>

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
