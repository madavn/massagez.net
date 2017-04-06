<?php
    defined("WEB_APP") or die("Please wait ... <META http-equiv=\"refresh\" content=\"0; url=".WEBSITE_URL."\" />");
    class Office{
        protected static $list;
        function __construct()
        {
            global $database;
            global $userlogin;
            global $officeid;
            $result_set = $database->query("SELECT * FROM office ORDER BY thutu ASC");
            while ($row = $database->fetch_array($result_set))
            {
                self::$list[$row["id"]] = $row;
            }
        }
        public static function _full()
        {
            return self::$list;
        }
        public static function _item($id, $first=false)
        {
            $tmp = self::$list;
            if (isset(self::$list[$id]))
                return self::$list[$id];
            else if ($first)
                return @array_shift($tmp);
            return false;
        }
        public static function _sudomain($subdomain, $first=true)
        {
            global $database;
            $list = array();
            $result_set = $database->query("SELECT * FROM office WHERE subdomain='".$subdomain."'");
            while ($row = $database->fetch_array($result_set))
            {
                if ($first)
                {
                    $list = $row;
                    break;
                }
                else
                {
                    $list[] = $row;
                }
            }
            return $list;
        }
        public static function _delete($id)
        {
            global $database;
            //$database->query("DELETE FROM office WHERE id IN (".$id.") AND ");
        }
        function __destruct()
        {
            
        }
    }
    $class_Office = new Office();
?>