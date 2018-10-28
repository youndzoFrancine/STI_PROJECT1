<?php

include_once 'includes/auth.php';
include_once 'includes/functions.php';

// define variables and set to empty values
$email = $password = $confirmPwd = $infoMessage = "";
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
        header("Location: " . $_SERVER['PHP_SELF'] . "?result=differentPassword", $email);
    } else{
        try {

            isset($_POST['Admin']) ? $isAdmin = 1 : $isAdmin = 0;
            $format = 'Y-m-d H:i:s';
            $registerDate =  date ($format);
            $lastLoginDate = $registerDate;

            $warning = date ($format);
            if(empty($warning) || !isset($warning)){
                throw new PDOException($warning);
            }

            $db = new PDO('sqlite:../databases/' . __DB_NAME);
            $isActiv = 0;
            $user = array(
                //'id' => $id,
                'email' => $email,
                'password' => $password,
                'registerDate' => $registerDate,
                'lastLoginDate' => $lastLoginDate,
                'isAdmin' => $isAdmin,
                'isActiv' => $isActiv
            );

            $db = new PDO('sqlite:../databases/' . __DB_NAME);

            $query = "INSERT INTO users (`email`, `password`, `registerDate`, `lastLoginDate`, `isAdmin`, `isActiv`) 
                      VALUES ('".$user['email']."','".$user['password']."','".$user['registerDate']."','".$user['lastLoginDate']."',".$user['isAdmin'].",".$user['isActiv'].");";
            $stmt = $db->prepare($query);
            //$result = $stmt->execute();

            if (!$stmt->execute()) {
                header("Location: " . $_SERVER['PHP_SELF'] . "?result=danger");
            } else {
                header("Location: " . $_SERVER['PHP_SELF'] . "?result=success");
            }

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}


?>

<?php include_once 'includes/header.php'; ?>

    <body id="page-top">

<?php include_once 'includes/banner.php'; ?>

<div id="wrapper">

<?php include_once 'includes/sidebar.php'; ?>

    <div id="content-wrapper">

    <div class="container-fluid">


        <?php

        if (isset($_GET['result'])) {
            switch ($_GET['result']) {
                case 'success':
                    $class = 'success';
                    $msg = 'Accout has been successfully created';
                    break;
                case 'danger':
                    $class = 'danger';
                    $msg = 'Email already exits';
                    break;
                case 'differentPassword':
                    $class = 'danger';
                    $msg = 'Wrong confirmation of the password';
            }

            echo '<div class="alert alert-'.$class.'" role="alert">';
            echo $msg;
            echo '</div>';
        }

        ?>

        <div class="card card-register mb-3">
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
                    <input class="btn btn-primary btn-block" type="submit" value="Register" href="register.php" />
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