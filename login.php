<?php

if ( isset( $_GET['action'] ) ) {
    if ( $_GET['action'] == 'logout' ) {
        unset( $_SESSION['user_session'] );
        if ( session_destroy() ) {
            header( "Location: login.php" );
        }
    }
}

if($_SERVER["REQUEST_METHOD"] == "POST") {

    $warning = "";

    if(empty($_POST['email']) OR empty($_POST['password'])){
        $warning = "Please fulfill all fields";
    }elseif (!isset($_POST['email']) OR !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) OR !isset($_POST['password'])){
        $warning = "Something is wrong";
    }else{
        $email = test_input($_POST['email']);
        $password = test_input($_POST['password']);

        try {

            $db = new PDO('sqlite:../databases/database.sqlite');

            if(!$db){
                $warning='Unable to open a connection to the database';
            }else {
                $query = "SELECT * FROM users WHERE email = '$email';";
                $result = $db->query($query);

                $temp1 = "";
                $temp2 = "";

                if ($result) {
                    foreach ($result as $row) {
                        $temp1 = $row['email'];
                        $temp2 = $row['password'];
                    }


                    if ($temp1 == $email AND $temp2 == $password) {
                        header("Location: signup.php");
                    } else {
                        $warning = "Wrong credentials";
                    }
                }
            }


        } catch (PDOException $e) {
            echo $e->getMessage();
        }

    }
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>

<?php include_once 'includes/header.php'; ?>

  <body class="bg-dark">

    <div class="container">
      <div class="card card-login mx-auto mt-5">
        <div class="card-header">Login</div>
        <div class="card-body">

            <div class="panel">
                <p>Please enter your email and password</p>
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
          <div class="text-center">
            <a class="d-block small mt-3" href="register.php">Register an Account</a>
          </div>
        </div>
      </div>
    </div>

<?php include_once 'includes/footer.php'; ?>