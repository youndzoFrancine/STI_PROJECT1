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

<?php include_once 'includes/auth.php'; ?>
<?php include_once 'includes/functions.php'; ?>

<?php

$existingDir = array('inbox', 'sent');
$dir = ( ( isset($_GET['dir']) && in_array($_GET['dir'],$existingDir) ) ? $_GET['dir'] : $defaultDir );

if (isset($_GET['action']) && !empty($_GET['action']) &&
    isset($_GET['mID']) && !empty($_GET['mID'])) {

    $availableActions = array('delete');
    $action = $_GET['action'];
    $mID = $_GET['mID'];

    // Init DB connection
    $db = new PDO('sqlite:../databases/' . __DB_NAME);

    if (in_array($action, $availableActions) ) {

        if ($action == 'delete') {
            $stmt = $db->prepare("DELETE FROM messages WHERE messages.id = ".$mID.";");
        }

        if (!$stmt->execute()) {
            echo "<pre>";
            print_r($stmt->errorInfo());
            echo "</pre>";
        } else {
            header("Location: " . $_SERVER['PHP_SELF'] . "?result=success");
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
                            $msg = 'Message has been successfully deleted';
                    }

                    echo '<div class="alert alert-'.$class.'" role="alert">';
                    echo $msg;
                    echo '</div>';
                }

                ?>

                <!-- DataTables Example -->
                <div class="card mb-3">
                    <div class="card-header">
                        <i class="fas fa-table"></i>
                        Messages : <?php echo $dir; ?>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                                <?php

                                // Init handle on DB
                                $db = new PDO('sqlite:../databases/' . __DB_NAME);

                                if ($dir == 'sent') {

                                    // Sent items
                                    $query = " SELECT messages.id,
                                                  u1.email AS email_exp, 
                                                  u2.email AS email_dst, 
                                                  subject, body, time 
                                                FROM messages 
                                                INNER JOIN users AS u1 
                                                  ON messages.id_sender = u1.id 
                                                INNER JOIN users AS u2 
                                                  ON messages.id_receiver = u2.id
                                                WHERE email_exp = '".$_SESSION['user']['email']."';";

                                } elseif ($dir == 'inbox') {

                                    // Inbox
                                    $query = " SELECT messages.id,
                                                  u1.email AS email_exp, 
                                                  u2.email AS email_dst, 
                                                  subject, body, time 
                                                FROM messages 
                                                INNER JOIN users AS u1 
                                                  ON messages.id_sender = u1.id 
                                                INNER JOIN users AS u2 
                                                  ON messages.id_receiver = u2.id
                                                WHERE email_dst = '".$_SESSION['user']['email']."';";
                                }

                                $messages = $db->query($query);

                                if (empty($messages)) {
                                    echo 'No entry in database';
                                } else {

                                    echo '<table width="100%">';

                                    // Display headers
                                    echo '<th>Date / heure</th>';
                                    echo '<th>Expéditeur</th>';
                                    echo '<th>Sujet</th>';
                                    echo '<th>Détails</th>';
                                    echo '<th>Répondre</th>';
                                    echo '<th>Supprimer</th>';

                                    // Iterate each record
                                    foreach ($messages as $row) {
                                        // Start a row
                                        echo '<tr>';

                                        echo '<td>' . $row["time"] . '</td>';
                                        echo '<td>' . $row["email_exp"] . '</td>';
                                        echo '<td>' . $row["subject"] . '</td>';
                                        echo '<td><a class="btn btn-secondary" href="#" role="button" data-toggle="modal" data-target="#mID' . $row["id"] . '">Détails</a></td>';
                                        echo '<td><a class="btn btn-primary" href="formulaire.php?action=reply&mID=' . $row["id"] . '" role="button">Répondre</a></td>';
                                        echo '<td><a class="btn btn-danger" href="messages.php?action=delete&mID=' . $row["id"] . '" >Supprimer</a></td>';

                                        ?>
                                        <!-- Modal -->
                                        <div class="modal fade" id="mID<?php echo $row["id"]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                          <div class="modal-dialog modal-lg modal-notify modal-info" role="document">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">
                                                    Date de réception : <strong><?php echo $row["time"]; ?></strong><br>
                                                    Expéditeur : <strong><?php echo $row["email_exp"]; ?></strong><br>
                                                    Sujet : <strong><?php echo $row["subject"]; ?></strong>
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                                </button>
                                              </div>
                                              <div class="modal-body">
                                                  <?php echo $row["body"]; ?>
                                              </div>
                                              <div class="modal-footer">
                                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <a class="btn btn-primary" href="formulaire.php?action=reply&mID=<?php echo $row["id"]; ?>" role="button">Répondre</a>
                                                <a class="btn btn-danger" href="messages.php?action=delete&mID=<?php echo $row["id"]; ?>">Supprimer</a>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <?php

                                        // end row
                                        echo '</tr>';
                                    }
                                    echo '</table>';
                                }

                                ?>

                            </table>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /.container-fluid -->

            <?php include_once 'includes/copyright.php'; ?>

        </div>
        <!-- /.content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

<?php include_once 'includes/footer.php'; ?>