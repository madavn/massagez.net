<?php
    defined("WEB_APP") or die("Please wait ... <META http-equiv=\"refresh\" content=\"0; url=".WEBSITE_URL."\" />");
    $a = array();
    $stats_ktv = array();
    $tongchitieu = array();
    $tongve = array();
    $tongcode = array();    
    if ($action=="")
        $action = date("m-Y", BAYGIO);
    $start = strtotime("01-".$action." 00:00:00");
    $songay = cal_days_in_month(CAL_GREGORIAN, date("m", $start), date("Y", $start));
    $end = strtotime($songay."-".$action." 23:59:59");
    $list = Invoice::_range($officeid, $start, $end);
    $listchitieu = Chitieu::_range($officeid, $start, $end);
    $servicesgroup = ServicesGroup::_full();
    if (!empty($list))
    foreach ($list as $key => $row)
    {
        $a[date("Ymd", $row["joindate"])][] = array(
            "day" => date("d-m-Y", $row["joindate"]),
            "tienve" => $row["total"],
            "code" => $row["voucher_bonus"],
            "tips" => $row["khachtra"],
        );
        $tongve[date("Ymd", $row["joindate"])][$row["servicesgroup"]][] = 1;
        $tongcode[date("Ymd", $row["joindate"])][$row["method_payment"]] = 1;
        $stats_ktv[date("Ymd", $row["joindate"])][$row["services"]] = $officeitem["diennuoc"];
        if ($row["khachtra_ext"]!="")
        {
            $services_ext = unserialize($row["khachtra_ext"]);
            foreach ($services_ext as $a => $b)
                $stats_ktv[date("Ymd", $row["joindate"])][$a] = $officeitem["diennuoc"];
        }
    }
    if (!empty($listchitieu))
    foreach ($listchitieu as $key => $row)
    {
        $tongchitieu[date("Ymd", $row["joindate"])][] = $row["money"];
    }
    $list = $a;
?>