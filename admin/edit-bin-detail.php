<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['vamsaid']==0)) {
  header('location:logout.php');
  } else{
    if(isset($_POST['submit']))
  {



$area=$_POST['area'];
$locality=$_POST['locality'];
$landmark=$_POST['landmark'];
$loadtype=$_POST['loadtype'];
$cycleperiod=$_POST['cycleperiod'];
$address=$_POST['address'];
$assignee=$_POST['assignee'];
$eid=$_GET['editid'];



$sql="update tblbin set Area=:area, Locality=:locality, Landmark=:landmark, LoadType=:loadtype, CyclePeriod=:cycleperiod, Address=:address, DriverAssignee=:assignee where ID=:eid";
$query=$dbh->prepare($sql);

$query->bindParam(':area',$area,PDO::PARAM_STR);
$query->bindParam(':locality',$locality,PDO::PARAM_STR);
$query->bindParam(':landmark',$landmark,PDO::PARAM_STR);
$query->bindParam(':loadtype',$loadtype,PDO::PARAM_STR);
$query->bindParam(':cycleperiod',$cycleperiod,PDO::PARAM_STR);
$query->bindParam(':address',$address,PDO::PARAM_STR);
$query->bindParam(':assignee',$assignee,PDO::PARAM_STR);
$query->bindParam(':eid',$eid,PDO::PARAM_STR);
$query->execute();

  echo '<script>alert("Thông tin thùng rác đã được cập nhật")</script>';
}

?>
<!doctype html>
<html lang="vi">
<head>
<title>Hệ Thống Quản Lý Rác Thải: Cập nhật chi tiết thùng rác</title>

<link rel="stylesheet" href="../assets/vendor/themify-icons/themify-icons.css">
<link rel="stylesheet" href="../assets/vendor/fontawesome/css/font-awesome.min.css">

<link rel="stylesheet" href="../assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css">
<link rel="stylesheet" href="../assets/vendor/parsleyjs/css/parsley.css">

<link rel="stylesheet" href="../assets/css/main.css" type="text/css">
</head>
<body class="theme-indigo">
    <?php include_once('includes/header.php');?>

    <div class="main_content" id="main-content">
       <?php include_once('includes/sidebar.php');?>


        <div class="page">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="javascript:void(0);">Cập nhật thùng rác</a>
               
            </nav>
            <div class="container-fluid">
                <div class="row clearfix">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h2>Cập nhật thùng rác</h2>
                            </div>
                            <div class="body">
                                <form id="" method="post" novalidate>
                                    <?php
$eid=$_GET['editid'];
$sql="SELECT tbldriver.ID, tbldriver.DriverID, tblbin.ID, tblbin.* from tblbin join tbldriver on tbldriver.DriverID=tblbin.DriverAssignee where tblbin.ID=$eid";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $row)
{ ?>
                                   <div class="form-group">
                                        <label>ID Thùng Rác</label>
                                        <input type="text" class="form-control" id="binid" name="binid" value="<?php echo $row->BinID;?>" required='true' maxlength="10">
                                    </div>
                                    <div class="form-group">
                                        <label>Khu Vực</label>
                                       <input type="text" class="form-control" id="area" name="area" value="<?php echo $row->Area;?>" required='true'>
                                    </div>
                                    <div class="form-group">
                                        <label>Địa Phương</label>
                                        <input type="text" class="form-control" id="locality" name="locality" value="<?php echo $row->Locality;?>" required="true">
                                    </div>
                                    <div class="form-group">
                                        <label>Mốc Địa Điểm</label>
                                        <input type="text" class="form-control" id="landmark" name="landmark" value="<?php echo $row->Landmark;?>" required='true'>
                                    </div>
                                    <div class="form-group">
                                        <label>Loại Tải</label>
                                        <select class="form-control" id="loadtype" name="loadtype" required='true'>
                                            <option value="<?php echo $row->LoadType;?>"><?php echo $row->LoadType;?></option>
                                            <option value="High">Cao</option>
                                            <option value="Medium">Trung bình</option>
                                            <option value="Low">Thấp</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Chu Kỳ</label>
                                        <select class="form-control" id="cycleperiod" name="cycleperiod" required='true'>
                                            <option value="<?php echo $row->CyclePeriod;?>"><?php echo $row->CyclePeriod;?></option>
                                            <option value="Daily">Hàng ngày</option>
                                            <option value="Alternate">Cách ngày</option>
                                            <option value="Weekly">Hàng tuần</option>
                                            <option value="Monthly">Hàng tháng</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Địa Chỉ Tuyến Xe Buýt</label>
                                         <textarea type="text" class="form-control" id="address" name="address" required='true'><?php echo $row->Address;?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Phân Công Tài Xế</label>
                                        
                                         <select name="assignee" placeholder="Gán cho" class="form-control" required='true'>
        <option value="<?php echo $row->DriverAssignee;?>"><?php echo $row->DriverAssignee;?></option>
        <?php 
$sql2 = "SELECT * from tbldriver";
$query2 = $dbh -> prepare($sql2);
$query2->execute();
$result2=$query2->fetchAll(PDO::FETCH_OBJ);

foreach($result2 as $row2)
{ ?>  
<option value="<?php echo htmlentities($row2->DriverID);?>"><?php echo htmlentities($row2->DriverID);?></option>
 <?php } ?>
    </select>
                                    </div>
                                    
                                     <?php $cnt=$cnt+1;}} ?>
                                    <br>
                                    <button type="submit" class="btn btn-primary" name="submit">Cập nhật</button>
                                </form>
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

<script src="../assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js"></script>
<script src="../assets/vendor/parsleyjs/js/parsley.min.js"></script>

<!-- Theme JS -->
<script src="../assets/js/theme.js"></script>
<script>
    $(function() {
        // validation needs name of the element
        $('#food').multiselect();

        // initialize after multiselect
        $('#basic-form').parsley();
    });
</script>
</body>
</html><?php } ?>
