<?php include_once 'includes/auth.php'; ?>
<?php include_once 'includes/config.php'; ?>

<?php

if (isset($_GET['action']) && !empty($_GET['action']) &&
    isset($_GET['uID']) && !empty($_GET['uID'])) {

    $availableActions = array('remove', 'toggle');
    $action = $_GET['action'];
    $value = ( (isset($_GET['value']) && !empty($_GET['value'])) ? $_GET['value'] : '' );
    $uID = $_GET['uID'];

    // Init DB connection
    $db = new PDO('sqlite:../databases/' . __DB_NAME);

    if (in_array($action, $availableActions) ) {

        if (!empty($value) && $action == 'toggle') {
            $stmt = $db->prepare("UPDATE users SET ".$value." = NOT ".$value." WHERE users.id = ".$uID.";");
            $result = $stmt->execute();
        } elseif ($action == 'remove') {
            $stmt = $db->prepare("DELETE FROM users WHERE users.id = ".$uID.";");
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
                        Gestion des utilisateurs
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                                <?php

                                $db = new PDO('sqlite:../databases/' . __DB_NAME);
                                $users = $db->query("SELECT * FROM users");

                                if (empty($users)) {
                                    echo 'No entry in database';
                                } else {

                                    echo '<table width="100%">';

                                    // Display headers
                                    echo '<th>Login / email</th>';
                                    echo '<th>Admin</th>';
                                    echo '<th>registerDate</th>';
                                    echo '<th>lastLoginDate</th>';
                                    echo '<th>Activ</th>';
                                    echo '<th colspan="3">Actions</th>';

                                    // Iterate each record
                                    foreach ($users as $user) {

                                        // Start a row
                                        echo '<tr>';

                                        // echo '<td>' . $user["id"] . '</td>';
                                        echo '<td>' . $user["email"] . '</td>';
                                        // echo '<td>' . $user["password"] . '</td>';
                                        echo '<td>' . ( $user["isAdmin"] ? "yes" : "no" ) . '</td>';
                                        echo '<td>' . $user["registerDate"] . '</td>';
                                        echo '<td>' . $user["lastLoginDate"] . '</td>';
                                        echo '<td>' . ( $user["isActiv"] ? "yes" : "no" ) . '</td>';

                                        echo '<td><a class="btn btn-primary" href="' . __APP_URL . '/users.php?action=toggle&value=isAdmin&uID='.$user["id"].'" role="button">Toggle activ</a></td>';
                                        echo '<td><a class="btn btn-primary" href="' . __APP_URL . '/users.php?action=toggle&value=isActiv&uID='.$user["id"].'" role="button">Toggle admin</a></td>';
                                        echo '<td><a class="btn btn-danger" href="' . __APP_URL . '/users.php?action=remove&uID='.$user["id"].'" >Remove</a></td>';

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