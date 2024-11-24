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
    $comid=$_GET['comid'];
    $status=$_POST['status'];
   $remark=$_POST['remark'];
 

    $sql="insert into tblcomtracking(ComplainNumber,Remark,Status) value(:comid,:remark,:status)";
    $query=$dbh->prepare($sql);
$query->bindParam(':comid',$comid,PDO::PARAM_STR); 
    $query->bindParam(':remark',$remark,PDO::PARAM_STR); 
    $query->bindParam(':status',$status,PDO::PARAM_STR); 
       $query->execute();
      $sql= "update tbllodgedcomplain set Status=:status,Remark=:remark where ID=:eid";

    $query=$dbh->prepare($sql);
$query->bindParam(':status',$status,PDO::PARAM_STR);
$query->bindParam(':remark',$remark,PDO::PARAM_STR);
$query->bindParam(':eid',$eid,PDO::PARAM_STR);
 $query->execute();
 echo '<script>alert("Remark has been updated")</script>';
 echo "<script>window.location.href ='all-complain.php'</script>";
}


  ?>
<!doctype html>
<html lang="vi">

<head>
  
    <title>Hệ Thống Quản Lý Rác: Xem Khiếu Nại</title>

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
                <a class="navbar-brand" href="javascript:void(0);">Xem Khiếu Nại Đã Gửi</a>
            </nav>
            <div class="container-fluid">            
                <div class="row clearfix">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="header">
                                <h2><strong>Xem</strong> Khiếu Nại Đã Gửi</h2>
                            </div>
                            <div class="body">
                                <div class="table-responsive">
                                    <?php
                  $eid=$_GET['editid'];
$sql="SELECT tbllodgedcomplain.ComplainNumber,tbllodgedcomplain.Area,tbllodgedcomplain.Locality,tbllodgedcomplain.Landmark,tbllodgedcomplain.Address,tbllodgedcomplain.Photo,tbllodgedcomplain.ID as compid,tbllodgedcomplain.Status,tbllodgedcomplain.ComplainDate,tbllodgedcomplain.Remark,tbllodgedcomplain.AssignTo,tbluser.ID as uid,tbluser.FullName,tbluser.MobileNumber,tbluser.Email from tbllodgedcomplain join tbluser on tbluser.ID=tbllodgedcomplain.UserID  where tbllodgedcomplain.ID=:eid";
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
    <th style="color: orange;">Số Khiếu Nại</th>
    <td colspan="4" style="color: orange;font-weight: bold;"><?php  echo $bookingno=($row->ComplainNumber);?></td>
  </tr>
  <tr>
    <th>Họ Tên</th>
    <td><?php  echo $row->FullName;?></td>
     <th>Email</th>
    <td><?php  echo $row->Email;?></td>
  </tr>
   <tr>
    <th>Số Điện Thoại</th>
    <td><?php  echo $row->MobileNumber;?></td>
    <th>Địa Chỉ Rác</th>
    <td><?php  echo $row->Address;?></td>
  </tr>
  <tr>
    <th>Khu Vực</th>
    <td><?php  echo $row->Area;?></td>
    <th>Địa Phương</th>
    <td><?php  echo $row->Locality;?></td>
  </tr>
  <tr>
    <th>Điểm Mốc</th>
    <td><?php  echo $row->Landmark;?></td>
    <th>Ghi Chú</th>
    <?php if($row->Note==""){ ?>

                     <td><?php echo "Không Có Ghi Chú"; ?></td>
<?php } else { ?>                  <td><?php  echo htmlentities($row->Note);?></td>
                  <?php } ?>
  </tr>
  <tr>
    <th>Hình Ảnh</th>
    <td colspan="4"><img src="../user/images/<?php echo $row->Photo;?>" width="200" height="150" value="<?php  echo $row->Photo;?>"></td>
  </tr>
  <tr>
    <th>Giao Cho</th>
    <?php if($row->AssignTo==""){ ?>

                     <td><?php echo "Chưa Cập Nhật"; ?></td>
<?php } else { ?>                  <td><?php  echo htmlentities($row->AssignTo);?></td>
                  <?php } ?>  
                   <th>Ngày Khiếu Nại</th>
    <td><?php  echo $row->ComplainDate;?></td>     
  </tr>
   <tr>
    <th>Tình Trạng Cuối Cùng Của Khiếu Nại</th>
   <td> <?php  $status=$row->Status;
    
if($row->Status=="Approved")
{
  echo "Yêu cầu của bạn đã được chấp nhận";
}

if($row->Status=="Rejected")
{
 echo "Yêu cầu của bạn đã bị hủy";
}
if($row->Status=="On the way")
{
 echo "Tài xế đang trên đường";
}
if($row->Status=="Completed")
{
 echo "Rác đã được thu gom";
}

if($row->Status=="")
{
  echo "Chưa có phản hồi";
}
     ;?></td>
    <th>Nhận Xét Của Quản Trị Viên</th>
    <?php if($row->Status==""){ ?>

                     <td  colspan="4"><?php echo "Chưa Cập Nhật"; ?></td>
<?php } else { ?>                  <td><?php  echo htmlentities($row->Status);?></td>
                  <?php } ?>  
  </tr>

  <?php $cnt=$cnt+1;}} ?>
                                            

                                    </table>
                                    <?php 
$comid=$_GET['comid']; 
   if($status!=""){
$ret="select tblcomtracking.Remark,tblcomtracking.Status,tblcomtracking.RemarkDate from tblcomtracking where tblcomtracking.ComplainNumber=:comid";
$query = $dbh -> prepare($ret);
$query-> bindParam(':comid', $comid, PDO::PARAM_STR);
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
   <td><?php  echo $row->RemarkDate;?></td> 
</tr>
<?php $cnt=$cnt+1;} ?>
</table>
<?php  }  
?>

<?php 

if ($status=="Approved" || $status=="On the way"){
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
     <option value="On the way" selected="true">Đang trên đường</option>
     <option value="Completed">Hoàn Thành</option>
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