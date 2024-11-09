<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['vamsaid']==0)) {
  header('location:logout.php');
} else {

// Mã xóa sản phẩm khỏi thùng rác
if(isset($_GET['delid']))
{
$rid=intval($_GET['delid']);
$sql="delete from tblbin where ID=:rid";
$query=$dbh->prepare($sql);
$query->bindParam(':rid',$rid,PDO::PARAM_STR);
$query->execute();
 echo "<script>alert('Dữ liệu đã bị xóa');</script>"; 
  echo "<script>window.location.href = 'manage-bin.php'</script>";     
}

?>
<!doctype html>
<html lang="vi">

<head>
    <title>Hệ Thống Quản Lý Rác Thải: Quản Lý Thùng Rác</title>

    <link rel="stylesheet" href="../assets/vendor/themify-icons/themify-icons.css">
    <link rel="stylesheet" href="../assets/vendor/fontawesome/css/font-awesome.min.css">

    <link rel="stylesheet" href="../assets/vendor/jquery-datatable/dataTables.bootstrap4.min.css">

    <link  rel="stylesheet" href="../assets/css/main.css">
</head>
<body class="theme-indigo">
    <!-- Bộ tải trang -->
    
<?php include_once('includes/header.php');?>

    <div class="main_content" id="main-content">
       <?php include_once('includes/sidebar.php');?>

        <div class="page">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="javascript:void(0);">Quản Lý Thùng Rác</a>
            </nav>
            <div class="container-fluid">            
                <div class="row clearfix">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="header">
                                <h2><strong>Quản Lý</strong> Thùng Rác</h2>
                            </div>
                            <div class="body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                        <thead>
                                            <tr>
                                               <th>STT</th>
                                               <th>Mã Thùng Rác</th>
                                               <th>Địa Chỉ</th>
                                               <th>Giao Cho</th>
                                               <th>Ngày Giao</th>
                                               <th>Thao Tác</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                               <th>STT</th>
                                               <th>Mã Thùng Rác</th>
                                               <th>Địa Chỉ</th>
                                               <th>Giao Cho (Mã Lái Xe)</th>
                                               <th>Ngày Giao</th>
                                               <th>Thao Tác</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <tr>
                                                <?php
$sql="SELECT * from tblbin";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $row)
{               ?>
                                               <td><?php echo htmlentities($cnt);?></td>
                                        <td><?php  echo htmlentities($row->BinID);?></td>
                                        <td><?php  echo htmlentities($row->Address);?></td>
                                        <td><?php  echo htmlentities($row->DriverAssignee);?></td>
                                        <td><?php  echo htmlentities($row->AssignDate);?></td>
                                        <td><a href="edit-bin-detail.php?editid=<?php echo htmlentities ($row->ID);?>" class="btn btn-primary">Sửa</a> <a href="manage-bin.php?delid=<?php echo ($row->ID);?>" class="btn btn-primary" onclick="return confirm('Bạn có thực sự muốn xóa không?');">Xóa</a></td>
                                            </tr>
                                         <?php $cnt=$cnt+1;}} ?> 
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
<script src="../assets/bundles/libscripts.bundle.js"></script> <!-- Lib Scripts Plugin Js --> 
<script src="../assets/bundles/vendorscripts.bundle.js"></script> <!-- Lib Scripts Plugin Js --> 

<!-- Jquery DataTable Plugin Js --> 
<script src="../assets/bundles/datatablescripts.bundle.js"></script>
<script src="../assets/vendor/jquery-datatable/buttons/dataTables.buttons.min.js"></script>
<script src="../assets/vendor/jquery-datatable/buttons/buttons.bootstrap4.min.js"></script>
<script src="../assets/vendor/jquery-datatable/buttons/buttons.colVis.min.js"></script>
<script src="../assets/vendor/jquery-datatable/buttons/buttons.flash.min.js"></script>
<script src="../assets/vendor/jquery-datatable/buttons/buttons.html5.min.js"></script>
<script src="../assets/vendor/jquery-datatable/buttons/buttons.print.min.js"></script>

<script src="../assets/js/theme.js"></script><!-- Custom Js --> 
<script src="../assets/js/pages/tables/jquery-datatable.js"></script>
</body>
</html>
<?php }  ?>
