<?php
    defined("WEB_APP") or die("Please wait ... <META http-equiv=\"refresh\" content=\"0; url=".WEBSITE_URL."\" />");
    
    if (isset($_GET["edit"]))
    {
        $listfee = Fees::_full();
        $titleaction = "Thêm mới";
        $feeid = 0;
        $thanhtien = "";
        $ghichu = "";
        if ($idsua>0)
        {
            $titleaction = "Sửa";
            $item = FeeStore::_item($idsua);
            if (!empty($item))
            {
                $feeid = $item["feeid"];
                $thanhtien = $item["thanhtien"];
                $ghichu = $item["ghichu"];
            }
        }
        if (!empty($_POST))
        {
            $title = htmlspecialchars($_POST["feetitle"], ENT_QUOTES);
            if ($title!="")
            {
                $database->insert("fees", array("title" => $title, "office" => $officeid));
                $feeid = $database->insert_id();
            }
            else
                $feeid = intval($_POST["feeid"]);
            $thanhtien = floatval($_POST["thanhtien"]);
            $ghichu = htmlspecialchars($_POST["ghichu"], ENT_QUOTES);
            $arr = array("feeid" => $feeid, "thanhtien" => $thanhtien, "ghichu" => $ghichu);
            if ($idsua>0)
            {
                $database->update($components, $arr, "id=".$idsua);
            }
            else
            {
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
        FeeStore::_delete(join(",",$_POST["checkbox"]));
        die("<script>window.location='".WEBSITE_URL."/admin.php?components=".$components."';</script>");
    }
    else
    {
        $list = FeeStore::_full();
    }
?>