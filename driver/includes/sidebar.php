<div class="left_sidebar">
    <nav class="sidebar">
        <div class="user-info">
            <div class="image"><a href="javascript:void(0);"><img src="../assets/images/user.png" alt="User"></a></div>
            <div class="detail mt-3">
                <?php
                     $did=$_SESSION['vamsdid'];
                    $sql="SELECT Name,Email from  tbldriver where DriverID=:did";
                    $query = $dbh -> prepare($sql);
                    $query->bindParam(':did',$did,PDO::PARAM_STR);
                    $query->execute();
                    $results=$query->fetchAll(PDO::FETCH_OBJ);

                    foreach($results as $row)
                    {    
                    $email=$row->Email;   
                    $fname=$row->Name;     
                    }   
                ?>
                <h5 class="mb-0"><?php  echo $fname ;?></h5>
                <small><?php  echo $email ;?></small>
            </div>
        </div>
        <ul id="main-menu" class="metismenu">
        
            <li class="active"><a href="dashboard.php"><i class="ti-home"></i><span>Bảng điều khiển</span></a></li>
           
            <li>
                <a href="javascript:void(0)" class="has-arrow"><i class="ti-pencil-alt"></i><span>Giao khiếu nại</span></a>
                <ul>
                    <li><a href="new-complain-request.php">Khiếu nại mới</a></li>
                    <li><a href="ontheway-complain.php">Khiếu nại đang xử lý</a></li>
                    <li><a href="completed-complain.php">Khiếu nại đã hoàn thành</a></li>
                    <li><a href="all-complain.php">Tất cả khiếu nại</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0)" class="has-arrow"><i class="ti-pencil-alt"></i><span>Giao thùng rác</span></a>
                <ul>
                    <li><a href="new-request.php">Thùng rác mới</a></li>
                    <li><a href="ontheway.php">Thùng rác đang xử lý</a></li>
                    <li><a href="completed.php">Thùng rác đã hoàn thành</a></li>
                    <li><a href="total-request.php">Tổng số thùng rác</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0)" class="has-arrow"><i class="ti-search"></i><span>Tìm kiếm</span></a>
                <ul>
                    <li><a href="search-bin.php">Tìm kiếm thùng rác</a></li>
                    <li><a href="search-complain.php">Tìm kiếm khiếu nại đã đăng</a></li>
                </ul>
            </li>
            
            <li class="open-top">
                <a href="javascript:void(0)" class="has-arrow"><i class="ti-lock"></i><span>Báo cáo</span></a>
                <ul>
                    <li><a class="dropdown-item" href="collected-bin-report.php">Báo cáo thùng rác đã thu gom</a></li>
                    <li><a class="dropdown-item" href="lodged-complain-report.php">Báo cáo khiếu nại đã đăng</a></li>
                </ul>
            </li>
        </ul>            
    </nav>
</div>
