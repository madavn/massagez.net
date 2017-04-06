<?php
    defined("WEB_APP") or die("Please wait ... <META http-equiv=\"refresh\" content=\"0; url=".WEBSITE_URL."\" />");
    $list = array();
    if (!empty($_POST))
    {
        $result = $database->query("select c.*, o.title as office_title from customeraction c left join office o on c.office=o.id where c.office in (17,20)");
        while($row=$database->fetch_array($result))
        {
            $list[] = $row;
        }
    }
    echo json_encode(array("list" => $list, ));
    die();
?>