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
            $result = $stmt->execute();
        }

        if (!$stmt->execute()) {
            echo "<pre>";
            print_r($stmt->errorInfo());
            echo "</pre>";
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

                                $db = new PDO('sqlite:../databases/' . __DB_NAME);

                                // INBOX & Sent items
                                /* $query = " SELECT messages.id,
                                  u1.email AS email_exp, 
                                  u2.email AS email_dst, 
                                  subject, body, time 
                                FROM messages 
                                INNER JOIN users AS u1 
                                  ON messages.id_sender = u1.id 
                                INNER JOIN users AS u2 
                                  ON messages.id_receiver = u2.id
                                WHERE email_exp = '".$_SESSION['user']['email']."' 
                                  OR email_dst = '".$_SESSION['user']['email']."';";
                                $messages = $db->query($query); */

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
                                        echo '<td><a class="btn btn-primary" href="#" role="button">Répondre</a></td>';
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
                                                <a class="btn btn-primary" href="#" role="button">Répondre</a>
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
                    <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
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