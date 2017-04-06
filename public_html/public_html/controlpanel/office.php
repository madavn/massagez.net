<?php
    defined("WEB_APP") or die("Please wait ... <META http-equiv=\"refresh\" content=\"0; url=".WEBSITE_URL."\" />");
    
    if (isset($_GET["edit"]))
    {
        $titleaction = "Thêm mới";
        $title = "";
        $chairnum = "";
        $thutu = 1;
        $dienthoai = "";
        $diachi = "";
        if ($idsua>0)
        {
            $titleaction = "Sửa";
            $item = Office::_item($idsua);
            if (!empty($item))
            {
                $title = $item["title"];
                $thutu = $item["thutu"];
                $chairnum = $item["chairnum"];
                $dienthoai = $item["dienthoai"];
                $diachi = $item["diachi"];
            }
        }
        if (!empty($_POST))
        {
            $title = htmlspecialchars($_POST["title"],ENT_QUOTES);
            $thutu = intval(@$_POST["thutu"]);
            $chairnum = intval($_POST["chairnum"]);
            $dienthoai = htmlspecialchars($_POST["dienthoai"],ENT_QUOTES);
            $diachi = htmlspecialchars($_POST["diachi"],ENT_QUOTES);
            $arr = array("title" => $title, "chairnum" => $chairnum, "thutu" => $thutu, "dienthoai" => $dienthoai, "diachi" => $diachi);
            if ($idsua>0)
            {
                $database->update($components, $arr, "id=".$idsua." and userid=".$userlogin["id"]);
                $error = !$database->affected_rows();
                $message = $database->last_query;
            }
            else
            {
                $arr["userid"] = $userlogin["id"];
                $arr["joindate"] = BAYGIO;
                $database->insert($components, $arr);
                if (($lastofficeid=$database->insert_id())>0)
                {
                    
                    $database->update("user", array("office" => $lastofficeid), "id=".$userlogin["id"]);
                }
                else
                    $message = "Không thêm tên văn phòng này được. Vui lòng kiểm tra và thử lại.";
            }
            echo json_encode(array("error" => intval(@$error), "messages" => @$message, "redirect" => WEBSITE_URL."/admin.php?components=".$components));
            die();
        }
        if ($idxoa>0)
        {
            //$database->delete($components, "id=".$idxoa." and userid=".$userlogin["id"]);
            echo json_encode(array("error" => 0, "messages" => ""));
            die();
        }
    }
    elseif (isset($_POST["checkbox"]))
    {
        //Office::_delete(join(",",$_POST["checkbox"]));
        die("<script>window.location='".WEBSITE_URL."/admin.php?components=".$components."';</script>");
    }
    else
        //$list = Office::_full();
        $list = array(Office::_sudomain($subdomain[0]));
?>