<?php
    defined("WEB_APP") or die("Please wait ... <META http-equiv=\"refresh\" content=\"0; url=".WEBSITE_URL."\" />");
    class Servicesfield{
        protected static $list, $list_group;
        function __construct()
        {
            global $database;
            global $officeid;
            
            // tru?ng h?p d?c bi?t: hoàng gia l?y ktv t? dieuthuyen
            //$office = $officeid==20?17:$officeid;
            $office = $officeid;
            
            $result_set = $database->query("SELECT * FROM servicesfield WHERE office=".$office);
            while ($row = $database->fetch_array($result_set))
            {
                self::$list[$row["id"]] = $row;
                self::$list_group[$row["servicesid"]] = $row;
            }
        }
        public static function _full()
        {
            return self::$list;
        }
        public static function _full_group()
        {
            return self::$list_group;
        }
        public static function _servicesid($servicesid)
        {
            if (isset(self::$list[$servicesid]))
                return self::$list[$servicesid];
            return false;
        }
        function __destruct()
        {
            
        }
    }
    $class_Servicesfield = new Servicesfield();
?>