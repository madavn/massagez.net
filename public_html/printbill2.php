<?php
    date_default_timezone_set("Asia/Bangkok");
    define("WEBSITE_URL", "http://".$_SERVER["SERVER_NAME"]);
    define("WEBSITE_URL_CP", WEBSITE_URL."/index.php");
    define("BASE_URL",getcwd());
    define("INCLUDES",BASE_URL."/includes/");
    define("CONTROLS",BASE_URL."/controls/");
    define("MODELS",BASE_URL."/models/");
    define("IMG",WEBSITE_URL."/views/img/");
    define("BAYGIO",time());
    define("HOMNAY",mktime(0,0,0,date("m",BAYGIO),date("d",BAYGIO),date("Y",BAYGIO)));
    define("MONSUN",date("w",BAYGIO));
    define('WEB_APP','1');
    
    require_once INCLUDES."init.php";
    
    $office = office::_sudomain($subdomain[0]);
    $officeid = $office["id"]; 
    $officeitem = Office::_item($officeid);
    
    $item = array();
    $r = $database->query("select ca.services_ext, ca.customerid, ca.joindate, ca.khachtra, ca.khachtra_ext, ca.total, ca.giamgia, s.title as ktv, sg.giathuong as giave_giathuong, sg.noidung as giave_noidung, sg.thoigian as giave_thoigian, r.title as tenphong, o.congphut, v.title as voucher_title, v.bonus as voucher_bonus from invoice ca inner join services s on ca.services=s.id inner join servicesgroup sg on ca.servicesgroup=sg.id inner join room r on ca.room=r.id inner join office o on ca.office=o.id left join voucher v on ca.method_payment=v.id where ca.office=".$officeid." and ca.id=".$idsua);
    while($row=$database->fetch_array($r))
        $item = $row;
    if (empty($item))
        die("Khong co thong tin");
    $listservices = Services::_full_no_group();
    //$services_ext = Services::_item_ext($item["services_ext"]);
?>
<!DOCTYPE html>
<html lang="vi-VN">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    
</head>
<body>
    <div style="text-align: center;position: absolute;top: 0px;right: 10px;">Số HĐ: <span style="font-weight: bole;"><?=$idsua." - ".$item["ktv"];?></span></div>
    <h3 style="text-align: center;margin-bottom: 0;"><?=$officeitem["title"];?></h3>
    <h3 style="text-align: center;margin: 0;">Cam kết chất lượng</h3>
    <div>Giá vé: <?=$item["customerid"]>0 || $item["giamgia"]>0?($item["customerid"]>0?number_format($item["customerid"]):"Miễn phí"):number_format($item["giave_giathuong"]);?> - <?=$item["giave_noidung"];?></div>
<?php
    if ($item["voucher_title"]!="")
    {
?>
    <div>Code: <?=$item["voucher_title"].($item["giamgia"]>0?"":" - Giảm giá: ".number_format($item["voucher_bonus"]));?></div>
<?php
    }
?>
    <div><span><?=$item["ktv"];?></span>&nbsp;&nbsp;&nbsp;Phòng:.............</div>
    <div>Ngày: <?=date("d/m/Y", $item["joindate"]);?></div>
    <div>Thời gian: <?=date("H:i, d/m/Y", $item["joindate"]);?></div>
    <div>Tiền khách thưởng: <?=$item["ktv"].": ".number_format($item["khachtra"]);?></div>
<?php
    if ($item["khachtra_ext"]!="")
    {
        $services_ext = unserialize($item["khachtra_ext"]);
        foreach ($services_ext as $key => $row)
        {
?>
    <div>Tiền khách thưởng: <?=$listservices[$key]["title"].": ".number_format($row);?></div>
<?php
        }
    }
?>    
    <div>Tổng cộng: <span style="font-weight: bold;"><?=number_format($item["total"]);?></span></div>
    <div><?=$officeitem["title"];?> mong nhận được sự góp ý của Quý Khách</div>
<script>window.print();window.close();</script>
</body>
</html>