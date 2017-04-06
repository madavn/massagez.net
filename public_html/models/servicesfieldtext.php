<?php
    defined("WEB_APP") or die("Please wait ... <META http-equiv=\"refresh\" content=\"0; url=".WEBSITE_URL."\" />");
    class Servicesfieldtext{
        protected static $list, $list_no_group;
        function __construct()
        {
            global $database;
            global $officeid;
            
            // tru?ng h?p d?c bi?t: hoàng gia l?y ktv t? dieuthuyen
            //$office = $officeid==20?17:$officeid;
            $office = $officeid;
            
            $result_set = $database->query("SELECT * FROM servicesfieldtext WHERE 1 OR office=".$office." ORDER BY thutu asc");
            while ($row = $database->fetch_array($result_set))
            {
                self::$list[$row["id"]] = $row;
            }
        }
        public static function _full()
        {
            return self::$list;
        }
        public static function _item($id)
        {
            if (isset(self::$list[$id]))
                return self::$list[$id];
            return false;
        }
        function __destruct()
        {
            
        }
    }
    $class_Servicesfieldtext = new Servicesfieldtext();
?>