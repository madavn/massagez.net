<?php
    defined("WEB_APP") or die("Please wait ... <META http-equiv=\"refresh\" content=\"0; url=".WEBSITE_URL."\" />");
    $item = array();
    if (!empty($_POST))
    {
        if ($gettype=="add")
        {
            $database->insert($components, array(
                "title" => $action,
                "bonus" => htmlspecialchars($_POST["bonus"], ENT_QUOTES),
                "joindate" => BAYGIO,
                "office" => $officeid
            ));
            $message = $database->last_query;
        }
        else if ($gettype=="use")
        {
            $database->update($components, array(
                "status" => 1,
                "lastupdate" => BAYGIO,
            ), "title='".htmlspecialchars($action, ENT_QUOTES)."' and office=".$officeid);
        }
        //$item = Voucher::_field("title", $action."' and status='0");
        $item = Voucher::_field("title", $action."' and status=0 and office='".$officeid);
        //$item = Voucher::_field("title", $action);
        if (!empty($item))
        {
            //$item["status"] = 0;
            $item["status_text"] = $voucher_status_array[$item["status"]];
        }
    }
    echo json_encode(array("error" => intval(@$error), "message" => @$message, "item" => $item));
    die();
?>