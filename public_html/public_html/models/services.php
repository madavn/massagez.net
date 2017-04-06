<?php
    defined("WEB_APP") or die("Please wait ... <META http-equiv=\"refresh\" content=\"0; url=".WEBSITE_URL."\" />");
    class Services{
        protected static $list, $list_no_group;
        function __construct()
        {
            global $database;
            global $officeid;
            
            // tru?ng h?p d?c bi?t: hoàng gia l?y ktv t? dieuthuyen
            //$office = $officeid==20?17:$officeid;
            $office = $officeid;
            
            $result_set = $database->query("SELECT s.*, g.title as titlegroup FROM services s LEFT JOIN servicesgroup g ON s.groupid=g.id AND g.office=".$office." WHERE s.office=".$office." ORDER BY s.lastupdate ASC");
            while ($row = $database->fetch_array($result_set))
            {
                $a = $row;
                if ($a["grouptext"]!="")
                {
                    $x = explode(",", $a["grouptext"]);
                    $a["grouptext_array"] = array_flip($x);
                }
                else
                    $a["grouptext_array"] = array();
                self::$list[$row["groupid"]][$row["id"]] = $a;
                self::$list_no_group[$row["id"]] = $a;
            }
        }
        public static function _full()
        {
            return self::$list;
        }
        public static function _full_no_group()
        {
            return self::$list_no_group;
        }
        public static function _item($id)
        {
            if (!empty(self::$list))
            foreach (self::$list as $key => $row)
            {
                if (array_key_exists($id, $row))
                    return $row[$id];
            }
            /*if (isset(self::$list[$id]))
                return self::$list[$id];*/
            return false;
        }
        public static function _item_ext($id_ext)
        {
            if (!is_array($id_ext))
                $id_ext = explode(",", $id_ext);
            $list = array_intersect_key(self::$list_no_group, array_flip($id_ext));
            /*if (!empty(self::$list_no_group))
            foreach (self::$list_no_group as $key => $row)
            {
                if (in_array($row["id"], $id_ext))
            }*/
            return $list;
        }
        public static function _delete($id)
        {
            global $database;
            global $officeid;
            $database->query("DELETE FROM services WHERE id IN (".$id.") AND office=".$officeid);
        }
        function __destruct()
        {
            
        }
    }
    $class_Services = new Services();
?>