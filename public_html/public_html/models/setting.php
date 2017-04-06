<?php
    defined("WEB_APP") or die("Please wait ... <META http-equiv=\"refresh\" content=\"0; url=".WEBSITE_URL."\" />");
    class Setting{
        protected static $setting_full;
        function __construct()
        {
            global $database;
            $result_set = $database->query("SELECT * FROM setting");
            while ($row = $database->fetch_array($result_set))
            {
                self::$setting_full[$row["tieude"]] = $row["noidung"];
            }
        }
        public static function show_setting($tieude="")
        {
            if (isset(self::$setting_full[$tieude]))
                return self::$setting_full[$tieude];
            return self::$setting_full;
        }
        function __destruct()
        {
            
        }
    }
    $class_Setting = new Setting();
?>