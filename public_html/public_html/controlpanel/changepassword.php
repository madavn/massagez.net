<?php
    defined("WEB_APP") or die("Please wait ... <META http-equiv=\"refresh\" content=\"0; url=".WEBSITE_URL."\" />");
    if (!empty($_POST))
    {
        $password = md5(sha1($_POST["oldpassword"]));
        $newpassword = $_POST["newpassword"];
        if ($password!=$userlogin["password"])
        {
            $error = 1;
            $message = "Mật khẩu cũ không đúng.";
        }
        else if ($newpassword=="")
        {
            $error = 1;
            $message = "Vui lòng nhập mật khẩu mới.";
        }
        else
        {
            $database->update("user", array("password" => md5(sha1($newpassword))), "id=".$userlogin["id"]);
        }
        echo json_encode(array("error" => intval(@$error), "message" => @$message, "redirect" => WEBSITE_URL_CP."?components=".$components."&edit=1"));
        die();
    }
?>