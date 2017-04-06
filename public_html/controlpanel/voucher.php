<?php
    defined("WEB_APP") or die("Please wait ... <META http-equiv=\"refresh\" content=\"0; url=".WEBSITE_URL."\" />");
    if ($action=="")
    {
        $start_day = HOMNAY;
        $end_day = HOMNAY+86400;
    }
    else
    {
        $start_day = strtotime($action." 00:00:00");
        $end_day = strtotime($action." 23:59:59");
    }
    $list = Voucher::_range($officeid, $start_day, $end_day);
    $total = count($list);
    if (!empty($list))
    {
        usort($list, "sort_by_joindate_asc");
        //$list = array_slice($list,($pages-1)*$itemshow, $itemshow);
    }
?>