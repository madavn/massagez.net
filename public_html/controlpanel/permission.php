<?php
    defined("WEB_APP") or die("Please wait ... <META http-equiv=\"refresh\" content=\"0; url=".WEBSITE_URL."\" />");
    
    if (!isset($_SESSION["adminlogin"]))
    {
        if (!empty($_POST))
        {
            if($userlogin=User::login($_POST["username"], $_POST["password"], $subdomain[0]))
            {
                $_SESSION["adminlogin"] = $userlogin;
            }
            else
            {
                $error = 1;
                $message = "Đăng nhập sai. Vui lòng kiểm tra lại thông tin.";
            }
            echo json_encode(array("error" => intval(@$error), "message" => @$message, "redirect" => ""));
            die();
        }
        require_once VIEWS."login.php";
        die();
    }
    if (isset($_GET["thoat"]))
    {
        unset($_SESSION["adminlogin"]);
        echo "<script>window.location='./admin.php';</script>";
    }
    $userlogin = User::_item($_SESSION["adminlogin"]["id"]);
    $officeid = $userlogin["office"];
    $officeitem = Office::_item($officeid, true);
    // phân quyền
    /*if (!in_array($userlogin["role"], array(1,2)) && ($userlogin["role"]==4 && !in_array($components, array("ajax_get_remind", "customeraction", "customernew", "invoice", "ajax_office", "ajax_search_customer"))))
    {
        $components = "error";
        if ($userlogin["role"]==4)
        {
            require_once VIEWS."login.php";
            exit;
        }
    }*/
    /*if (!empty($userlogin))
    {
        if ($userlogin["role"]==1)
        {
            $officeitem = Office::_item(0, true);
            $officeid = $officeitem["id"];
        }
        else
            $officeid = $userlogin["office"];
    }
    else
        $officeid = 0;*/
?>