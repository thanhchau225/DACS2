<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if(isset($_POST['submit']))
{
    $fname = $_POST['fname'];
    $uname = $_POST['uname'];
    $mobno = $_POST['mobno'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $ret = "SELECT Email, UserName FROM tbluser WHERE Email = :email || UserName = :uname";
    $query = $dbh->prepare($ret);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':uname', $uname, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);

    if($query->rowCount() == 0)
    {
        $sql = "INSERT INTO tbluser (FullName, UserName, MobileNumber, Email, Password) 
                VALUES (:fname, :uname, :mobno, :email, :password)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':fname', $fname, PDO::PARAM_STR);
        $query->bindParam(':uname', $uname, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':mobno', $mobno, PDO::PARAM_INT);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->execute();
        $lastInsertId = $dbh->lastInsertId();
        if($lastInsertId)
        {
            echo "<script>alert('Bạn đã đăng ký thành công với chúng tôi');</script>";
        }
        else
        {
            echo "<script>alert('Có lỗi xảy ra. Vui lòng thử lại');</script>";
        }
    }
    else
    {
        echo "<script>alert('Email đã tồn tại. Vui lòng thử lại');</script>";
    }
}
?>
<!doctype html>
<html lang="vi">

<head>
    <title>Hệ thống quản lý rác thải: Đăng ký</title>
    <link rel="stylesheet" href="../assets/vendor/themify-icons/themify-icons.css">
    <link rel="stylesheet" href="../assets/vendor/fontawesome/css/font-awesome.min.css">

    <link rel="stylesheet" href="../assets/css/main.css" type="text/css">
</head>

<body class="theme-indigo">
    <!-- Trình tải trang -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="m-t-30"><img src="../assets/images/brand/icon_black.svg" width="48" height="48" alt="ArrOw"></div>
            <p>Vui lòng đợi...</p>
        </div>
    </div>
    <!-- KHUNG -->
    <div id="wrapper">
        <div class="vertical-align-wrap">
            <div class="vertical-align-middle auth-main">
                <div class="auth-box">
                    <div class="top">
                        <strong>Hệ thống</strong> <span>Quản lý rác thải</span>
                    </div>
                    <div class="card">
                        <div class="header">
                            <p class="lead">Đăng ký với chúng tôi</p>
                        </div>
                        <div class="body">
                            <form class="form-auth-small" action="" method="post">
                                <div class="form-group">
                                    <label for="signin-email" class="control-label sr-only">Họ và tên</label>
                                    <input type="text" class="form-control" placeholder="Nhập tên của bạn" required="true" name="fname" value="">
                                </div>
                                <div class="form-group">
                                    <label for="signin-email" class="control-label sr-only">Tên người dùng</label>
                                    <input type="text" class="form-control" placeholder="Nhập tên người dùng" required="true" name="uname" value="">
                                </div>
                                <div class="form-group">
                                    <label for="signin-email" class="control-label sr-only">Số điện thoại</label>
                                    <input type="text" class="form-control" placeholder="Nhập số điện thoại" required="true" name="mobno" value="" maxlength="10" pattern="[0-9]{10}">
                                </div>
                                <div class="form-group">
                                    <label for="signin-email" class="control-label sr-only">Địa chỉ email</label>
                                    <input type="email" class="form-control" placeholder="Nhập email của bạn" required="true" name="email" value="">
                                </div>
                                <div class="form-group">
                                    <label for="signin-password" class="control-label sr-only">Mật khẩu</label>
                                    <input type="password" class="form-control" placeholder="Mật khẩu" name="password" required="true" value="">
                                </div>
                                <button type="submit" class="btn btn-primary btn-lg btn-block" name="submit">Đăng ký</button>
                                <div class="bottom">
                                    <span class="helper-text m-b-10"><i class="fa fa-lock"></i> <a href="login.php">Đăng nhập</a></span>
                                    <a href="../index.php">Quay lại trang chủ!!</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- KẾT THÚC KHUNG -->

    <!-- Core -->
    <script src="../assets/bundles/libscripts.bundle.js"></script>
    <script src="../assets/bundles/vendorscripts.bundle.js"></script>

    <script src="../assets/js/theme.js"></script>
</body>
</html>
