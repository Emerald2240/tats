<?php
require_once "config/connect.php";
require_once "functions/functions.php";

if (!isset($_SESSION['log'])) {
    //gotoPage("index.php");
}
$datamissing = ResetPassword($_POST);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>TA TECH BLOG SET NEW PASSWORD</title>
    <meta name="description" content="<?= 'Tech Acoustic Tech Blog' ?>">
    <!-- <meta property='og:title' content="TATB HOME"> -->
    <meta property='og:url' content="https://techac.net/tatb">
    <!-- <meta property='og:image' itemprop="image" content="https://techac.net/tatb/assets/images/mike.jpg"> -->
    <meta property='keywords' content="New Password, Tech Acoustic, TA, TATB, Tech Blog, Tech, Science, Computers">
    <!-- <meta property='og:locale' content="">
	<meta property='og:type' content=""> -->

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
                            <div class="col-lg-6">
                                <?php if (isset($_GET['code'])) {
                                    if (!validateResetCode($_GET['code'])) {
                                        echo '<div class="p-5">
                                        <h1>Error!!!</h1>
                                        </div>';
                                    } else { ?>
                                        <div class="p-5">
                                            <div class="text-center">
                                                <h1 class="h4 text-gray-900 mb-2">Reset Your Passoword</h1>
                                                <p class="mb-4">Enter your new password</p>
                                            </div>

                                            <form class="user" action="" method="post">
                                                <div class="form-group">
                                                    <input required type="password" name="pass1" class="form-control form-control-user" placeholder="Enter New Password">
                                                </div>
                                                <div class="form-group">
                                                    <input required type="password" name="pass2" class="form-control form-control-user" placeholder="Confirm New Password">
                                                </div>
                                                <button required type="submit" class="btn btn-primary btn-user btn-block" id="submit" name="submit">Reset Password</button>
                                            </form>
                                            <hr>
                                            <!-- <div class="text-center">
                                        <a class="small" href="register.html">Create an Account!</a>
                                    </div> -->
                                            <div class="text-center">
                                                <a class="small" href="login.html">Already have an account? Login!</a>
                                            </div>
                                        </div>
                                <?php }
                                } else {
                                    echo '<div>
                                        <h1>Error!!!</h1>
                                        </div>';
                                } ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>