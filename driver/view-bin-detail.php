<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['vamsid']==0)) {
  header('location:logout.php');
  } else{
if(isset($_POST['submit']))
  {
    
    $eid=$_GET['editid'];
    $binid=$_GET['binid'];
    $status=$_POST['status'];
   $remark=$_POST['remark'];
   $assignee=$_POST['assignee'];

    $sql="insert into tbltracking(BinID,Remark,Status) value(:binid,:remark,:status)";
    $query=$dbh->prepare($sql);
$query->bindParam(':binid',$binid,PDO::PARAM_STR); 
    $query->bindParam(':remark',$remark,PDO::PARAM_STR); 
    $query->bindParam(':status',$status,PDO::PARAM_STR); 
       $query->execute();
      $sql= "update tblbin set Status=:status,Remark=:remark where ID=:eid";

    $query=$dbh->prepare($sql);
   
$query->bindParam(':status',$status,PDO::PARAM_STR);
$query->bindParam(':remark',$remark,PDO::PARAM_STR);
$query->bindParam(':eid',$eid,PDO::PARAM_STR);
 $query->execute();
 echo '<script>alert("Remark has been updated")</script>';
 echo "<script>window.location.href ='total-request.php'</script>";
}


  ?>
<!doctype html>
<html lang="vi">

<head>
  
    <title>Hệ Thống Quản Lý Rác: Xem Chi Tiết Thùng Rác</title>

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
                <a class="navbar-brand" href="javascript:void(0);">Xem Chi Tiết Thùng Rác</a>
            </nav>
            <div class="container-fluid">            
                <div class="row clearfix">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="header">
                                <h2><strong>Xem Chi Tiết Thùng Rác</strong> </h2>
                            </div>
                            <div class="body">
                                <div class="table-responsive">
                                    <?php
                  $eid=$_GET['editid'];
$sql="SELECT * from tblbin  where ID=:eid";
$query = $dbh -> prepare($sql);
$query-> bindParam(':eid', $eid, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $row)
{               ?>
                                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                       <tr>
    <th style="color: orange;">ID Thùng Rác</th>
    <td colspan="4" style="color: orange;font-weight: bold;"><?php  echo $bookingno=($row->BinID);?></td>
  </tr>
  <tr>
    <th>Khu Vực</th>
    <td><?php  echo $row->Area;?></td>
     <th>Địa Phương</th>
    <td><?php  echo $row->Locality;?></td>
  </tr>
   <tr>
    <th>Điểm Nhận Diện</th>
    <td><?php  echo $row->Landmark;?></td>
    <th>Loại Tải</th>
    <td><?php  echo $row->LoadType;?></td>
  </tr>
  <tr>
    <th>Chu Kỳ</th>
    <td><?php  echo $row->CyclePeriod;?></td>
    <th>Địa Chỉ</th>
    <td><?php  echo $row->Address;?></td>
  </tr>
  <tr>
    <th>Tài Xế Giao</th>
    <?php if($row->DriverAssignee==""){ ?>

                     <td><?php echo "Chưa Cập Nhật"; ?></td>
<?php } else { ?>                  <td><?php  echo htmlentities($row->DriverAssignee);?></td>
                  <?php } ?>  
                  <th>Ngày Yêu Cầu</th>
    <td><?php  echo $row->AssignDate;?></td>     
  </tr>
   <tr>
    <th>Tình Trạng Cuối</th>
   <td> <?php  $status=$row->Status;
    
if($row->Status=="On The Way")
{
  echo "Tài xế đang trên đường";
}

if($row->Status=="Completed")
{
 echo "Yêu cầu của bạn đã được hoàn thành";
}
if($row->Status=="")
{
 echo "Chưa Cập Nhật";
}
     ;?></td>
    <th>Nhận Xét Của Tài Xế</th>
    <?php if($row->Status==""){ ?>

                     <td  colspan="4"><?php echo "Chưa Cập Nhật"; ?></td>
<?php } else { ?>                  <td><?php  echo htmlentities($row->Remark);?></td>
                  <?php } ?>  
  </tr>

  <?php $cnt=$cnt+1;}} ?>
                                            

                                    </table>
                                    <?php 
$binid=$_GET['binid']; 
   if($status!=""){
$ret="select tbltracking.Remark,tbltracking.Status,tbltracking.UpdationDate from tbltracking where tbltracking.BinID =:binid";
$query = $dbh -> prepare($ret);
$query-> bindParam(':binid', $binid, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
 ?>
<table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
  <tr align="center">
   <th colspan="4" style="color: blue" >Lịch Sử Theo Dõi</th> 
  </tr>
  <tr>
    <th>#</th>
<th>Nhận Xét</th>
<th>Tình Trạng</th>
<th>Thời Gian</th>
</tr>
<?php  
foreach($results as $row)
{               ?>
<tr>
  <td><?php echo $cnt;?></td>
 <td><?php  echo $row->Remark;?></td> 
  <td><?php  echo $row->Status;?></td> 
   <td><?php  echo $row->UpdationDate;?></td> 
</tr>
<?php $cnt=$cnt+1;} ?>
</table>
<?php  }  
?>

<?php 

if ($status=="" || $status=="On The Way"){
?> 
<p align="center"  style="padding-top: 20px">                            

 <button class="btn btn-primary waves-effect waves-light w-lg" data-toggle="modal" data-target="#myModal">Thực Hiện Hành Động</button></p>  

<?php } ?>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
     <div class="modal-content">
      <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Thực Hiện Hành Động</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                <table class="table table-bordered table-hover data-tables">

                                <form method="post" name="submit">

     <tr>
    <th>Nhận Xét :</th>
    <td>
    <textarea name="remark" placeholder="Nhận xét" rows="12" cols="14" class="form-control wd-450" required="true"></textarea></td>
  </tr> 
   
  <tr>
    <th>Tình Trạng :</th>
    <td>

   <select name="status" class="form-control wd-450" required="true" >
     <option value="On The Way" selected="true">Đang Trên Đường</option>
     <option value="Completed">Rác Đã Được Thu Gom</option>
   </select></td>
  </tr>
</table>
</div>
<div class="modal-footer">
 <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
 <button type="submit" name="submit" class="btn btn-primary">Cập Nhật</button>
  </form>
</div>

                       </div>
                    </div>

                        </div>

                    </div>
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