<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['vamsaid']==0)) {
  header('location:logout.php');
  } else{



  ?>
<!doctype html>
<html lang="vi">

<head>
  
    <title>Hệ Thống Quản Lý Rác Thải: Tìm Kiếm Thùng Rác</title>

    <link rel="stylesheet" href="../assets/vendor/themify-icons/themify-icons.css">
    <link rel="stylesheet" href="../assets/vendor/fontawesome/css/font-awesome.min.css">

    <link rel="stylesheet" href="../assets/vendor/jquery-datatable/dataTables.bootstrap4.min.css">

    <link  rel="stylesheet" href="../assets/css/main.css">
</head>
<body class="theme-indigo">
    <!-- Page Loader -->
    
<?php include_once('includes/header.php');?> 

    <div class="main_content" id="main-content">
       <?php include_once('includes/sidebar.php');?> 

        <div class="page">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="javascript:void(0);">Tìm Kiếm Thùng Rác Được Giao</a>
            </nav>
            <div class="container-fluid">            
                <div class="row clearfix">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="header">
                                <h2>Tìm Kiếm Theo Mã Thùng Rác. </h2>
                            </div>
                            

                            <div class="body">
                                <form id="basic-form" method="post">
                                <div class="form-group">
                                   
                                    <input id="searchdata" type="text" name="searchdata" required="true" class="form-control" placeholder="Nhập Mã Thùng Rác"></div>
                                

                                <br>
                                <button type="submit" class="btn btn-primary" name="search" id="submit">Tìm Kiếm</button>

                            </form>
                                <div class="table-responsive">
                                     <?php
if(isset($_POST['search']))
{ 

$sdata=$_POST['searchdata'];
  ?>
  <h4 align="center">Kết quả tìm kiếm với từ khóa "<?php echo $sdata;?>" </h4>
                                    <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                        <thead>
                                            <tr>
                                               <th>STT</th>
                                        <th>Mã Thùng Rác</th>
                                        <th>Khu Vực</th>
                                        <th>Địa Phương</th>
                                        <th>Ngày Giao</th>
                                    <th>Trạng Thái</th>
                                        <th>Hành Động</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                               <th>STT</th>
                                        <th>Mã Thùng Rác</th>
                                        <th>Khu Vực</th>
                                        <th>Địa Phương</th>
                                        <th>Ngày Giao</th>
                                    <th>Trạng Thái</th>
                                        <th>Hành Động</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <tr>
                                               <?php
                                               
$sql="SELECT * from  tblbin where BinID like '%$sdata%'";
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
                                        <td><?php  echo htmlentities($row->Area);?></td>
                                        <td><?php  echo htmlentities($row->Locality);?></td>
                                        <td><?php  echo htmlentities($row->AssignDate);?></td>
                                             <?php if($row->Status==""){ ?>

                     <td><?php echo "Chưa Cập Nhật"; ?></td>
<?php } else { ?>                  <td><?php  echo htmlentities($row->Status);?></td>
                  <?php } ?>         
                 
                                        <td><a href="view-bin-detail.php?editid=<?php echo htmlentities ($row->ID);?>&&binid=<?php echo htmlentities ($row->BinID);?>"class="btn btn-primary">Xem</a></td>
                                            </tr>
                                        <?php 
$cnt=$cnt+1;
} } else { ?>
  <tr>
    <td colspan="8"> Không tìm thấy kết quả với từ khóa này</td>

  </tr>
  <?php } }?>
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
</html><?php }  ?>
