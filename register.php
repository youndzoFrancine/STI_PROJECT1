<?php

include_once 'includes/config.php';

// define variables and set to empty values
$email = $password = $confirmPwd = "";
$emailErr = $newPwdErr = $confirmPwdErr = $warning = " ";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if(empty($_POST['email']) OR empty($_POST['newPwd']) OR empty($_POST['confirmPwd'])){
        $warning="Please fulfill all fields";
    }

    if (!isset($_POST['email'])) {
        $emailErr = "Email is required";
    } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
        $emailErr = "Email is invalid";
    } else {
        $email = test_input($_POST['email']);
    }

    $password = test_input($_POST["newPwd"]);
    $confirmPwd = test_input($_POST["confirmPwd"]);

    if ($password !== $confirmPwd) {
        $confirmPwdErr = "Password is different";
    } else{
        try {

            isset($_POST['Admin']) ? $isAdmin = 1 : $isAdmin = 0;
            $format = 'Y-m-d H:i:s';
            //$timestamp = time();
            $registerDate =  date ($format);
            $lastLoginDate = $registerDate;
            //$temp1 = date ($format);
            //$temp2 = date ($format);

            $warning = date ($format);
            if(empty($warning) || !isset($warning)){
                throw new PDOException($warning);
            }

            $db = new PDO('sqlite:../databases/' . __DB_NAME);
            

            $isActive = 0;

            $user = array(
                'id' => $id,
                'email' => $email,
                'password' => $password,
                'registerDate' => $registerDate,
                'lastLoginDate' => $lastLoginDate,
                'isAdmin' => $isAdmin,
                'isActiv' => $isActive
            );

            $db = new PDO('sqlite:../databases/' . __DB_NAME);
            $query = "INSERT INTO users (`email`, `password`, `registerDate`, `lastLoginDate`, `isAdmin`, `isActiv`) 
                      VALUES ('".$user['email']."','".$user['password']."','".$user['registerDate']."','".$user['lastLoginDate']."',".$user['isAdmin'].",".$user['isActiv'].");";
            $stmt = $db->prepare($query);
            $result = $stmt->execute();

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}

//des commentaires, du remplissage par des espaces et les
// noms de domaine sans point qui ne sont pas pris en charge.
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<?php include_once 'includes/auth.php'; ?>
<?php include_once 'includes/header.php'; ?>

<body id="page-top">

<?php include_once 'includes/banner.php'; ?>

<div id="wrapper">

<?php include_once 'includes/sidebar.php'; ?>

    <div id="content-wrapper">

    <div class="container">
      <div class="card card-register mx-auto mt-5">
        <div class="card-header">Register an Account</div>
        <div class="card-body">
          <form action="register.php" method="POST">
            <div class="form-group">
              <div class="form-label-group">
                <input value="<?php echo (isset($email) ? $email : ''); ?>" name="email" type="email" id="inputEmail" class="form-control" placeholder="Email address" required="required">
                  <label class="error"><?php echo $emailErr;?></label>
                <label for="inputEmail">Email address</label>
              </div>
            </div>
            <div class="form-group">
              <div class="form-row">
                <div class="col-md-6">
                  <div class="form-label-group">
                    <input value="<?php echo (isset($password) ? $password : ''); ?>" name="newPwd" type="password" id="inputPassword" class="form-control" placeholder="Password" required="required">
                      <label class="error"><?php echo $newPwdErr;?></label>
                    <label for="inputPassword">Password</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-label-group">
                    <input value="<?php echo (isset($confirmPwd) ? $confirmPwd : ''); ?>" name="confirmPwd" type="password" id="confirmPassword" class="form-control" placeholder="Confirm password" required="required">
                      <label class="error"><?php echo $confirmPwdErr;?></label>
                    <label for="confirmPassword">Confirm password</label>
                  </div>
                </div>
              </div>
            </div>
              <div class="form-group">
                  <label class="label-text">Administrator: </label>
                  <input type="checkbox" name="Admin" id="Admin" class="Admin" value="Admin"><br/>
              </div>
              <input class="btn btn-primary btn-block" type="submit" value="Register" />
          </form>
        </div>
      </div>
    </div>
    <!-- /#wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

<?php include_once 'includes/footer.php'; ?>