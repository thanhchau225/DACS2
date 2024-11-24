<nav class="navbar custom-navbar navbar-expand-lg py-2">
    <div class="container-fluid px-0">
        <a href="dashboard.php" class="navbar-brand"><strong>HỆ THỐNG QUẢN LÝ RÁC THẢI</strong></a>
        <div id="navbar_main" class="collapse navbar-collapse">
           
            <ul class="navbar-nav ml-auto">
                <!-- Thông báo Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link nav-link-icon" href="#" id="navbar_1_dropdown_2" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-bell"></i>
                        <span class="badge badge-pill badge-primary"><?php echo $totalreq; ?></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <h5 class="dropdown-header">Thông báo khiếu nại</h5>
                        <div class="list-group">
                            <?php foreach($results as $row) { ?>
                                <a href="view-complain-detail.php?editid=<?php echo htmlentities($row->compid); ?>&comid=<?php echo htmlentities($row->ComplainNumber); ?>" class="list-group-item list-group-item-action d-flex">
                                    <div class="list-group-img"><span class="avatar bg-purple"><?php echo $row->ComplainNumber; ?></span></div>
                                    <div class="list-group-content">
                                        <div class="list-group-heading"><?php echo $row->FullName; ?><small><?php echo $row->DateofRequest; ?></small></div>
                                    </div>
                                </a>
                            <?php } ?>
                        </div>
                        <div class="py-3 text-center">
                            <a href="new-complain.php" class="link link-sm link--style-3">Xem tất cả thông báo</a>
                        </div>
                    </div>
                </li>
                <!-- Menu Quản trị viên Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link nav-link-icon" href="#" id="navbar_1_dropdown_3" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-user"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <h6 class="dropdown-header">Menu Quản trị viên</h6>
                        <a class="dropdown-item" href="profile.php"><i class="fa fa-user text-primary"></i> Hồ sơ của tôi</a>
                        <a class="dropdown-item" href="change-password.php"><i class="fa fa-cog text-primary"></i> Cài đặt</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="logout.php"><i class="fa fa-sign-out text-primary"></i> Đăng xuất</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
