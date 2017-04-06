<?php
    defined("WEB_APP") or die("Please wait ... <META http-equiv=\"refresh\" content=\"0; url=".WEBSITE_URL."\" />");
    $a = array();
    $listservicesgroup = ServicesGroup::_full();
    $list = Services::_full_no_group();
    switch ($action)
    {
        case "inout":
            if ($gettype=="")
                $gettype = date("m-Y", BAYGIO);
            $start = strtotime("01-".$gettype." 00:00:00");
            $songay = cal_days_in_month(CAL_GREGORIAN, date("m", $start), date("Y", $start));
            $end = strtotime($songay."-".$gettype." 23:59:59");
            $r = $database->query("select * from services_inout where servicesid=".$idsua." and office=".$officeid." and (joindate>=".$start." and joindate<=".$end.")");
            while ($row=$database->fetch_array($r))
            {
                $a[date("Ymd", $row["joindate"])][$row["vaora"]] = $row;
            }
            @ksort($a);
            break;
        case "thunhap":
            if ($gettype=="")
                $gettype = date("m-Y", BAYGIO);
            $start = strtotime("01-".$gettype." 00:00:00");
            $songay = cal_days_in_month(CAL_GREGORIAN, date("m", $start), date("Y", $start));
            $end = strtotime($songay."-".$gettype." 23:59:59");
            $r = $database->query("select * from invoice where services=".$idsua." and office=".$officeid." and (joindate>=".$start." and joindate<=".$end.")");
            while ($row=$database->fetch_array($r))
            {
                $a[date("Ymd", $row["joindate"])][] = $row;
            }
            @ksort($a);
            break;
    }
    $components.= $action!=""?"_".$action:"";
?>