<?php include_once 'includes/auth.php'; ?>

<?php

if (isset($_POST['to']) && isset($_POST['subject']) && isset($_POST['message'])) {

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
            $result = $stmt->execute();

            if (!$stmt->execute()) {
                echo "<pre>";
                print_r($stmt->errorInfo());
                echo "</pre>";
            }

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // If not in database, let's add him
            if (empty($user['id'])) {
                $query = "INSERT INTO users (`email`, `password`, `registerDate`, `lastLoginDate`, `isAdmin`, `isActiv`) 
                      VALUES ('".$recipientEmail."','','','',0,0);";

                $stmt = $db->prepare($query);
                $result = $stmt->execute();
                $recipientID = $db->lastInsertId();
            } else {
                $recipientID = $user['id'];
            }

            if (filter_var($recipientID, FILTER_VALIDATE_INT) !== false) {
                $query = "INSERT INTO messages (`id_sender`, `id_receiver`, `subject`, `body`, `time`) 
                      VALUES ('".$senderID."','".$recipientID."','".$subject."','".$body."','".$mailDate."');";

                $stmt = $db->prepare($query);
                $result = $stmt->execute();
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
                                <input type="email" class="form-control" id="to" name="to" placeholder="Recipient mail address" required="required">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="subject" name="subject" placeholder="Subject" required="required">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-10">
                                <textarea class="form-control" rows="4" name="message" placeholder="Message body" required="required"></textarea>
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