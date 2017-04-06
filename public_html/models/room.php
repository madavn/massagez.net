<?php
    defined("WEB_APP") or die("Please wait ... <META http-equiv=\"refresh\" content=\"0; url=".WEBSITE_URL."\" />");
    class Room{
        protected static $list, $listtang;
        function __construct()
        {
            global $database;
            global $officeid;
            $result_set = $database->query("SELECT * FROM room WHERE office=".$officeid." ORDER BY thutu ASC");
            while ($row = $database->fetch_array($result_set))
            {
                $a = $row;
                if ($a["servicesgroup"]!="")
                {
                    $x = explode(",", $a["servicesgroup"]);
                    $a["servicesgroup_array"] = array_flip($x);
                }
                else
                    $a["servicesgroup_array"] = array();
                self::$list[$row["id"]] = $a;
                self::$listtang[$row["sotang"]][$row["id"]] = $a;
            }
            @ksort(self::$listtang);
        }
        public static function _full()
        {
            return self::$list;
        }
        public static function _full_tang()
        {
            return self::$listtang;
        }
        public static function _item($id)
        {
            if (isset(self::$list[$id]))
                return self::$list[$id];
            return false;
        }
        public static function _delete($id)
        {
            global $database;
            global $officeid;
            $database->query("DELETE FROM room WHERE id IN (".$id.") AND office=".$officeid);
        }
        function __destruct()
        {
            
        }
    }
    $class_Room = new Room();
?>