<?php
    defined("WEB_APP") or die("Please wait ... <META http-equiv=\"refresh\" content=\"0; url=".WEBSITE_URL."\" />");
    if (!empty($_POST))
    {
        if (isset($_POST["checkin"]))
        {
            $database->update($components, array("checkin" => !($_POST["checkout"] & 1)), "id=".intval($_POST["checkin"])." and office=".$officeid);
            $database->insert($components."_inout", array(
                "servicesid" => intval($_POST["checkin"]),
                "vaora" => !($_POST["checkout"] & 1),
                "joindate" => BAYGIO,
                "userid" => $userlogin["id"],
                "office" => $officeid
            ));
            $message = $database->last_query;
        }
        else if (isset($_POST["clear"]))
        {
            $database->update($components, array("checkin" => 0), "office=".$officeid);
            $database->query("insert into ".$components."_inout (servicesid, vaora, joindate, userid, office) (select id, '0', '".BAYGIO."', '".$userlogin["id"]."', '".$officeid."' from services where office=".$officeid.")");
            $message = $database->last_query;
        }
    }
    $list = Services::_full_no_group($idsua);
    echo json_encode(array("error" => 0, "message" => @$message, "list" => $list));
    die();
?>