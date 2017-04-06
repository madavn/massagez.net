<?php
    defined("WEB_APP") or die("Please wait ... <META http-equiv=\"refresh\" content=\"0; url=".WEBSITE_URL."\" />");
    if (!empty($_POST))
    {
        $item["yesno"] = $_POST["yesno"];
        $item["password"] = "";
        $database->update("office", array("khoadatcho" => serialize($item)), "id=".$officeid);
        echo json_encode(array("error" => 1, "message" => "Cập nhật thành công", "redirect" => WEBSITE_URL."/admin.php?components=".$components));
        die();
    }
    $item = unserialize($officeitem["khoadatcho"]);
?>