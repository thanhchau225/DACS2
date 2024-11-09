<div class="left_sidebar">
    <nav class="sidebar">
        <div class="user-info">
            <div class="image"><a href="javascript:void(0);"><img src="../assets/images/user.png" alt="Người dùng"></a></div>
            <div class="detail mt-3">
                <?php
                $aid = $_SESSION['vamsaid'];
                $sql = "SELECT AdminName, Email from tbladmin where ID=:aid";
                $query = $dbh->prepare($sql);
                $query->bindParam(':aid', $aid, PDO::PARAM_STR);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ);
                $cnt = 1;
                if ($query->rowCount() > 0) {
                    foreach ($results as $row) { ?>
                        <h5 class="mb-0"><?php echo $row->AdminName; ?></h5>
                        <small><?php echo $row->Email; ?></small><?php $cnt = $cnt + 1;
                    }
                } ?>
            </div>
        </div>
        <ul id="main-menu" class="metismenu">
            <li class="active"><a href="dashboard.php"><i class="ti-home"></i><span>Bảng điều khiển</span></a></li>
            <li>
                <a href="" class="has-arrow"><i class="ti-folder"></i><span>Tạo thùng rác</span></a>
                <ul>
                    <li><a href="add-bin.php">Thêm thùng rác</a></li>
                    <li><a href="manage-bin.php">Quản lý thùng rác</a></li>
                </ul>
            </li>
            <li>
                <a href="" class="has-arrow"><i class="ti-user"></i><span>Người lái xe</span></a>
                <ul>
                    <li><a href="add-driver.php">Thêm người lái xe</a></li>
                    <li><a href="manage-driver.php">Quản lý người lái xe</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0)" class="has-arrow"><i class="ti-files"></i><span>Khiếu nại</span></a>
                <ul>
                    <li><a href="all-complain.php">Tất cả khiếu nại</a></li>
                    <li><a href="new-complain.php">Khiếu nại mới</a></li>
                    <li><a href="assign-complain.php">Gán khiếu nại</a></li>
                    <li><a href="rejected-complain.php">Khiếu nại bị từ chối</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0)" class="has-arrow"><i class="ti-view-list"></i><span>Phản hồi khiếu nại của người lái xe</span></a>
                <ul>
                    <li><a href="ontheway-complain.php">Đang trên đường</a></li>
                    <li><a href="completed-complain.php">Rác đã được dọn</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0)" class="has-arrow"><i class="ti-view-list"></i><span>Phản hồi thùng rác của người lái xe</span></a>
                <ul>
                    <li><a href="ontheway.php">Đang trên đường</a></li>
                    <li><a href="completed.php">Nhiệm vụ đã hoàn thành</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0)" class="has-arrow"><i class="ti-search"></i><span>Tìm kiếm</span></a>
                <ul>
                    <li><a href="search-bin.php">Tìm kiếm thùng rác</a></li>
                    <li><a href="search-complain.php">Tìm kiếm khiếu nại đã nộp</a></li>
                </ul>
            </li>
        </ul>            
    </nav>
</div>
