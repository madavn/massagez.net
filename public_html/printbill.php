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
    $r = $database->query("select ca.services_ext, ca.customerid, ca.joindate, ca.verify_remind, s.title as ktv, sg.giathuong as giave_giathuong, sg.noidung as giave_noidung, sg.thoigian as giave_thoigian, r.title as tenphong, o.congphut, v.title as voucher_title, v.bonus as voucher_bonus from customeraction ca inner join services s on ca.services=s.id inner join servicesgroup sg on ca.servicesgroup=sg.id inner join room r on ca.room=r.id inner join office o on ca.office=o.id left join voucher v on ca.method_payment=v.id where ca.status=1 and ca.office=".$officeid." and ca.id=".$idsua);
    while($row=$database->fetch_array($r))
        $item = $row;
    if (empty($item))
        die("Khong co thong tin");
    $services_ext = Services::_item_ext($item["services_ext"]);
?>
<!DOCTYPE html>
<html lang="vi-VN">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    
</head>
<body>
    <div style="text-align: center;position: absolute;top: 0px;right: 10px;">Số HĐ: <span style="font-weight: bole;"><?=$idsua." - ".$item["ktv"];?></span></div>
    <h1 style="text-align: center;margin-bottom: 0;font-size:15px;"><?=$officeitem["title"];?></h1>
    <h1 style="text-align: center;margin: 0;font-size:15px;">Cam Kết Chất Lượng Phục Vụ</h1>
    <div>Giá vé: <?=$item["customerid"]>0 || $item["verify_remind"]>0?($item["customerid"]>0?number_format($item["customerid"]):"Miễn phí"):number_format($item["giave_giathuong"]);?> - <?=$item["giave_noidung"];?></div>
<?php
    if ($item["voucher_title"]!="")
    {
?>
    <div>Code: <?=$item["voucher_title"].($item["verify_remind"]>0?"":" - Giảm giá: ".number_format($item["voucher_bonus"]));?></div>
<?php
    }
?>
    <div><span><?=$item["ktv"];?></span>&nbsp;&nbsp;&nbsp;Phòng:.............</div>
    <div>Ngày: <?=date("d/m/Y", $item["joindate"]);?></div>
    <div>Thời gian: từ <?=date("H:i", $item["joindate"]+($item["congphut"]*60));?> đến <?=date("H:i", $item["joindate"]+($item["congphut"]*60)+($item["giave_thoigian"]*60));?></div>
    <div style="padding: 10px 0;">Tiền tip KTV: <?=$item["ktv"];?>: <input style="border: 1px solid #000;height: 40px;" type="text" size="16" /></div>
<?php
    if (!empty($services_ext))
    foreach ($services_ext as $key => $row)
    {
?>
    <div style="padding: 10px 0;">Tiền tip KTV: <?=$row["title"];?>: <input style="border: 1px solid #000;height: 40px;" type="text" size="16" /></div>
<?php
    }
?>
    <div>Đánh giá của khách:</div>
    <div style="padding: 10px 0;"><span style="">Tệ <span style="border: 1px solid #000;"><input type="checkbox" /></span></span> <span style="">Trung bình <span style="border: 1px solid #000;"><input type="checkbox" /></span></span> <span style="">Tốt <span style="border: 1px solid #000;"><input type="checkbox" /></span></span></div>
    <div style="text-align: center;font-size: 22px;font-weight: bold;">Xin cám ơn</div>
    <div><?=$officeitem["title"];?> mong nhận được sự góp ý của Quý Khách</div>
    <div style="font-weight: bold;">Hotline: <?=$officeitem["dienthoai"];?></div>
<script>window.print();window.close();</script>
</body>
</html>