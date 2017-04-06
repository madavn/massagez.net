<?php
    ini_set("display_error", "on");
    define("WEBSITE_URL","http://".$_SERVER["SERVER_NAME"]);
    define("WEBSITE_URL_CP", WEBSITE_URL."/index.php");
    define("BASE_URL", getcwd());
    define("INCLUDES", BASE_URL."/includes/");
    define("CONTROLS", BASE_URL."/controls/");
    define("MODELS", BASE_URL."/models/");
    define("VIEWS_SYSTEM_FOLDER", WEBSITE_URL."/views/");
    define("BAYGIO", time());
    define("HOMNAY", mktime(0,0,0,date("m",BAYGIO),date("d",BAYGIO),date("Y",BAYGIO)));
    define("MONSUN", date("w",BAYGIO));
    define('WEB_APP', base64_encode(WEBSITE_URL));
    
    require_once INCLUDES."init.php";
    
    global $database;
    $hinhanh = array();
    $result = $database->query("select ".$action." as hinhanh from ".$gettype." where id=".$idsua);
    while($row=$database->fetch_array($result))
        $hinhanh = explode(",", $row["hinhanh"]);
    
    if (empty($hinhanh[0]))
    {
        list($width, $height, $contenttype[1], $attr) = getimagesize(VIEWS_SYSTEM_FOLDER."img/default-user.png");
        if ($rewrite=="user")
            $pic = "default-user.png";
        else
            $pic = "default-user.png";
        $hinhanh[1] = base64_encode(file_get_contents(VIEWS_SYSTEM_FOLDER."img/".$pic));
    }
    else
    {
        preg_match("/data:(.*?);base64/i", $hinhanh[0], $contenttype);
    }
    header("Content-type: ".$contenttype[1]);
    echo base64_decode($hinhanh[1]);
    die();
?>