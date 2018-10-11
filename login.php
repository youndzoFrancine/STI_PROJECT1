<?php
session_start();

require_once 'includes/config.php';

if ( isset( $_GET['action'] ) ) {
    if ( $_GET['action'] == 'logout' ) {
        unset( $_SESSION['user_session'] );
        if ( session_destroy() ) {
            header( "Location: login.php" );
        }
    }
}

if($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['email']) && isset($_POST['password'])) {


        if (filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) === false) {
            echo 'bad username';

            return;
        }

        $user_email = trim($_POST['email']);
        $password = md5(trim($_POST['password']));  // Hash password

        try {

            $db = new PDO('sqlite:../databases/database.sqlite');

            if (!$db) {
                echo 'Unable to open a connection to the database';
            } else {
                $query = "SELECT users.email, users.password FROM users";

                $return = $db->query($query);

                if($query['email'] === $email){
                    header("Location: signup.php");
                }

                //SELECT tbl_name FROM sqlite_master WHERE type = 'table';
                /*
                $db->bind('email', $user_email, PDO::PARAM_STR);
                $db->execute();
                $row = $db->single();

                // Make sure we had at least one row
                $rowCount = $db->rowCount();
                $db->closeConnection();

                if ($rowCount > 0 && !empty($row['password']) && $row['password'] == $password) {
                    echo "ok".$row['username']; // log in
                    $_SESSION['user_session']['id']   = $row['id'];
                    $_SESSION['user_session']['name'] = $row['username'];

                    header("Location: index.php");
                } else {
                    echo 'Mmm sorry, wrong email / password combination';
                }
                */
            }

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }else{
        $warning = "Please fulfill all fields";
    }
}
?>


<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->


<html>
<head>

    <style type="text/css">

        body#LoginForm{ background-image:url("https://hdwallsource.com/img/2014/9/blur-26347-27038-hd-wallpapers.jpg"); background-repeat:no-repeat; background-position:center; background-size:cover; padding:10px;}

        .panel h2{ color:#444444; font-size:18px; margin:0 0 8px 0;}
        .panel p { color:#777777; font-size:14px; margin-bottom:30px; line-height:24px;}
        .login-form .form-control {
            background: #f7f7f7 none repeat scroll 0 0;
            border: 1px solid #d4d4d4;
            border-radius: 4px;
            font-size: 14px;
            height: 50px;
            line-height: 50px;
        }
        .main-div {
            background: #ffffff none repeat scroll 0 0;
            border-radius: 2px;
            margin: 10px auto 30px;
            max-width: 38%;
            padding: 50px 70px 70px 71px;
        }

        .login-form .form-group {
            margin-bottom:10px;
        }
        .login-form{ text-align:center;}
        .create a {
            color: #777777;
            font-size: 14px;
            text-decoration: underline;
        }
        .login-form  .btn.btn-primary {
            background: #f0ad4e none repeat scroll 0 0;
            border-color: #f0ad4e;
            color: #ffffff;
            font-size: 14px;
            width: 100%;
            height: 50px;
            line-height: 50px;
            padding: 0;
        }
        .create {
            text-align: left; margin-bottom:30px;
        }

        .login-form .btn.btn-primary.reset {
            background: #ff9900 none repeat scroll 0 0;
        }

        .back a {color: #444444; font-size: 13px;text-decoration: none;}


    </style>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!------ Include the above in your HEAD tag ---------->
</head>
<body id="LoginForm">
<div class="container">
    <div class="login-form">
        <div class="main-div">
            <div class="panel">
                <p>Please enter your email and password</p>
                <p><span class="warning" name="warning"><?php echo $warning;?></span> </p>
            </div>
            <form id="Login" action="login.php" method="post">

                <div class="form-group">
                    <input value="<?php echo (isset($email) ? $email : ''); ?>" type="email" class="form-control" id="inputEmail" placeholder="Email Address">
                </div>

                <div class="form-group">
                    <input type="password" class="form-control" id="inputPassword" placeholder="Password">
                </div>

                <button type="submit" class="btn btn-primary">Login</button>

            </form>
        </div>
    </div></div></div>


</body>
</html>
