<?php
    $components = isset($_REQUEST["components"])?$_REQUEST["components"]:"home";
    $pages = isset($_GET["pages"]) && is_numeric($_GET["pages"])?$_GET["pages"]:1;
    $action = isset($_REQUEST["action"])?$_REQUEST["action"]:"";
    $gettype = isset($_REQUEST["type"])?$_REQUEST["type"]:"";
    
    $idsua = isset($_REQUEST["idsua"]) && is_numeric($_REQUEST["idsua"])?$_REQUEST["idsua"]:0;
    $idxoa = isset($_REQUEST["idxoa"]) && is_numeric($_REQUEST["idxoa"])?$_REQUEST["idxoa"]:0;

    global $database;
    $titlecomponents = "";
    $titleaction = "";
    $userlogin = array();
    
    //$statuscustomer = array("Đang làm dịch vụ", "Đang chờ dịch vụ", "Hẹn dịch vụ");
    $statuscustomer = array(
        0 => array("title" => "Không có khách", "class" => "black"),
        1 => array("title" => "Có khách", "class" => "green"),
        2 => array("title" => "Có khách, đã thanh toán", "class" => "pink"),
        
    );
    $dvt_array = array("Tiền mặt", "Phần trăm (%)");
    $action_array = array(
        "day" => array("id" => "day", "tieude" => "Theo ngày"),
        "month" => array("id" => "month", "tieude" => "Theo tháng"),
        "year" => array("id" => "year", "tieude" => "Theo năm"),
    );
    $voucher_status_array = array(
        0 => "Chưa sử dụng",
        1 => "Đã sử dụng",
        2 => "Đang sử dụng",
    );
    $permission_array = array(
        "office" => "Thông tin quán",
        "room" => "Thông tin phòng",
        "servicesgroup" => "Giá vé",
        "services" => "Kỹ thuật viên",
        "servicesfieldtext" => "Thông tin KTV",
        "servicesstore" => "Quản lý nhập kho",
        "feestore" => "Các chi phí khác",
        "voucher" => "Mã Code giảm giá",
        "invoice" => "Hóa đơn",
        "user" => "Phân quyền nhân viên",
        "khoadatcho" => "Khóa đặt chỗ của thu ngân",
        "chitieu" => "Chi tiêu",
        "changepassword" => "Đổi mật khẩu",
        "tiepkhach" => "Quản lý tiếp khách",
        /*"user" => array("title" => "Quản lý nhân viên", "content" => array(
                "user_3" => "Nhân viên phụ việc",
                "user_4" => "Nhân viên thu ngân",
                //"user_2" => "Nhân viên quản lý"
            )
        ),*/
        //"user" => "Nhân viên",
        "stats_ktv" => "Thống kê KTV",
        "stats" => array("title" => "Thống kê - Báo cáo", "content" => array(
                "stats_servicesstore" => "Thống kê tồn kho",
                
                "stats_fee" => "Thống kê chi phí",
                
                "stats_invoice" => "Thống kê hóa đơn",
                //"stats_invoice_month" => "Thống kê hóa đơn theo tháng",
                
                "stats_income" => "Thống kê lợi nhuận",
                //"stats_user" => "Thống kê thu nhập thợ",
                //"stats_customer" => "Thống kê hoạt động khách hàng"
            )
        )
    );
    $titlecomponents = @$permission_array[$components];
    $subdomain = explode(".", $_SERVER["SERVER_NAME"]);
?>