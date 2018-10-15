<?php include_once 'includes/auth.php'; ?>
<?php include_once 'includes/config.php'; ?>
<?php include_once 'includes/functions.php'; ?>


<?php

$existingDir = array('inbox', 'sent');
$dir = ( ( isset($_GET['dir']) && in_array($_GET['dir'],$existingDir) ) ? $_GET['dir'] : $defaultDir );


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
                                $query = " SELECT messages.id, 
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
                                $messages = $db->query($query);


                                if (empty($messages)) {
                                    echo 'No entry in database';
                                } else {



                                    echo '<table>';

                                    // Display headers
                                    echo '<th>ID</th>';
                                    echo '<th>Expéditeur</th>';
                                    echo '<th>Destinataire</th>';
                                    echo '<th>Sujet</th>';
                                    echo '<th>Corps du message</th>';
                                    echo '<th>Date / heure</th>';

                                    // Iterate each record
                                    foreach ($messages as $row) {
                                        // Start a row
                                        echo '<tr>';
                                        $row["body"]= truncate($row["body"],100);

                                        echo '<td>' . $row["id"] . '</td>';
                                        echo '<td>' . $row["email_exp"] . '</td>';
                                        echo '<td>' . $row["email_dst"] . '</td>';
                                        echo '<td>' . $row["subject"] . '</td>';
                                        echo '<td>' . $row["body"] . '</td>';
                                        echo '<td>' . $row["time"] . '</td>';

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