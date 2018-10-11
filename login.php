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

        .warning{
            color: #FF0000;
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
                    <input value="<?php echo (isset($email) ? $email : ''); ?>" type="email" name="email" class="form-control" id="inputEmail" placeholder="Email Address">
                </div>

                <div class="form-group">
                    <input type="password" name="password" class="form-control" id="inputPassword" placeholder="Password">
                </div>

                <button type="submit" class="btn btn-primary">Login</button>

            </form>
        </div>
    </div></div></div>


</body>
</html>
