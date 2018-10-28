
<?php include_once 'includes/auth.php'; ?>
<?php include_once 'includes/header.php'; ?>

<body id="page-top">

<?php include_once 'includes/banner.php'; ?>

<div id="wrapper">

    <?php include_once 'includes/sidebar.php'; ?>

    <div id="content-wrapper">

        <div class="container">
            <div class="card card-register mx-auto mt-5">
                <div class="card-header">New Message</div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">From</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="From" name="From" placeholder="userEmail@domain.com" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-sm-2 control-label">To</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="To" name="To" placeholder="example@domain.com" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="message" class="col-sm-2 control-label">Message</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" rows="4" name="message"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-10 col-sm-offset-2">
                            <input id="submit" name="submit" type="submit" value="Send" class="btn btn-primary">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-10 col-sm-offset-2">
                            <! Will be used to display an alert to the user>
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