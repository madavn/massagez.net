<?php
    defined("WEB_APP") or die("Please wait ... <META http-equiv=\"refresh\" content=\"0; url=".WEBSITE_URL."\" />");
    if (isset($_GET["thoat"]))
    {
        session_destroy();
        die("<script>window.location='".WEBSITE_URL."';</script>");
    }
    if (!isset($_SESSION[WEB_APP]))
    {
        //if (isset($_POST["btnlogin"]))
        if (!empty($_POST))
        {
            if($userlogin=User::login($_POST["username"], $_POST["password"], $subdomain[0]))
            {
                $_SESSION[WEB_APP] = $userlogin;
                if (in_array($userlogin["role"], array(1)))
                {
                    $_SESSION["adminlogin"] = $userlogin;
                }
                echo json_encode(array("error" => 0, "message" => "", "redirect" => WEBSITE_URL));
                die();
            }
            else
            {
                echo json_encode(array("error" => 1, "message" => "Tài khoản này không có trong hệ thống."));
                die();
            }
        }
        require_once VIEWS."login.php";
        exit;
    }
    $userlogin = User::_item($_SESSION[WEB_APP]["id"]);
    if ($userlogin["office"]<=0)
    {
        echo "Chưa có văn phòng";
        die();
    }
    $officeid = $userlogin["office"];
    $officeitem = Office::_item($officeid, true);
?>