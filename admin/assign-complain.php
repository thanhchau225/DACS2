<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
// Kiểm tra xem người dùng đã đăng nhập chưa
if (strlen($_SESSION['vamsaid'] == 0)) {
    header('location:logout.php');
} else {
?>
<!doctype html>
<html lang="vi">

<head>
    <title>Hệ thống quản lý rác thải: Giao khiếu nại đã ghi</title>

    <link rel="stylesheet" href="../assets/vendor/themify-icons/themify-icons.css">
    <link rel="stylesheet" href="../assets/vendor/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/vendor/jquery-datatable/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../assets/css/main.css">
</head>

<body class="theme-indigo">
    <?php include_once('includes/header.php'); ?>

    <div class="main_content" id="main-content">
        <?php include_once('includes/sidebar.php'); ?>

        <div class="page">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="javascript:void(0);">Giao khiếu nại đã ghi</a>
            </nav>
            <div class="container-fluid">            
                <div class="row clearfix">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="header">
                                <h2><strong>Giao khiếu nại</strong> đã ghi</h2>
                            </div>
                            <div class="body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                        <thead>
                                            <tr>
                                               <th>S.No</th>
                                               <th>Số khiếu nại</th>
                                               <th>Tên</th>
                                               <th>Số điện thoại</th>
                                               <th>Email</th>
                                               <th>Trạng thái</th>
                                               <th>Hành động</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                              <th>S.No</th>
                                              <th>Số khiếu nại</th>
                                              <th>Tên</th>
                                              <th>Số điện thoại</th>
                                              <th>Email</th>
                                              <th>Trạng thái</th>
                                              <th>Hành động</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php
                                            $sql = "SELECT tbllodgedcomplain.ComplainNumber, tbllodgedcomplain.AssignTo, tbllodgedcomplain.ID as compid, tbllodgedcomplain.Status, tbluser.ID as uid, tbluser.FullName, tbluser.MobileNumber, tbluser.Email FROM tbllodgedcomplain JOIN tbluser ON tbluser.ID = tbllodgedcomplain.UserID WHERE tbllodgedcomplain.Status='Approved'";
                                            $query = $dbh->prepare($sql);
                                            $query->execute();
                                            $results = $query->fetchAll(PDO::FETCH_OBJ);

                                            $cnt = 1;
                                            if ($query->rowCount() > 0) {
                                                foreach ($results as $row) {
                                            ?>
                                                    <tr>
                                                        <td><?php echo htmlentities($cnt); ?></td>
                                                        <td><?php echo htmlentities($row->ComplainNumber); ?></td>
                                                        <td><?php echo htmlentities($row->FullName); ?></td>
                                                        <td><?php echo htmlentities($row->MobileNumber); ?></td>
                                                        <td><?php echo htmlentities($row->Email); ?></td>
                                                        <?php if ($row->Status == "") { ?>
                                                            <td><?php echo "Chưa được cập nhật"; ?></td>
                                                        <?php } else { ?>
                                                            <td><?php echo htmlentities($row->Status); ?> (Giao cho <?php echo htmlentities($row->AssignTo); ?>)</td>
                                                        <?php } ?>         
                                                        <td><a href="view-complain-detail.php?editid=<?php echo htmlentities($row->compid); ?>&&comid=<?php echo htmlentities($row->ComplainNumber); ?>" class="btn btn-primary">Xem</a></td>
                                                    </tr>
                                            <?php 
                                                    $cnt++;
                                                }
                                            } 
                                            ?> 
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>               
            </div>
        </div>
    </div>

    <!-- Jquery Core Js --> 
    <script src="../assets/bundles/libscripts.bundle.js"></script> 
    <script src="../assets/bundles/vendorscripts.bundle.js"></script> 
    <script src="../assets/bundles/datatablescripts.bundle.js"></script>
    <script src="../assets/vendor/jquery-datatable/buttons/dataTables.buttons.min.js"></script>
    <script src="../assets/vendor/jquery-datatable/buttons/buttons.bootstrap4.min.js"></script>
    <script src="../assets/vendor/jquery-datatable/buttons/buttons.colVis.min.js"></script>
    <script src="../assets/vendor/jquery-datatable/buttons/buttons.flash.min.js"></script>
    <script src="../assets/vendor/jquery-datatable/buttons/buttons.html5.min.js"></script>
    <script src="../assets/vendor/jquery-datatable/buttons/buttons.print.min.js"></script>

    <script src="../assets/js/theme.js"></script> 
    <script src="../assets/js/pages/tables/jquery-datatable.js"></script>
</body>
</html>
<?php } ?>
