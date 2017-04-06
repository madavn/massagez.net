<?php
    defined("WEB_APP") or die("Please wait ... <META http-equiv=\"refresh\" content=\"0; url=".WEBSITE_URL."\" />");
    
    $list = Room::_full();
    echo json_encode(array("error" => 0, "message" => "", "list" => $list));
    die();
?>