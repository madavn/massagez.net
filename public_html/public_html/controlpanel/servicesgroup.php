<?php
    defined("WEB_APP") or die("Please wait ... <META http-equiv=\"refresh\" content=\"0; url=".WEBSITE_URL."\" />");
    
    if (isset($_GET["edit"]))
    {
        $titleaction = "Thêm mới";
        $title = "";
        $thutu = 0;
        $noidung = "";
        $giathuong = 0;
        $thoigian = 0;
        if ($idsua>0)
        {
            $titleaction = "Sửa";
            $item = ServicesGroup::_item($idsua);
            if (!empty($item))
            {
                $title = $item["title"];
                $thutu = $item["thutu"];
                $noidung = $item["noidung"];
                $giathuong = $item["giathuong"]/1000;
                $thoigian = $item["thoigian"];
            }
        }
        if (!empty($_POST))
        {
            $title = htmlspecialchars($_POST["title"], ENT_QUOTES);
            $thutu = intval($_POST["thutu"]);
            $noidung = htmlspecialchars($_POST["noidung"], ENT_QUOTES);
            $giathuong = intval($_POST["giathuong"])*1000;
            $thoigian = intval($_POST["thoigian"]);
            $arr = array("title" => $title, "office" => $officeid, "thutu" => $thutu, "noidung" => $noidung, "giathuong" => $giathuong, "thoigian" => $thoigian);
            if ($idsua>0)
            {
                $database->update($components, $arr, "id=".$idsua." and office=".$officeid);
            }
            else
            {
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
        //ServicesGroup::_delete(join(",",$_POST["checkbox"]));
        die("<script>window.location='".WEBSITE_URL."/admin.php?components=".$components."';</script>");
    }
    else
        $list = ServicesGroup::_full();
?>