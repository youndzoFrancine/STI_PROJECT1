<?php

/**
 * @file        formulaire.php
 *
 * @description This file is used to create a message and to send it.
 *
 *
 * @version     PHP version 5.5.9
 *
 * @author      Francine Vanessa Youndzo Kengne
 * @author      Cyril de Bourgues
 * @author      Nuno Miguel Cerca Abrantes Sivla
 */
?>

<?php include_once 'includes/auth.php'; ?>

<?php

// Replying email
if (isset($_GET['action']) && isset($_GET['mID'])) {

    $mID = $_GET['mID'];
    $action = $_GET['action'];

    // Init DB connection
    $db = new PDO('sqlite:../databases/' . __DB_NAME);
    $stmt = $db->prepare("SELECT subject, body, time, email 
                                    FROM messages 
                                    INNER JOIN users 
                                      ON users.id = messages.id_sender
                                    WHERE messages.id = '".$mID."';");
    if (!$stmt->execute()) {
        echo "<pre>";
        print_r($stmt->errorInfo());
        echo "</pre>";

        exit(1);
    }

    $msg = $stmt->fetch(PDO::FETCH_ASSOC);
    if (empty($msg['id'])) {
        echo "No such message ID";
    }

    $msg['body'] = "\n\nOriginal message : \n\n" . $msg['body'];
}

// Sending email
if (isset($_POST['to']) && isset($_POST['subject']) && isset($_POST['message'])) {

    // Recover the information of the email write by the user
    $senderID = $_SESSION["user"]["id"];
    $recipientEmail = $_POST['to'];
    $subject = $_POST['subject'];
    $body = $_POST['message'];
    $format = 'Y-m-d H:i:s';
    $mailDate =  date ($format);

    // Make sure recipient address is a valid one
    if (filter_var($recipientEmail, FILTER_VALIDATE_EMAIL) !== false) {
        try {
            // Init DB connection
            $db = new PDO('sqlite:../databases/' . __DB_NAME);

            // Check first if the recipient address is already in DB
            $stmt = $db->prepare("SELECT id FROM `users` WHERE email = '" . $recipientEmail . "' AND isActiv = '1' LIMIT 1;");
            if (!$stmt->execute()) {
                echo "<pre>";
                print_r($stmt->errorInfo());
                echo "</pre>";

                exit(1);
            }

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // If not in database, let's add him
            if (empty($user['id'])) {
                $query = "INSERT INTO users (`email`, `password`, `registerDate`, `lastLoginDate`, `isAdmin`, `isActiv`) 
                      VALUES ('".$recipientEmail."','','".$mailDate."','',0,0);";

                $stmt = $db->prepare($query);
                if (!$stmt->execute()) {
                    echo "<pre>";
                    print_r($stmt->errorInfo());
                    echo "</pre>";

                    exit(1);
                }
                $recipientID = $db->lastInsertId();
            } else {
                $recipientID = $user['id'];
            }

            if (filter_var($recipientID, FILTER_VALIDATE_INT) !== false) {
                $query = "INSERT INTO messages (`id_sender`, `id_receiver`, `subject`, `body`, `time`) 
                      VALUES ('".$senderID."','".$recipientID."','".$subject."','".$body."','".$mailDate."');";

                $stmt = $db->prepare($query);
                if (!$stmt->execute()) {
                    echo "<pre>";
                    print_r($stmt->errorInfo());
                    echo "</pre>";

                    exit(1);
                }
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
            <div class="card card-register mb-3">
                <div class="card-header">New Message</div>
                <div class="card-body">
                    <form action="formulaire.php" method="POST">
                        <div class="form-group">
                            <div class="col-sm-10">
                                <input value="<?php echo ( isset($msg) ? $msg['email'] : "" ) ?>" type="email" class="form-control" id="to" name="to" placeholder="Recipient mail address" required="required">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-10">
                                <input value="Re : <?php echo ( isset($msg) ? $msg['subject'] : "" ) ?>" type="text" class="form-control" id="subject" name="subject" placeholder="Subject" required="required">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-10">
                                <textarea class="form-control" rows="10" name="message" placeholder="Message body" required="required">
                                    <?php echo ( isset($msg) ? $msg['body'] : "" ) ?>
                                </textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-10 col-sm-offset-2">
                                <input id="submit" name="submit" type="submit" value="Send" class="btn btn-primary">
                            </div>
                        </div>
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