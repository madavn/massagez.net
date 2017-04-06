<?php
    date_default_timezone_set("Asia/Bangkok");
    define("WEBSITE_URL", "http://".$_SERVER["SERVER_NAME"]);
    define("WEBSITE_URL_CP", WEBSITE_URL."/client.php");
    define("BASE_URL",getcwd());
    define("INCLUDES",BASE_URL."/includes/");
    define("CONTROLS",BASE_URL."/controls/");
    define("MODELS",BASE_URL."/models/");
    define("BAYGIO",time());
    define("HOMNAY",mktime(0,0,0,date("m",BAYGIO),date("d",BAYGIO),date("Y",BAYGIO)));
    define("MONSUN",date("w",BAYGIO));
    define('WEB_APP', base64_encode(WEBSITE_URL));
    
    require_once INCLUDES."init.php";
    $office = office::_sudomain($subdomain[0]);
    $officeid = $office["id"]; 
    $officeitem = Office::_item($officeid);
    
    require_once CONTROLS."head.php";
    require_once CONTROLS."device.php";
    if (!file_exists(CONTROLS.$components.".php"))
        $components = "client";
    require_once CONTROLS.$components.".php";
    
    require_once VIEWS."head.php";
    require_once VIEWS."header.php";
    require_once VIEWS.$components.".php";
    require_once VIEWS."footer.php";
?>