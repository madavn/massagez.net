<?php
    defined("WEB_APP") or die("Please wait ... <META http-equiv=\"refresh\" content=\"0; url=".WEBSITE_URL."\" />");
    if (!empty($_POST))
    {
        $khoadatcho = unserialize($officeitem["khoadatcho"]);
        if ($_POST["password"]==@$khoadatcho["password"])
        {
            $database->update("user", array("khoadatcho" => @$khoadatcho["password"]), "id=".$userlogin["id"]);
        }
        else
        {
            $error = 1;
            $message = "Mật khẩu không đúng";
        }
    }
    echo json_encode(array("error" => intval(@$error), "message" => @$message));
    die();
?>