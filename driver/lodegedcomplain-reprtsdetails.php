<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['vamsid']==0)) {
  header('location:logout.php');
  } else{



  ?>
<!doctype html>
<html lang="vi">

<head>
  
    <title>Hệ Thống Quản Lý Rác: Xem Báo Cáo Công Việc Hoàn Thành Cho Khiếu Nại Đã Ghi Nhận</title>

    <link rel="stylesheet" href="../assets/vendor/themify-icons/themify-icons.css">
    <link rel="stylesheet" href="../assets/vendor/fontawesome/css/font-awesome.min.css">

    <link rel="stylesheet" href="../assets/vendor/jquery-datatable/dataTables.bootstrap4.min.css">

    <link  rel="stylesheet" href="../assets/css/main.css">
</head>
<body class="theme-indigo">
    <!-- Trình tải trang -->
    
<?php include_once('includes/header.php');?>

    <div class="main_content" id="main-content">
       <?php include_once('includes/sidebar.php');?>


        <div class="page">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="javascript:void(0);">Xem Báo Cáo Công Việc Hoàn Thành Cho Khiếu Nại Đã Ghi Nhận</a>
            </nav>
            <div class="container-fluid">            
                <div class="row clearfix">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="header">
                                <h2>Xem Báo Cáo Công Việc Hoàn Thành Cho Khiếu Nại Đã Ghi Nhận</h2>
                            </div>
                            <div class="body">
                                <?php
                                $fdate=$_POST['fromdate'];
                                $tdate=$_POST['todate'];
                                ?>
                                <h5 align="center" style="color:blue">Báo cáo từ <?php echo $fdate?> đến <?php echo $tdate?></h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                        <thead>
                                            <tr>
                                               <th>STT</th>
                                               <th>Công việc đã phân công</th>
                                               <th>Công việc đã hoàn thành</th>
                                               <th>Công việc còn lại</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                               <th>STT</th>
                                               <th>Công việc đã phân công</th>
                                               <th>Công việc đã hoàn thành</th>
                                               <th>Công việc còn lại</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                           
                                               <?php
                                               $did=$_SESSION['vamsdid'];

                                               $sql="SELECT  
                                               count(ID) as assigned,  
                                               count(if(tbllodgedcomplain.Status = 'Completed', 1, 0)) AS completed from  tbllodgedcomplain  
                                               where tbllodgedcomplain.AssignTo=:did && date(UpdationDate) between '$fdate' and '$tdate'";
                                               $query = $dbh -> prepare($sql);
                                               $query-> bindParam(':did', $did, PDO::PARAM_STR);
                                               $query->execute();
                                               $results=$query->fetchAll(PDO::FETCH_OBJ);
                                               $cnt=1;
                                               if($query->rowCount() > 0)
                                               {
                                                   foreach($results as $row)
                                                   { ?> 
                                                   <tr>
                                                      <td><?php echo htmlentities($cnt);?></td>
                                                      <td><?php  echo htmlentities($ta=$row->assigned);?></td>
                                                      <td><?php  echo htmlentities($sc=$row->completed);?></td>
                                                      <td><?php  echo htmlentities($ta-$sc);?></td>
                                                   </tr>
                                                <?php $cnt=$cnt+1;}} else{ ?> 
                                                <tr>
                                                   <td colspan="6">Không tìm thấy bản ghi</td>    
                                                </tr>
                                               <?php } ?>
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