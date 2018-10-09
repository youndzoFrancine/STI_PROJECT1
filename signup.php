<?php
// define variables and set to empty values
$email = $newPwd = $confirmPwd = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $emailErr = $newPwdErr = $confirmPwdErr = "";

    if(empty($_POST['email']) OR empty($_POST['newPwd']) OR empty($_POST['confirmPwd'])){
        $warning="Please fulfill all fields";
    }


    if (isset($_POST['email'])) {
        $emailErr = "Email is required";
    } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
        $emailErr = "Email is invalid";
    } else {
        $email = test_input($_POST['email']);
    }


    $newPwd = test_input($_POST["newPwd"]);

    $confirmPwd = test_input($_POST["confirmPwd"]);


    if ($newPwd !== $confirmPwd) {
        $confirmPwdErr = "Password is different";
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

<html>
<head>

    <style type="text/css">

    body#SignupForm{ background-image:url("https://hdwallsource.com/img/2014/9/blur-26347-27038-hd-wallpapers.jpg"); background-repeat:no-repeat; background-position:center; background-size:cover; padding:10px;}

    .form-heading { color:#fff; font-size:23px;}
    .panel h1{ color:#444444; font-size:24px; margin:0 0 8px 0;}
        .panel p { color:#777777; font-size:20px; margin-bottom:30px; line-height:24px;}
            .signup-form .form-control {
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
            max-width: 30%;
            padding: 50px 70px 70px 71px;

            display: inline-block;

        }

        .main-div input{
            display: inline-block;
            float: right;
        }

        .signup-form .form-group {
                margin-bottom:10px;
                text-align: left;
        }
        .signup-form{ text-align:center;}
        .create a {
                color: #777777;
                font-size: 14px;
            text-decoration: underline;
        }
        .signup-form  .btn.btn-primary {
                background: #f0ad4e none repeat scroll 0 0;
                border-color: #f0ad4e;
            color: #ffffff;
            font-size: 14px;
            width: 100%;
            height: 50px;
            line-height: 50px;
            padding: 0;
        }

        .error{
            color: #FF0000;
        }
        .create {
                text-align: left; margin-bottom:30px;
        }
        .botto-text {
                color: #ffffff;
                font-size: 14px;
            margin: auto;
        }
        .signup-form .btn.btn-primary.signup {
                background: #ff9900 none repeat scroll 0 0;
            }
        .back { text-align: left; margin-top:10px;}
        .back a {color: #444444; font-size: 13px;text-decoration: none;}

        .label-text{
            border-radius: 4px;
            font-size: 14px;
            height: 50px;
            line-height: 50px;
            padding-left: 10px;
            padding-right: 10px;
        }
                </style>

</head>
<body id="SignupForm">
<div class="container">
    <div class="signup-form">
        <div class="main-div">
            <div class="panel">
                <p>Signup form</p>
            </div>
            <p><span class="warning" name="warning"><?php echo $warning;?></span></p>
            <p><span class="error">* required field</span></p>
            <form id="Signup" action="signup.php" method="post">

                <div class="form-group">
                    <label class="label-text">Email: </label>
                    <input value="<?php echo (isset($email) ? $email : ''); ?>" type="email" class="form-control" name="email" id="email">
                    <span class="error">* <?php echo $emailErr;?></span>
                </div>

                <div class="form-group">
                    <label class="label-text">New password: </label>
                    <input type="password" class="form-control" name="newPwd" id="newPwd">
                    <span class="error">* <?php echo $newPwdErr;?></span>
                </div>

                <div class="form-group">
                    <label class="label-text">Confirm password: </label>
                    <input type="password" class="form-control" name="confirmPwd" id="confirmPwd">
                    <span class="error">* <?php echo $confirmPwdErr;?></span>
                </div>

                <div>
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>


            </form>
        </div>
    </div>
</div>


</body>
</html>
