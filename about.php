<!DOCTYPE html>
<!-- salut -->
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/business-casual.min.css" rel="stylesheet">

      <style>
          table tr td {
              padding: 5px 20px 5px 0px;
              text-align: left;
          }

          table tr td:first-child {
              width: 5%;
          }

          table tr td:nth-child(2), table tr td:nth-child(3), table tr td:nth-child(4) {
              width: 20%;
          }

          table tr td:nth-child(5) {
              width: 30%;
          }

          table tr td:nth-child(6) {
              width: 5%;
          }
      </style>

  </head>

  <body>

    <h1 class="site-heading text-center text-white d-none d-lg-block">
      <span class="site-heading-lower">Inbox</span>
    </h1>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark py-lg-4" id="mainNav">
      <div class="container">
        <a class="navbar-brand text-uppercase text-expanded font-weight-bold d-lg-none" href="#">Start Bootstrap</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav mx-auto">
            <li class="nav-item px-lg-4">
              <a class="nav-link text-uppercase text-expanded" href="index.php">Home
                <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item active px-lg-4">
              <a class="nav-link text-uppercase text-expanded" href="about.php">Inbox</a>
            </li>
            <li class="nav-item px-lg-4">
              <a class="nav-link text-uppercase text-expanded" href="products.php">Sent</a>
            </li>
            <li class="nav-item px-lg-4">
              <a class="nav-link text-uppercase text-expanded" href="store.php">Admin</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>




    <form action="/about.php" method="get">
        <button name="subject" type="submit" value="HTML">Response</button>
    </form>

    <form action="/about.php" method="get">
        <button name="subject" type="submit" value="HTML">Delete</button>
    </form>
    <form action="/about.php" method="get">
        <button name="subject" type="submit" value="HTML">Details</button>
    </form>

    <section class="page-section about-heading">
      <div class="container">

        <div class="about-heading-content">
          <div class="row">
            <div class="col-xl-9 col-lg-10 mx-auto">
              <div class="bg-faded rounded p-5">
                <table>

                    <?php

                    $db = new PDO('sqlite:../databases/database.sqlite');
                    $query = "  SELECT messages.id, 
                                  u1.email AS email_exp, 
                                  u2.email AS email_dst, 
                                  subject, body, time 
                                FROM messages 
                                INNER JOIN users AS u1 
                                  ON messages.id_sender = u1.id 
                                INNER JOIN users AS u2 
                                  ON messages.id_reciever = u2.id;";
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
                        foreach($messages as $row){

                            // Start a row
                            echo '<tr>';

                            echo '<td>'.$row["id"].'</td>';
                            echo '<td>'.$row["email_exp"].'</td>';
                            echo '<td>'.$row["email_dst"].'</td>';
                            echo '<td>'.$row["subject"].'</td>';
                            echo '<td>'.$row["body"].'</td>';
                            echo '<td>'.$row["time"].'</td>';

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
      </div>
    </section>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>

</html>
