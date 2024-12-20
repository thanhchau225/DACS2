<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['vamsaid'] == 0)) {
    header('location:logout.php');
} else {
    if (isset($_POST['submit'])) {

        $binid = $_POST['binid'];
        $area = $_POST['area'];
        $locality = $_POST['locality'];
        $landmark = $_POST['landmark'];
        $loadtype = $_POST['loadtype'];
        $cycleperiod = $_POST['cycleperiod'];
        $address = $_POST['address'];
        $assignee = $_POST['assignee'];
        
        $ret = "select BinID from tblbin where BinID=:binid";
        $query = $dbh->prepare($ret);
        $query->bindParam(':binid', $binid, PDO::PARAM_STR);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        
        if ($query->rowCount() == 0) {

            $sql = "insert into tblbin(BinID, Area, Locality, Landmark, LoadType, CyclePeriod, Address, DriverAssignee) values(:binid, :area, :locality, :landmark, :loadtype, :cycleperiod, :address, :assignee)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':binid', $binid, PDO::PARAM_STR);
            $query->bindParam(':area', $area, PDO::PARAM_STR);
            $query->bindParam(':locality', $locality, PDO::PARAM_STR);
            $query->bindParam(':landmark', $landmark, PDO::PARAM_STR);
            $query->bindParam(':loadtype', $loadtype, PDO::PARAM_STR);
            $query->bindParam(':cycleperiod', $cycleperiod, PDO::PARAM_STR);
            $query->bindParam(':address', $address, PDO::PARAM_STR);
            $query->bindParam(':assignee', $assignee, PDO::PARAM_STR);
            $query->execute();

            $LastInsertId = $dbh->lastInsertId();
            if ($LastInsertId > 0) {
                echo '<script>alert("Thùng rác đã được tạo và giao thành công.")</script>';
                echo "<script>window.location.href ='add-bin.php'</script>";
            } else {
                echo '<script>alert("Có gì đó không đúng. Vui lòng thử lại")</script>';
            }

        } else {
            echo "<script>alert('Mã thùng rác đã tồn tại. Vui lòng thử lại');</script>";
        }
    }
?>
<!doctype html>
<html lang="vi">
<head>
    <title>Hệ thống quản lý rác thải: Thêm thùng rác</title>
    <link rel="stylesheet" href="../assets/vendor/themify-icons/themify-icons.css">
    <link rel="stylesheet" href="../assets/vendor/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css">
    <link rel="stylesheet" href="../assets/vendor/parsleyjs/css/parsley.css">
    <link rel="stylesheet" href="../assets/css/main.css" type="text/css">
</head>
<body class="theme-indigo">
    <?php include_once('includes/header.php'); ?>

    <div class="main_content" id="main-content">
        <?php include_once('includes/sidebar.php'); ?>

        <div class="page">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="javascript:void(0);">Thêm thùng rác</a>
            </nav>
            <div class="container-fluid">
                <div class="row clearfix">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h2>Thêm thùng rác</h2>
                            </div>
                            <div class="body">
                                <form method="post">
                                    <div class="form-group">
                                        <label>Mã thùng rác</label>
                                        <input type="text" class="form-control" id="binid" name="binid" value="" required='true' maxlength="10">
                                    </div>
                                    <div class="form-group">
                                        <label>Khu vực</label>
                                        <input type="text" class="form-control" id="area" name="area" value="" required='true'>
                                    </div>
                                    <div class="form-group">
                                        <label>Khu phố</label>
                                        <input type="text" class="form-control" id="locality" name="locality" value="" required="true">
                                    </div>
                                    <div class="form-group">
                                        <label>Điểm mốc</label>
                                        <input type="text" class="form-control" id="landmark" name="landmark" value="" required='true'>
                                    </div>
                                    <div class="form-group">
                                        <label>Loại tải</label>
                                        <select class="form-control" id="loadtype" name="loadtype" value="" required='true'>
                                            <option value="">Chọn loại tải</option>
                                            <option value="High">Cao</option>
                                            <option value="Medium">Trung bình</option>
                                            <option value="Low">Thấp</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Chu kỳ</label>
                                        <select class="form-control" id="cycleperiod" name="cycleperiod" value="" required='true'>
                                            <option value="">Chọn chu kỳ</option>
                                            <option value="Daily">Hàng ngày</option>
                                            <option value="Alternate">Luân phiên</option>
                                            <option value="Weekly">Hàng tuần</option>
                                            <option value="Monthly">Hàng tháng</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Địa chỉ tuyến xe buýt</label>
                                        <textarea type="text" class="form-control" id="address" name="address" value="" required='true'></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Giao cho lái xe</label>
                                        <select name="assignee" placeholder="Giao cho" class="form-control" required='true'>
                                            <option value="">Giao cho</option>
                                            <?php 
                                            $sql2 = "SELECT * from tbldriver ";
                                            $query2 = $dbh->prepare($sql2);
                                            $query2->execute();
                                            $result2 = $query2->fetchAll(PDO::FETCH_OBJ);

                                            foreach ($result2 as $row) { ?>  
                                                <option value="<?php echo htmlentities($row->DriverID); ?>"><?php echo htmlentities($row->DriverID); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    
                                    <br>
                                    <button type="submit" class="btn btn-primary" name="submit">Gửi</button>
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
</html>
<?php } ?>
