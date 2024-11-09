<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

// Kiểm tra nếu phiên người dùng đã hết hạn
if (strlen($_SESSION['vamsaid']) == 0) {
    header('location:logout.php');
} else {
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <title>Hệ thống quản lý rác thải: Bảng điều khiển</title>
    <link rel="stylesheet" href="../assets/vendor/themify-icons/themify-icons.css">
    <link rel="stylesheet" href="../assets/vendor/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/vendor/charts-c3/plugin.css"/>
    <link rel="stylesheet" href="../assets/vendor/jvectormap/jquery-jvectormap-2.0.3.css"/>
    <link rel="stylesheet" href="../assets/css/main.css" type="text/css">
</head>
<body class="theme-indigo">

<?php include_once('includes/header.php'); ?>

<div class="main_content" id="main-content">
    <?php include_once('includes/sidebar.php'); ?>

    <div class="page">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="dashboard.php">Bảng điều khiển</a>
        </nav>
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="card widget_2 big_icon traffic">
                        <div class="body" style="border:solid #000 1px">
                            <?php 
                            $sql2 = "SELECT * FROM tbllodgedcomplain WHERE Status IS NULL";
                            $query2 = $dbh->prepare($sql2);
                            $query2->execute();
                            $totnewreq = $query2->rowCount();
                            ?>
                            <h6>Thông báo khiếu nại mới</h6>
                            <h2><?php echo htmlentities($totnewreq); ?></h2>
                            <a href="new-complain.php"><small> Xem chi tiết</small></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="card widget_2 big_icon sales">
                        <div class="body" style="border:solid #000 1px">
                            <?php 
                            $sql2 = "SELECT * FROM tbllodgedcomplain WHERE Status='Approved'";
                            $query2 = $dbh->prepare($sql2);
                            $query2->execute();
                            $totappreq = $query2->rowCount();
                            ?>
                            <h6>Đã phê duyệt khiếu nại</h6>
                            <h2><?php echo htmlentities($totappreq); ?></h2>
                            <a href="assign-complain.php"><small> Xem chi tiết</small></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="card widget_2 big_icon email">
                        <div class="body" style="border:solid #000 1px">
                            <?php 
                            $sql2 = "SELECT * FROM tbllodgedcomplain WHERE Status='Rejected'";
                            $query2 = $dbh->prepare($sql2);
                            $query2->execute();
                            $totrejreq = $query2->rowCount();
                            ?>
                            <h6>Đã từ chối khiếu nại</h6>
                            <h2><?php echo htmlentities($totrejreq); ?></h2>
                            <a href="rejected-complain.php"><small> Xem chi tiết</small></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="card widget_2 big_icon domains">
                        <div class="body" style="border:solid #000 1px">
                            <?php 
                            $sql2 = "SELECT * FROM tbllodgedcomplain WHERE Status='On The Way'";
                            $query2 = $dbh->prepare($sql2);
                            $query2->execute();
                            $tototwreq = $query2->rowCount();
                            ?>
                            <h6>Khiếu nại đang được xử lý</h6>
                            <h2><?php echo htmlentities($tototwreq); ?></h2>
                            <a href="ontheway.php"><small> Xem chi tiết</small></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="card widget_2 big_icon traffic">
                        <div class="body" style="border:solid #000 1px">
                            <?php 
                            $sql2 = "SELECT * FROM tbllodgedcomplain WHERE Status='Completed'";
                            $query2 = $dbh->prepare($sql2);
                            $query2->execute();
                            $totcomreq = $query2->rowCount();
                            ?>
                            <h6>Đã hoàn thành khiếu nại</h6>
                            <h2><?php echo htmlentities($totcomreq); ?></h2>
                            <a href="completed-complain.php"><small> Xem chi tiết</small></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="card widget_2 big_icon sales">
                        <div class="body" style="border:solid #000 1px">
                            <?php 
                            $sql1 = "SELECT * FROM tbldriver";
                            $query1 = $dbh->prepare($sql1);
                            $query1->execute();
                            $totdriver = $query1->rowCount();
                            ?>
                            <h6>Tổng số tài xế</h6>
                            <h2><?php echo htmlentities($totdriver); ?></h2>
                            <a href="manage-driver.php"><small> Xem chi tiết</small></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="card widget_2 big_icon sales">
                        <div class="body" style="border:solid #000 1px">
                            <?php 
                            $sql1 = "SELECT * FROM tblbin WHERE Status='On The Way'";
                            $query1 = $dbh->prepare($sql1);
                            $query1->execute();
                            $totbininpro = $query1->rowCount();
                            ?>
                            <h6>Thùng rác đang được dọn</h6>
                            <h2><?php echo htmlentities($totbininpro); ?></h2>
                            <a href="ontheway.php"><small> Xem chi tiết</small></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="card widget_2 big_icon sales">
                        <div class="body" style="border:solid #000 1px">
                            <?php 
                            $sql1 = "SELECT * FROM tblbin WHERE Status='Completed'";
                            $query1 = $dbh->prepare($sql1);
                            $query1->execute();
                            $totcleaningcomp = $query1->rowCount();
                            ?>
                            <h6>Thùng rác đã được dọn sạch</h6>
                            <h2><?php echo htmlentities($totcleaningcomp); ?></h2>
                            <a href="completed.php"><small> Xem chi tiết</small></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</div>

<!-- Core -->
<script src="../assets/bundles/libscripts.bundle.js"></script>
<script src="../assets/bundles/vendorscripts.bundle.js"></script>
<script src="../assets/bundles/c3.bundle.js"></script>
<script src="../assets/bundles/jvectormap.bundle.js"></script> <!-- JVectorMap Plugin Js -->
<script src="../assets/js/theme.js"></script>
<script src="../assets/js/pages/index.js"></script>
<script src="../assets/js/pages/todo-js.js"></script>
</body>
</html>
<?php } ?>
