<?php
    defined("WEB_APP") or die("Please wait ... <META http-equiv=\"refresh\" content=\"0; url=".WEBSITE_URL."\" />");
    //$listInvoice = Invoice::_full();
    //$listvoucher = Voucher::_full();
    //$listoffice = Office::_full();
    //$listuser = User::_full();
    if (isset($_GET["edit"]))
    {
        if ($idxoa>0)
        {
            $database->delete($components, "office=".$officeid." and id=".$idxoa);
            if ($database->affected_rows()>0)
                $database->delete($components."detail", "invoiceid=".$idxoa);
            echo json_encode(array("error" => 0, "messages" => ""));
            die();
        }
        $list = Invoice::_item($idsua);
        $components.= "detail";
    }
    else if (isset($_POST["checkbox"]))
    {
        //Invoice::_delete(join(",",$_POST["checkbox"]), $_SESSION["adminlogin"]["id"]);
        //die("<script>window.location='".WEBSITE_URL."/admin.php?components=".$components."';</script>");
    }
    else
    {
        if ($action=="")
        {
            $action = date("d-m-Y");
            //$start_day = HOMNAY-43200;
            //$end_day = HOMNAY+21600;
        }
        //else
        {
            $start_day = strtotime($action." 12:00:00")-86400;
            $end_day = strtotime($action." 06:00:00");
        }
        $list = Invoice::_range($officeid, $start_day, $end_day);
        $total = count($list);
        if (!empty($list))
        {
            if (isset($_GET["sort"]))
            {
                $sort_tach = explode("-", $_GET["sort"]);
                eval('usort($list, "sort_by_'.$sort_tach[0].'_'.$sort_tach[1].'");');
            }
            else
                usort($list, "sort_by_joindate_desc");
            //$list = array_slice($list,($pages-1)*$itemshow, $itemshow);
        }
    }
?>