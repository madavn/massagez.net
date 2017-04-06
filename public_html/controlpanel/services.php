<?php
    defined("WEB_APP") or die("Please wait ... <META http-equiv=\"refresh\" content=\"0; url=".WEBSITE_URL."\" />");
    
    $listservicesgroup = ServicesGroup::_full();
    $listservicesfield = Servicesfield::_full_group();
    $listservicesfieldtext = Servicesfieldtext::_full();
    if (isset($_GET["edit"]))
    {
        $listgroup = ServicesGroup::_full();
        $titleaction = "Thêm mới";
        $title = "";
        $giathuong = 0;
        $thutu = 0;
        $groupid = 0;
        $grouptext = array();
        if ($idsua>0)
        {
            $titleaction = "Sửa";
            $item = Services::_item($idsua);
            if (!empty($item))
            {
                $title = $item["title"];
                $giathuong = $item["giathuong"];
                $thutu = $item["thutu"];
                $groupid = $item["groupid"];
                $grouptext = explode(",", $item["grouptext"]);
            }
        }
        if (!empty($_POST))
        {
            $title = strtoupper(htmlspecialchars($_POST["title"],ENT_QUOTES));
            $thutu = intval($_POST["thutu"]);
            $groupid = intval($_POST["groupid"]);
            $grouptexts = join(",", $_POST["grouptext"]);
            $giathuong = $listgroup[$groupid]["giathuong"];
            $arr = array("title" => $title, "thutu" => $thutu, "giathuong" => $giathuong, "groupid" => $groupid, "grouptext" => $grouptexts);
            if (isset($_POST["col"]))
            while(list($key, $value)=each($_POST["col"]))
            {
                $b["col_".$key] = $value;
            }
            if ($idsua>0)
            {
                $database->update($components, $arr, "id=".$idsua." and office=".$officeid);
                $database->update($components."field", $b, "servicesid=".$idsua." and office=".$officeid);
            }
            else
            {
                $arr["office"] = $officeid;
                $database->insert($components, $arr);
                if (($servicesid=$database->insert_id())==0)
                    $message = "Không thêm tên dịch vụ này được. Vui lòng kiểm tra và thử lại.";
                else
                {
                    $b["servicesid"] = $servicesid;
                    $b["office"] = $officeid;
                    $database->insert($components."field", $b);
                }
            }
            echo json_encode(array("error" => intval(@$error), "message" => @$message, "redirect" => WEBSITE_URL."/admin.php?components=".$components));
            die();
        }
        if ($idxoa>0)
        {
            $database->delete($components, "id=".$idxoa." and office=".$officeid);
            $database->delete($components."field", "servicesid=".$idxoa." and office=".$officeid);
            echo json_encode(array("error" => 0, "message" => ""));
            die();
        }
    }
    elseif (isset($_POST["checkbox"]))
    {
        //Services::_delete(join(",",$_POST["checkbox"]));
        die("<script>window.location='".WEBSITE_URL."/admin.php?components=".$components."';</script>");
    }
    else
    {
        $list = Services::_full_no_group();
    }
?>