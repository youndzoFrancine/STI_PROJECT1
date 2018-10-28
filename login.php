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

<?php
session_start();
include_once 'includes/config.php';

if ( isset( $_GET['action'] ) ) {
    if ( $_GET['action'] == 'logout' ) {
        unset( $_SESSION['user'] );
        if ( session_destroy() ) {
            header( "Location: " . __APP_URL . "/login.php" );
        }
    }
}

// Make sure the HTTP method is POST
if($_SERVER["REQUEST_METHOD"] == "POST") {

    // Both email & password should have been sent
    if (isset($_POST['email']) && !empty($_POST['email']) &&
        isset($_POST['password']) && !empty($_POST['password'])) {

        // Validate email input
        if (false === filter_var($_POST['email'], FILTER_SANITIZE_EMAIL)) {
            $warning = "bad email";
        } else {

            // Store POST vars
            $email = trim($_POST['email']);
            $password = $_POST['password'];

            // Init DB connection
            $db = new PDO('sqlite:../databases/' . __DB_NAME);
            $stmt = $db->prepare("SELECT * FROM `users` WHERE email = '" . $email . "' AND isActiv = '1' LIMIT 1;");

            // Something bad happened
            if (!$stmt->execute()) {
                echo "<pre>";
                print_r($stmt->errorInfo());
                echo "</pre>";

                exit(1);
            }

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!empty($user['password']) && $user['password'] == $password) {
                $_SESSION['user']['id']   = $user['id'];
                $_SESSION['user']['email'] = $user['email'];
                $_SESSION['user']['isAdmin'] = $user['isAdmin'];

                $format = 'Y-m-d H:i:s';
                $now =  date ($format);
                $stmt = $db->prepare("UPDATE users SET lastLoginDate = '" . $now . "' WHERE id = " . $_SESSION['user']['id'] . ";");

                // Something bad happened
                if (!$stmt->execute()) {
                    echo "<pre>";
                    print_r($stmt->errorInfo());
                    echo "</pre>";

                    exit(1);
                }

                header("Location: " . __APP_URL);
            } else {
                $warning = 'Mmm sorry, wrong email / password combination';
            }
        }
    } else {
        $warning = "Bad login";
    }
}

?>

<?php include_once 'includes/header.php'; ?>

  <body class="bg-dark">

    <div class="container">
      <div class="card card-login mx-auto mt-5">
        <div class="card-header">Login</div>
        <div class="card-body">

            <div class="panel">
                <p><span class="warning" name="warning"><?php echo (isset($warning) ? $warning : ''); ?></span> </p>
            </div>

          <form action="login.php" method="POST">
            <div class="form-group">
              <div class="form-label-group">
                <input name="email" value="<?php echo (isset($email) ? $email : ''); ?>" type="email" id="inputEmail" class="form-control" placeholder="Email address" required="required" autofocus="autofocus">
                <label for="inputEmail">Email address</label>
              </div>
            </div>
            <div class="form-group">
              <div class="form-label-group">
                <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Password" required="required">
                <label for="inputPassword">Password</label>
              </div>
            </div>
            <input type="submit" value="Login" class="btn btn-primary btn-block">
          </form>
        </div>
      </div>
    </div>

<?php include_once 'includes/footer.php'; ?>