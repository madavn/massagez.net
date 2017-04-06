<?php defined("WEB_APP") or die("Please wait ... <META http-equiv=\"refresh\" content=\"0; url=".WEBSITE_URL."\" />");?>
<div class="navbar navbar-default" id="navbar">
    <div class="navbar-container center" id="navbar-container">
        <div class="navbar-header pull-left">
            <a class="navbar-brand" href="<?=WEBSITE_URL;?>"><?=$strtitle;?></a>
        </div>
        <div class="navbar-header pull-right">
            
            
        </div>
        <a class="btn btn-danger" href="<?=WEBSITE_URL_CP;?>?components=khoadatcho">Khóa thu ngân</a>
    </div>
</div>
<div id="main-container" class="main-container">
    <div class="main-container-inner">
        <a href="#" id="menu-toggler" class="menu-toggler">
			<span class="menu-text"></span>
		</a>
        <div id="sidebar" class="sidebar">
            <ul class="nav nav-list">
                <li>
                    <a href="<?=WEBSITE_URL_CP;?>?components=changepassword">
                        <span class="menu-text">Đổi mật khẩu</span>
                    </a>
                </li>
                <li>
                    <a class="dropdown-toggle" href="javascript:;">
                        <span class="menu-text">Thống kê</span>
                        <b class="arrow icon-angle-down"></b>
                    </a>
                    <ul class="submenu" style="display: block;">
                        <li>
                            <a href="<?=WEBSITE_URL_CP;?>">
                                <span class="menu-text">Thống kê tổng quát</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?=WEBSITE_URL_CP;?>?components=stats">
                                <span class="menu-text">Thống kê theo tháng</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?=WEBSITE_URL_CP;?>?components=invoice">
                                <span class="menu-text">Thống kê theo ngày</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?=WEBSITE_URL_CP;?>?components=stats_ktv">
                                <span class="menu-text">Thống kê thu nhập KTV</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?=WEBSITE_URL_CP;?>?components=chitieu">
                                <span class="menu-text">Chi tiêu</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?=WEBSITE_URL_CP;?>?components=voucher">
                                <span class="menu-text">Code khuyến mãi</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a class="dropdown-toggle" href="javascript:;">
                        <span class="menu-text">Thông tin DN</span>
                        <b class="arrow icon-angle-down"></b>
                    </a>
                    <ul class="submenu" style="display: block;">
                        <li>
                            <a href="<?=WEBSITE_URL_CP;?>?components=office">
                                <span class="menu-text">Thông tin DN</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?=WEBSITE_URL_CP;?>?components=room">
                                <span class="menu-text">Thông tin phòng</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a class="dropdown-toggle" href="javascript:;">
                        <span class="menu-text">Giá vé</span>
                        <b class="arrow icon-angle-down"></b>
                    </a>
                    <ul class="submenu" style="display: block;">
                        <li>
                            <a href="<?=WEBSITE_URL_CP;?>?components=servicesgroup">
                                <span class="menu-text">Giá vé</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?=WEBSITE_URL_CP;?>?components=services">
                                <span class="menu-text">Kỹ thuật viên</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?=WEBSITE_URL_CP;?>?components=servicesfieldtext">
                                <span class="menu-text">Thông tin KTV</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="<?=WEBSITE_URL_CP;?>?components=user">
                        <span class="menu-text">Phân quyền nhân viên</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="main-content">
            <div id="breadcrumbs" class="breadcrumbs">
            </div>
            <div class="page-content">
                <div class="row position-relative">