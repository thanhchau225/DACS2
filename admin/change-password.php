<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
error_reporting(0);
if (strlen($_SESSION['vamsaid']==0)) {
  header('location:logout.php');
  } else{
if(isset($_POST['submit']))
{
$adminid=$_SESSION['vamsaid'];
$cpassword=md5($_POST['currentpassword']);
$newpassword=md5($_POST['newpassword']);
$sql ="SELECT ID FROM tbladmin WHERE ID=:adminid and Password=:cpassword";
$query= $dbh -> prepare($sql);
$query-> bindParam(':adminid', $adminid, PDO::PARAM_STR);
$query-> bindParam(':cpassword', $cpassword, PDO::PARAM_STR);
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);

if($query -> rowCount() > 0)
{
$con="update tbladmin set Password=:newpassword where ID=:adminid";
$chngpwd1 = $dbh->prepare($con);
$chngpwd1-> bindParam(':adminid', $adminid, PDO::PARAM_STR);
$chngpwd1-> bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
$chngpwd1->execute();

echo '<script>alert("Mật khẩu của bạn đã được thay đổi thành công")</script>';
} else {
echo '<script>alert("Mật khẩu hiện tại của bạn không đúng")</script>';

}
}

  
  ?>
<!doctype html>
<html lang="vi">
<head>
<title>Hệ Thống Quản Lý Rác Thải: Đổi Mật Khẩu</title>

<link rel="stylesheet" href="../assets/vendor/themify-icons/themify-icons.css">
<link rel="stylesheet" href="../assets/vendor/fontawesome/css/font-awesome.min.css">

<link rel="stylesheet" href="../assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css">
<link rel="stylesheet" href="../assets/vendor/parsleyjs/css/parsley.css">

<link rel="stylesheet" href="../assets/css/main.css" type="text/css">
<script type="text/javascript">
function checkpass()
{
if(document.changepassword.newpassword.value!=document.changepassword.confirmpassword.value)
{
alert('Mật khẩu mới và Mật khẩu xác nhận không khớp');
document.changepassword.confirmpassword.focus();
return false;
}
return true;
}   

</script>
</head>
<body class="theme-indigo">
    <?php include_once('includes/header.php');?>

    <div class="main_content" id="main-content">
       <?php include_once('includes/sidebar.php');?>

        <div class="page">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="javascript:void(0);">Đổi Mật Khẩu</a>
            </nav>
            <div class="container-fluid">
                <div class="row clearfix">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h2>Đổi Mật Khẩu</h2>
                            </div>
                            <div class="body">
                                <form id="" method="post" onsubmit="return checkpass();" name="changepassword" novalidate >
                                    
                                    <div class="form-group">
                                        <label>Mật Khẩu Hiện Tại</label>
                                        <input type="password" class="form-control" name="currentpassword" id="currentpassword"required='true'>
                                    </div>
                                    <div class="form-group">
                                        <label>Mật Khẩu Mới</label>
                                       <input type="password" class="form-control" name="newpassword"  class="form-control" required="true">
                                    <div class="form-group">
                                        <label>Xác Nhận Mật Khẩu</label>
                                        <input type="password" class="form-control"  name="confirmpassword" id="confirmpassword"  required='true'>
                                    </div>
                                    
                                    <br>
                                    <button type="submit" class="btn btn-primary" name="submit">Đổi</button>
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
        // yêu cầu kiểm tra tên của phần tử
        $('#food').multiselect();

        // khởi tạo sau multiselect
        $('#basic-form').parsley();
    });
</script>
</body>
</html><?php }  ?>
