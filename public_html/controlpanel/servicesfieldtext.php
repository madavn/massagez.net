<?php
    defined("WEB_APP") or die("Please wait ... <META http-equiv=\"refresh\" content=\"0; url=".WEBSITE_URL."\" />");
    
    if (isset($_GET["edit"]))
    {
        $titleaction = "Thêm mới";
        $title = "";
        $noidung = "";
        if ($idsua>0)
        {
            $titleaction = "Sửa";
            $item = Servicesfieldtext::_item($idsua);
            if (!empty($item))
            {
                $title = $item["title"];
                $noidung = $item["noidung"];
            }
        }
        if (!empty($_POST))
        {
            $title = htmlspecialchars($_POST["title"], ENT_QUOTES);
            $noidung = htmlspecialchars($_POST["noidung"], ENT_QUOTES);
            $arr = array("title" => $title, "noidung" => $noidung);
            if ($idsua>0)
            {
                $database->update($components, $arr, "id=".$idsua." and office=".$officeid);
            }
            else
            {
                $arr["office"] = $officeid;
                $database->insert($components, $arr);
                if (($servicesid=$database->insert_id())==0)
                    $message = "Không thêm được. Vui lòng kiểm tra và thử lại.";
                else
                {
                    $database->query("ALTER TABLE servicesfield ADD col_".$servicesid." text NOT NULL");
                }
            }
            echo json_encode(array("error" => intval(@$error), "messages" => @$message, "redirect" => WEBSITE_URL."/admin.php?components=".$components));
            die();
        }
        if ($idxoa>0)
        {
            $database->delete($components, "id=".$idxoa." and office=".$officeid);
            $database->query("ALTER TABLE servicesfield DROP col_".$idxoa);
            echo json_encode(array("error" => 0, "messages" => ""));
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
        $list = Servicesfieldtext::_full();
    }
?>