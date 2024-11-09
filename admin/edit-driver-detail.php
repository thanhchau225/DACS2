<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['vamsaid']==0)) {
  header('location:logout.php');
  } else{
    if(isset($_POST['submit']))
  {

    // Lấy dữ liệu từ form
    $name=$_POST['name'];
    $mobnum=$_POST['mobnum'];
    $email=$_POST['email'];
    $address=$_POST['address'];
    $eid=$_GET['editid'];

    // Cập nhật thông tin tài xế trong cơ sở dữ liệu
    $sql="UPDATE tbldriver SET Name=:name, MobileNumber=:mobnum, Email=:email, Address=:address WHERE ID=:eid";
    $query=$dbh->prepare($sql);

    $query->bindParam(':name', $name, PDO::PARAM_STR);
    $query->bindParam(':mobnum', $mobnum, PDO::PARAM_STR);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':address', $address, PDO::PARAM_STR);
    $query->bindParam(':eid', $eid, PDO::PARAM_STR);
    $query->execute();

    echo '<script>alert("Thông tin tài xế đã được cập nhật")</script>';
  }
?>

<!doctype html>
<html lang="vi">
<head>
<title>Hệ Thống Quản Lý Rác Thải: Cập Nhật Tài Xế</title>

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
                <a class="navbar-brand" href="javascript:void(0);">Cập Nhật Tài Xế</a>
            </nav>
            <div class="container-fluid">
                <div class="row clearfix">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h2>Cập Nhật Tài Xế</h2>
                            </div>
                            <div class="body">
                                <form id="" method="post" novalidate>
                                    <?php
                                    // Lấy ID tài xế để hiển thị thông tin hiện tại
                                    $eid=$_GET['editid'];
                                    $sql="SELECT * FROM tbldriver WHERE ID=$eid";
                                    $query = $dbh -> prepare($sql);
                                    $query->execute();
                                    $results=$query->fetchAll(PDO::FETCH_OBJ);
                                    $cnt=1;
                                    if($query->rowCount() > 0) {
                                        foreach($results as $row) {               
                                    ?>
                                    <div class="form-group">
                                        <label>Mã Tài Xế</label>
                                        <input type="text" class="form-control" name="driid" value="<?php echo htmlentities($row->DriverID);?>" readonly='true' maxlength="10">
                                    </div>
                                    <div class="form-group">
                                        <label>Tên</label>
                                       <input type="text" class="form-control"  name="name" value="<?php echo htmlentities($row->Name);?>" required='true'>
                                    </div>
                                    <div class="form-group">
                                        <label>Số Điện Thoại</label>
                                        <input type="text" class="form-control" name="mobnum" value="<?php echo htmlentities($row->MobileNumber);?>" required="true" maxlength="10" pattern="[0-9]+">
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" class="form-control" id="email2" name="email" value="<?php echo htmlentities($row->Email);?>" required='true'>
                                    </div>
                                    <div class="form-group">
                                        <label>Địa Chỉ</label>
                                         <textarea type="text" class="form-control" name="address" required='true'><?php echo htmlentities($row->Address);?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Ngày Tham Gia</label>
                                        <input type="text" class="form-control" name="" value="<?php echo htmlentities($row->JoiningDate);?>" readonly='true'>
                                    </div>
                                     <?php $cnt=$cnt+1;}} ?>
                                    <br>
                                    <button type="submit" class="btn btn-primary" name="submit">Cập Nhật</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Thư viện cốt lõi -->
<script src="../assets/bundles/libscripts.bundle.js"></script>
<script src="../assets/bundles/vendorscripts.bundle.js"></script>

<script src="../assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js"></script>
<script src="../assets/vendor/parsleyjs/js/parsley.min.js"></script>

<!-- JS Giao Diện -->
<script src="../assets/js/theme.js"></script>
<script>
    $(function() {
        // Cần tên của phần tử để xác thực
        $('#food').multiselect();

        // Khởi tạo sau khi multiselect
        $('#basic-form').parsley();
    });
</script>
</body>
</html>
<?php } ?>
