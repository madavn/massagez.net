<?php
    defined("WEB_APP") or die("Please wait ... <META http-equiv=\"refresh\" content=\"0; url=".WEBSITE_URL."\" />");
    
    $start = mktime(0, 0, 0, 1, 1, date("Y", BAYGIO));
    $start_day = date("H", BAYGIO)<12?HOMNAY-43200:HOMNAY+43200;
    $tongve = array("day" => 0, "month" => 0, "year" => 0);
    $tongcode = array("day" => 0, "month" => 0, "year" => 0);
    $tongtips = array("day" => 0, "month" => 0, "year" => 0);
    $truphantram = array("day" => 0, "month" => 0, "year" => 0);
    $tongdiennuoc = array("day" => 0, "month" => 0, "year" => 0);
    $tongchitieu = array("day" => 0, "month" => 0, "year" => 0);
    $stats_ktv = array();
    $stats = Invoice::_range($officeid, $start, BAYGIO);
    $listchitieu = Chitieu::_range($officeid, $start, BAYGIO);
    
    if (!empty($stats))
    foreach ($stats as $key => $row)
    {
        
        if ($row["joindate"]>=$start_day)
        {
            $stats_ktv["day"][$row["services"]] = $officeitem["diennuoc"];
            if ($row["services_ext"]!="")
            {
                $services_ext = unserialize($row["services_ext"]);
                foreach ($services_ext as $a => $b)
                    $stats_ktv["day"][$a] = $officeitem["diennuoc"];
            }
            $tongve["day"]+= $row["total"];
            $tongcode["day"]+= $row["voucher_bonus"];
            $tongtips["day"]+= $row["khachtra"];
        }
        
        if (date("Ym", BAYGIO)==date("Ym", $row["joindate"]))
        {
            $stats_ktv["month"][date("Ymd", $row["joindate"])][$row["services"]] = $officeitem["diennuoc"];
            if ($row["services_ext"]!="")
            {
                $services_ext = unserialize($row["services_ext"]);
                foreach ($services_ext as $a => $b)
                    $stats_ktv["month"][date("Ymd", $row["joindate"])] = $officeitem["diennuoc"];
            }
            $tongve["month"]+= $row["total"];
            $tongcode["month"]+= $row["voucher_bonus"];
            $tongtips["month"]+= $row["khachtra"];
        }
        
        if (date("Y", BAYGIO)==date("Y", $row["joindate"]))
        {
            $stats_ktv["year"][date("Ymd", $row["joindate"])][$row["services"]] = $officeitem["diennuoc"];
            if ($row["services_ext"]!="")
            {
                $services_ext = unserialize($row["services_ext"]);
                foreach ($services_ext as $a => $b)
                    $stats_ktv["year"][date("Ymd", $row["joindate"])] = $officeitem["diennuoc"];
            }
            $tongve["year"]+= $row["total"];
            $tongcode["year"]+= $row["voucher_bonus"];
            $tongtips["year"]+= $row["khachtra"];
        }
    }
    if (!empty($listchitieu))
    foreach ($listchitieu as $key => $row)
    {
        if ($row["joindate"]>=$start_day)
        {
            $tongchitieu["day"]+= $row["money"];
        }
        
        if (date("Ym", BAYGIO)==date("Ym", $row["joindate"]))
        {
            $tongchitieu["month"]+= $row["money"];
            
        }
        
        if (date("Y", BAYGIO)==date("Y", $row["joindate"]))
        {
            $tongchitieu["year"]+= $row["money"];
        }
    }
    //print_r (array_map("array_sum", $stats_ktv["month"]));die();
    
    $tongve["day"]+= $tongcode["day"];
    $truphantram["day"] = $tongtips["day"] * ($officeitem["truphantram"] / 100);
    $tongdiennuoc["day"] = @array_sum(@$stats_ktv["day"]);
    
    $tongve["month"]+= $tongcode["month"];
    $truphantram["month"] = $tongtips["month"] * ($officeitem["truphantram"] / 100);
    $tongdiennuoc["month"] = @array_sum(@array_map("array_sum", @$stats_ktv["month"]));
    
    $tongve["year"]+= $tongcode["year"];
    $truphantram["year"] = $tongtips["year"] * ($officeitem["truphantram"] / 100);
    $tongdiennuoc["year"] = @array_sum(@array_map("array_sum", @$stats_ktv["year"]));
?>