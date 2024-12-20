<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['uuid']==0)) {
  header('location:logout.php');
  } else{



  ?>
<!doctype html>
<html lang="vi">

<head>
    <title>Hệ thống quản lý rác thải: Tìm kiếm khiếu nại</title>

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
                <a class="navbar-brand" href="javascript:void(0);">Tìm kiếm yêu cầu</a>
            </nav>
            <div class="container-fluid">            
                <div class="row clearfix">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="header">
                                <h2>Tìm kiếm theo số khiếu nại</h2>
                            </div>
                            
                            <div class="body">
                                <form id="basic-form" method="post">
                                <div class="form-group">
                                    <input id="searchdata" type="text" name="searchdata" required="true" class="form-control" placeholder="Nhập số khiếu nại"></div>
                                
                                <br>
                                <button type="submit" class="btn btn-primary" name="search" id="submit">Tìm kiếm</button>
                            </form>
                                <div class="table-responsive">
                                     <?php
if(isset($_POST['search']))
{ 

$sdata=$_POST['searchdata'];
  ?>
  <h4 align="center">Kết quả tìm kiếm cho từ khóa "<?php echo $sdata;?>"</h4>
                                     <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                        <thead>
                                            <tr>
                                               <th>STT</th>
                                        <th>Số khiếu nại</th>
                                        <th>Họ và tên</th>
                                        <th>Số điện thoại</th>
                                        <th>Email</th>
                                    <th>Trạng thái</th>
                                        <th>Hành động</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                               <th>STT</th>
                                        <th>Số khiếu nại</th>
                                        <th>Họ và tên</th>
                                        <th>Số điện thoại</th>
                                        <th>Email</th>
                                    <th>Trạng thái</th>
                                        <th>Hành động</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <tr>
                                               <?php
                                               $uid=$_SESSION['uuid']; 
$sql="SELECT tbllodgedcomplain.ComplainNumber, tbllodgedcomplain.AssignTo, tbllodgedcomplain.ID as compid, tbllodgedcomplain.Status, tbluser.ID as uid, tbluser.FullName, tbluser.MobileNumber, tbluser.Email 
FROM tbllodgedcomplain 
JOIN tbluser ON tbluser.ID=tbllodgedcomplain.UserID 
WHERE tbllodgedcomplain.ComplainNumber LIKE '%$sdata%' AND tbllodgedcomplain.UserID=:uid";
$query = $dbh -> prepare($sql);
$query-> bindParam(':uid', $uid, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $row)
{               ?>
                                              <td><?php echo htmlentities($cnt);?></td>
                                        <td><?php  echo htmlentities($row->ComplainNumber);?></td>
                                        <td><?php  echo htmlentities($row->FullName);?></td>
                                        <td><?php  echo htmlentities($row->MobileNumber);?></td>
                                        <td><?php  echo htmlentities($row->Email);?></td>
                                             <?php if($row->Status==""){ ?>

                     <td><?php echo "Chưa cập nhật"; ?></td>
<?php } else { ?>                  
<td><?php  echo htmlentities($row->Status);?> (Giao cho <?php  echo htmlentities($row->AssignTo);?>)
</td>
<?php } ?>         
                  <td><a href="view-lodged-complain-detail.php?editid=<?php echo htmlentities ($row->compid);?>&&comid=<?php echo htmlentities ($row->ComplainNumber);?>"><i class="fa fa-eye" aria-hidden="true"></i></a></td>
                                            </tr>
                                        <?php 
$cnt=$cnt+1;
} } else { ?>
  <tr>
    <td colspan="8"> Không có kết quả tìm kiếm nào</td>

  </tr>
  <?php } } ?>
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