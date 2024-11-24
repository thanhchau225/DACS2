<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if(isset($_POST['submit']))
  {
    $email=$_POST['email'];
    $mobile=$_POST['mobile'];
    $newpassword=md5($_POST['newpassword']);
    $sql ="SELECT Email FROM tbldriver WHERE Email=:email and MobileNumber=:mobile";
    $query= $dbh -> prepare($sql);
    $query-> bindParam(':email', $email, PDO::PARAM_STR);
    $query-> bindParam(':mobile', $mobile, PDO::PARAM_STR);
    $query-> execute();
    $results = $query -> fetchAll(PDO::FETCH_OBJ);
    if($query -> rowCount() > 0)
    {
        $con="update tbldriver set Password=:newpassword where Email=:email and MobileNumber=:mobile";
        $chngpwd1 = $dbh->prepare($con);
        $chngpwd1-> bindParam(':email', $email, PDO::PARAM_STR);
        $chngpwd1-> bindParam(':mobile', $mobile, PDO::PARAM_STR);
        $chngpwd1-> bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
        $chngpwd1->execute();
        echo "<script>alert('Mật khẩu của bạn đã được thay đổi thành công');</script>";
    }
    else {
        echo "<script>alert('Email hoặc Số điện thoại không hợp lệ');</script>"; 
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    
    <title>Hệ Thống Quản Lý Rác: Quên Mật Khẩu</title>
    <link rel="stylesheet" href="../assets/vendor/themify-icons/themify-icons.css">
    <link rel="stylesheet" href="../assets/vendor/fontawesome/css/font-awesome.min.css">

    <link rel="stylesheet" href="../assets/css/main.css" type="text/css">
    <script type="text/javascript">
function valid()
{
if(document.chngpwd.newpassword.value != document.chngpwd.confirmpassword.value)
{
alert("Mật khẩu mới và Mật khẩu xác nhận không khớp!");
document.chngpwd.confirmpassword.focus();
return false;
}
return true;
}
</script>
</head>

<body class="theme-indigo">
    <!-- Trình tải trang -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="m-t-30"><img src="../assets/images/brand/icon_black.svg" width="48" height="48" alt="ArrOw"></div>
            <p>Vui lòng đợi...</p>
        </div>
    </div>
	<!-- WRAPPER -->
	<div id="wrapper">
		<div class="vertical-align-wrap">
			<div class="vertical-align-middle auth-main">
				<div class="auth-box">
                    <div class="top">
                        <strong>Hệ Thống</strong> <span>Quản Lý Rác</span>
                    </div>
					<div class="card">
                        <div class="header">
                            <p class="lead">Đặt lại mật khẩu của bạn!!!</p>
                        </div>
                        <div class="body">
                            <form class="form-auth-small" action="" method="post" name="chngpwd" onSubmit="return valid();">
                                <div class="form-group">
                                    <label for="signin-email" class="control-label sr-only">Email</label>
                                   <input type="text" class="form-control" placeholder="Địa chỉ Email" required="true" name="email">
                                </div>
                                <div class="form-group">
                                    <label for="signin-email" class="control-label sr-only">Số điện thoại</label>
                                   <input type="text" class="form-control"  name="mobile" placeholder="Số điện thoại" required="true">
                                </div>
                                <div class="form-group">
                                    <label for="signin-email" class="control-label sr-only">Mật khẩu mới</label>
                                  <input class="form-control" type="password" name="newpassword" placeholder="Mật khẩu mới" required="true"/>
                                </div>
                                <div class="form-group">
                                    <label for="signin-password" class="control-label sr-only">Xác nhận mật khẩu</label>
                                    <input class="form-control" type="password" name="confirmpassword" placeholder="Xác nhận mật khẩu" required="true" />
                                </div>
                              
                                <button type="submit" class="btn btn-primary btn-lg btn-block" name="submit">RESET</button>
                                <div class="bottom">
                                    <span class="helper-text m-b-10"><i class="fa fa-lock"></i> <a href="login.php">Đã có tài khoản?</a><strong style="padding-left: 10px;">Đăng nhập</strong></span>
                                   
                                </div>
                            </form>
                        </div>
                    </div>
				</div>
			</div>
		</div>
	</div>
    <!-- Kết thúc WRAPPER -->
    
<!-- Core -->
<script src="../assets/bundles/libscripts.bundle.js"></script>
<script src="../assets/bundles/vendorscripts.bundle.js"></script>

<script src="../assets/js/theme.js"></script>
</body>
</html>
