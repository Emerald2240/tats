<?php
require_once "config/connect.php";
require_once "functions/functions.php";

if (!isset($_SESSION['log'])) {
    gotoPage("login.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    echo loadPageMetaTitle('showcart');
    echo loadPageMetaDescription('showcart');
    echo loadPageMetaUrl('home');
    echo loadPageMetaImage('home');
    echo loadPageMetaKeywords('home');
    echo loadPageMetaType('home');
    require_once('includes/head.php');
    ?>

    <title>TA TECH BLOG ADMIN HOME PAGE</title>
    <meta name="description" content="<?= 'Tech Acoustic Tech Blog ADMIN HOME' ?>">
    <!-- <meta property='og:title' content="TATB HOME"> -->
    <meta property='og:url' content="https://techac.net/tatb">
    <!-- <meta property='og:image' itemprop="image" content="https://techac.net/tatb/assets/images/mike.jpg"> -->
    <meta property='keywords' content="Admin, home, Tech Acoustic, TA, TATB, Tech Blog, Tech, Science, Computers">
    <!-- <meta property='og:locale' content="">
	<meta property='og:type' content=""> -->

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php
        require_once('includes/sidebar.php');
        ?>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php
                require_once('includes/topbar.php');
                ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Items for <strong><?php echo $_GET['redeem_code'] ?></strong></h1>
                    </div>
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h3 class="h4 mb-0 text-gray-800">Name: <?php echo $_GET['customer_name'] ?></h3>
                    </div>
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h3 class="h4 mb-0 text-gray-800">Phone: <?php echo $_GET['customer_phone'] ?></h3>
                    </div>
                    <?php getCartBasicInfo($_GET['cart']); ?>

                    <hr>

                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                               
                                <td>Qt</td>
                                <td>Itm</td>
                                <td>Paid</td>
                                <td>Real</td>
                            </tr>
                        </thead>

                        <tfoot>
                            <tr>
                               
                                <td>Qt</td>
                                <td>Itm</td>
                                <td>Paid</td>
                                <td>Real</td>
                            </tr>
                        </tfoot>

                        <tbody>
                            
                            <?php layoutCart($_GET['cart']) ?>
                           
                        </tbody>

                    </table>


                    <a type="submit" class="btn btn-primary btn-user btn-block" href="finish_redeem.php?redeem_id=<?php echo $_GET['redeem_id']; ?>" name="finish_redeem">Finish</a>








                    <?php


                    ?>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php
            require_once('includes/footer.php');
            ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <?php
    require_once('includes/logout_modal.php');
    ?>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- DataTable plugins -->
    <!-- <script src="js/jquery.js"></script> -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="js/demo/datatables-demo.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

</body>

</html>