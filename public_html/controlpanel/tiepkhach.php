<?php
    defined("WEB_APP") or die("Please wait ... <META http-equiv=\"refresh\" content=\"0; url=".WEBSITE_URL."\" />");
    if (!empty($_POST))
    {
        $title = htmlspecialchars($_POST["title"], ENT_QUOTES);
        $database->insert($components, array(
            "title" => $title,
            "joindate" => BAYGIO,
            "office" => $officeid
        ));
        echo json_encode(array("error" => 0, "messages" => "", "redirect" => ""));
        die();
    }
    else if ($idxoa>0)
    {
        $database->delete($components, "office=".$officeid." and id=".$idxoa);
        echo json_encode(array("error" => 0, "messages" => "", "redirect" => ""));
        die();
    }
    $list = array();
    $r = $database->query("select * from ".$components." where office=".$officeid);
    while ($row=$database->fetch_array($r))
        $list[$row["id"]] = $row;
?>