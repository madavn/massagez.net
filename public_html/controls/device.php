<?php
    defined("WEB_APP") or die("Please wait ... <META http-equiv=\"refresh\" content=\"0; url=".WEBSITE_URL."\" />");
    $device = array();
    preg_match_all("/iPad|android|iPhone|midp|mobile|cldc/i",$_SERVER['HTTP_USER_AGENT'],$device);
    //$device[0] = "A";
    if (0)//if (!empty($device[0]))
    {
        define("VIEWS",BASE_URL."/views_mobile/"); // views for mobile
        define("VIEWS_FOLDER",WEBSITE_URL."/views_mobile/");
        $ismobile = true;
    }
    else
    {
        define("VIEWS",BASE_URL."/views/"); // views for pc
        define("VIEWS_FOLDER",WEBSITE_URL."/views/");
        $ismobile = false;
    }
?>