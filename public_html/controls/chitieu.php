<?php
    defined("WEB_APP") or die("Please wait ... <META http-equiv=\"refresh\" content=\"0; url=".WEBSITE_URL."\" />");
    $arr = array();
    if (!empty($_POST))
    {
        $arr = array(
            "title" => htmlspecialchars($_POST["title"], ENT_QUOTES),
            "money" => intval($_POST["money"]) * 1000,
            "ghichu" => htmlspecialchars($_POST["ghichu"], ENT_QUOTES),
            "joindate" => BAYGIO,
            "userid" => $userlogin["id"],
            "office" => $officeid
        );
        $database->insert($components, $arr);
    }
    $arr["joindate_text"] = ret_thoigian(BAYGIO, "H:i, d/m/Y");
    echo json_encode(array("error" => intval(@$error), "message" => @$message, "list" => $arr));
    die();
?>