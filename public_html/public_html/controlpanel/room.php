<?php
    defined("WEB_APP") or die("Please wait ... <META http-equiv=\"refresh\" content=\"0; url=".WEBSITE_URL."\" />");
    
    if (isset($_GET["edit"]))
    {
        $titleaction = "Thêm mới";
        $title = "";
        $thutu = 0;
        $servicesgroup = "";
        if ($idsua>0)
        {
            $titleaction = "Sửa";
            $item = Room::_item($idsua);
            if (!empty($item))
            {
                $title = $item["title"];
                $thutu = $item["thutu"];
                $servicesgroup = $item["servicesgroup"];
            }
        }
        if (!empty($_POST))
        {
            $title = htmlspecialchars($_POST["title"], ENT_QUOTES);
            $thutu = intval(@$_POST["thutu"]);
            $servicesgroup = join(",", $_POST["servicesgroup"]);
            $arr = array("title" => $title, "thutu" => $thutu, "servicesgroup" => $servicesgroup);
            if ($idsua>0)
            {
                $database->update($components, $arr, "id=".$idsua." and office=".$officeid);
            }
            else
            {
                $arr["office"] = $officeid;
                $database->insert($components, $arr);
                if ($database->insert_id()==0)
                    $message = "Không thêm phòng này được. Vui lòng kiểm tra và thử lại.";
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
    $listservicesgroup = ServicesGroup::_full();
    $list = Room::_full();
?>