<?php include_once 'includes/auth.php'; ?>
<?php include_once 'includes/config.php'; ?>
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
                        Gestion des utilisateurs
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                                <?php

                                $db = new PDO('sqlite:../databases/' . __DB_NAME);
                                $query = "SELECT * FROM users";
                                $users = $db->query($query);

                                if (empty($messages)) {
                                    echo 'No entry in database';
                                } else {

                                    echo "<pre>";
                                    print_r($users);
                                    echo "</pre>";

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