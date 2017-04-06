<?php
    defined("WEB_APP") or die("Please wait ... <META http-equiv=\"refresh\" content=\"0; url=".WEBSITE_URL."\" />");
    if (isset($_GET["edit"]))
    {
        $titleaction = "Thêm mới";
        $username = "";
        $fullname = "";
        $role = 0;
        if ($idsua>0)
        {
            $titleaction = "Sửa";
            $item = User::_item($idsua);
            if (!empty($item))
            {
                $username = $item["username"];
                $fullname = $item["fullname"];
                $role = $item["role"];
            }
        }
        if (!empty($_POST))
        {
            $username = htmlspecialchars($_POST["username"], ENT_QUOTES);
            $fullname = htmlspecialchars($_POST["fullname"], ENT_QUOTES);
            $password = $_POST["password"];
            $role = intval($_POST["role"]);
            $arr = array(
                "role" => $role,
                "username" => $username,
                "fullname" => $fullname,
                "subdomain" => $userlogin["subdomain"]
            );
            if ($idsua>0)
            {
                $database->update($components, $arr, "id=".$idsua." and office=".$officeid);
            }
            else
            {
                $arr["password"] = md5(sha1($password));
                $arr["office"] = $officeid;
                $arr["joindate"] = BAYGIO;
                $database->insert($components, $arr);
                if ($database->insert_id()==0)
                    $message = "Không thêm được. Vui lòng kiểm tra và thử lại.";
            }
            echo json_encode(array("error" => intval(@$error), "messages" => @$message, "redirect" => WEBSITE_URL."/admin.php?components=".$components));
            die();
        }
        if ($idxoa>0)
        {
            $database->delete($components, "id=".$idxoa." and office=".$officeid);
            echo json_encode(array("error" => 0, "messages" => ""));
            die();
        }
    }
    elseif (isset($_POST["checkbox"]))
    {
        //Office::_delete(join(",",$_POST["checkbox"]));
        die("<script>window.location='".WEBSITE_URL."/admin.php?components=".$components."';</script>");
    }
    $listrole = Role::_full();
    $list = User::_full($userlogin["office"], $userlogin["id"]);
?>