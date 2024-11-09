<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

// Kiểm tra xem nút đăng nhập có được nhấn không
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $sql = "SELECT ID FROM tbladmin WHERE UserName=:username and Password=:password";
    $query = $dbh->prepare($sql);
    $query->bindParam(':username', $username, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    
    // Kiểm tra xem có kết quả không
    if ($query->rowCount() > 0) {
        foreach ($results as $result) {
            $_SESSION['vamsaid'] = $result->ID;
        }

        // Kiểm tra xem người dùng có chọn "Ghi nhớ" không
        if (!empty($_POST["remember"])) {
            // Đặt cookie cho tên đăng nhập
            setcookie("user_login", $_POST["username"], time() + (10 * 365 * 24 * 60 * 60));
            // Đặt cookie cho mật khẩu
            setcookie("userpassword", $_POST["password"], time() + (10 * 365 * 24 * 60 * 60));
        } else {
            // Nếu không chọn ghi nhớ, xóa cookie
            if (isset($_COOKIE["user_login"])) {
                setcookie("user_login", "");
                if (isset($_COOKIE["userpassword"])) {
                    setcookie("userpassword", "");
                }
            }
        }

        $_SESSION['login'] = $_POST['username'];
        echo "<script type='text/javascript'> document.location ='dashboard.php'; </script>";
    } else {
        echo "<script>alert('Thông tin không hợp lệ');</script>";
    }
}
?>
<!doctype html>
<html lang="vi">

<head>
    <title>Hệ thống quản lý rác thải: Đăng nhập</title>
    <link rel="stylesheet" href="../assets/vendor/themify-icons/themify-icons.css">
    <link rel="stylesheet" href="../assets/vendor/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/css/main.css" type="text/css">
</head>

<body class="theme-indigo">
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="m-t-30"><img src="../assets/images/brand/icon_black.svg" width="48" height="48" alt="ArrOw"></div>
            <p>Vui lòng chờ...</p>
        </div>
    </div>
    <!-- WRAPPER -->
    <div id="wrapper">
        <div class="vertical-align-wrap">
            <div class="vertical-align-middle auth-main">
                <div class="auth-box">
                    <div class="top">
                        <strong>Hệ thống</strong> <span>quản lý rác thải</span>
                    </div>
                    <div class="card">
                        <div class="header">
                            <p class="lead">Đăng nhập vào tài khoản của bạn</p>
                        </div>
                        <div class="body">
                            <form class="form-auth-small" action="" method="post">
                                <div class="form-group">
                                    <label for="signin-email" class="control-label sr-only">Tên đăng nhập</label>
                                    <input type="text" class="form-control" placeholder="Tên đăng nhập" required="true" name="username" value="<?php if (isset($_COOKIE["user_login"])) { echo $_COOKIE["user_login"]; } ?>">
                                </div>
                                <div class="form-group">
                                    <label for="signin-password" class="control-label sr-only">Mật khẩu</label>
                                    <input type="password" class="form-control" placeholder="Mật khẩu" name="password" required="true" value="<?php if (isset($_COOKIE["userpassword"])) { echo $_COOKIE["userpassword"]; } ?>">
                                </div>
                                <div class="form-group clearfix">
                                    <label class="fancy-checkbox element-left">
                                        <input type="checkbox" id="remember" name="remember" <?php if (isset($_COOKIE["user_login"])) { ?> checked <?php } ?>>
                                        <span>Ghi nhớ tôi</span>
                                    </label>
                                </div>
                                <button type="submit" class="btn btn-primary btn-lg btn-block" name="login">ĐĂNG NHẬP</button>
                                <div class="bottom">
                                    <span class="helper-text m-b-10"><i class="fa fa-lock"></i> <a href="forgot-password.php">Quên mật khẩu?</a></span>
                                    <a href="../index.php">Trở về trang chủ!!</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END WRAPPER -->
    
    <!-- Core -->
    <script src="../assets/bundles/libscripts.bundle.js"></script>
    <script src="../assets/bundles/vendorscripts.bundle.js"></script>
    <script src="../assets/js/theme.js"></script>
</body>
</html>
