<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// define variables and set to empty values
$email = $password = $confirmPwd = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $emailErr = $newPwdErr = $confirmPwdErr = $warning = " ";

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

    }else{
        try {

            isset($_POST['Admin']) ? $isAdmin = 1 : $isAdmin = 0;

            $items = array(
                    array(
                            'email' => $email,
                            'password' => $password,
                            'isAdmin' =>$isAdmin,
                    )
            );

            $db = new PDO('sqlite:../databases/database.sqlite');

            if(!$db){
                $warning='Unable to open a connection to the database';
            }else {


                $insert = $db->prepare('INSERT INTO users(email, password, isAdmin) VALUES (? , ?, ?)');

                $insert->execute(array($email, $password, $isAdmin));
                //$stmt = $db->prepare($insert);
/*
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password', $password);
                $stmt->bindParam(':isAdmin', $isAdmin);

                foreach ($data as $item){
                    $email = $item['email'];
                    $password = $item['password'];
                    $isAdmin = $item['isAdmin'];

                $stmt->execute([
                        ':email' => $email,
                        ':password' => $password,
                        ':isAdmin' => $isAdmin,
                ]);
*/
            }

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

<html>
<head>

    <style type="text/css">

    body#SignupForm{ background-image:url("https://hdwallsource.com/img/2014/9/blur-26347-27038-hd-wallpapers.jpg"); background-repeat:no-repeat; background-position:center; background-size:cover; padding:10px;}

    .panel h1{ color:#444444; font-size:24px; margin:0 0 8px 0;}
        .panel p { color:#777777; font-size:20px; margin-bottom:30px; line-height:24px;}
            .signup-form .form-control {
                background: #f7f7f7 none repeat scroll 0 0;
                border: 1px solid #d4d4d4;
                border-radius: 4px;
                font-size: 14px;
                height: 40px;
                line-height: 40px;
                display: inline-block;
                position: static;

        }
        .main-div {
            background: #ffffff none repeat scroll 0 0;
            border-radius: 2px;
            margin: 10px auto 30px;
            width: 500px;
            padding: 50px 70px 70px 71px;
            display: inline-block;

        }

        .main-div input{
            display: inline-block;
            float: right;
            width: 300px;
        }

        .signup-form .form-group {
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
            font-size: 10px;
        }

        .signup-form .btn.btn-primary.signup {
            background: #ff9900 none repeat scroll 0 0;
            }

        .back a {color: #444444; font-size: 13px;text-decoration: none;}

        .label-text{
            border-radius: 4px;
            font-size: 14px;
            height: 50px;
            line-height: 50px;
            padding-left: 10px;
            padding-right: 10px;
            display: inline-block;
            position: static;
        }

        .Admin {
            background: #f7f7f7 none repeat scroll 0 0;
            border: 1px solid #d4d4d4;
            border-radius: 4px;
            height: 40px;
            line-height: 40px;
            border-radius: 4px;
            alignment: left;
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
                    <span class="error">* </span>
                    <label class="error"><?php echo $emailErr;?></label>
                </div>

                <div class="form-group">
                    <label class="label-text">New password: </label>
                    <input value="<?php echo (isset($password) ? $password : ''); ?>" type="password" class="form-control" name="newPwd" id="newPwd">
                    <span class="error">* </span>
                    <label class="error"><?php echo $newPwdErr;?></label>
                </div>


                <div class="form-group">
                    <label class="label-text">Confirm password: </label>
                    <input value="<?php echo (isset($confirmPwd) ? $confirmPwd : ''); ?>" type="password" class="form-control" name="confirmPwd" id="confirmPwd">
                    <span class="error">* </span>
                    <label class="error"><?php echo $confirmPwdErr;?></label>
                </div>

                <div class="form-group">
                    <label class="label-text">Administrator: </label>
                    <input type="checkbox" name="Admin" id="Admin" class="Admin" value="Admin"><br/>
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
