<?php
    defined("WEB_APP") or die("Please wait ... <META http-equiv=\"refresh\" content=\"0; url=".WEBSITE_URL."\" />");
    $strkeyword = Setting::show_setting("keyword");
    $strdescipt = Setting::show_setting("description");
    $strtitle = Setting::show_setting("titlewebsite");
    $itemshow = intval(Setting::show_setting("itemshow"));
?>