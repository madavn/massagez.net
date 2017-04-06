<?php
    defined("WEB_APP") or die("Please wait ... <META http-equiv=\"refresh\" content=\"0; url=".WEBSITE_URL."\" />");
    class CustomerActionDetail{
        protected static $list, $list_group;
        function __construct()
        {
            global $database;
            global $officeid;
            $result_set = $database->query("SELECT ca.* FROM customeractiondetail ca WHERE ca.office=".$officeid);
            while ($row = $database->fetch_array($result_set))
            {
                self::$list[$row["id"]] = $row;
                self::$list_group[$row["customeractionid"]][$row["id"]] = $row;
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
    $class_CustomerActionDetail = new CustomerActionDetail();
?>