<?php
    defined("WEB_APP") or die("Please wait ... <META http-equiv=\"refresh\" content=\"0; url=".WEBSITE_URL."\" />");
    class Voucher{
        
        function __construct()
        {
            
        }
        public static function _full()
        {
            global $database;
            global $officeid;
            $list = array();
            $result_set = $database->query("SELECT * FROM voucher WHERE office=".$officeid." ORDER BY joindate DESC");
            while ($row = $database->fetch_array($result_set))
            {
                $list[$row["id"]] = $row;
            }
            return $list;
        }
        public static function _item($id)
        {
            global $database;
            global $officeid;
            $list = array();
            $result_set = $database->query("SELECT * FROM voucher WHERE office=".$officeid." and id=".intval($id));
            while ($row = $database->fetch_array($result_set))
            {
                $list = $row;
            }
            return $list;
        }
        public static function _field($field, $value, $one=true)
        {
            global $database;
            global $officeid;
            $list = array();
            $result_set = $database->query("SELECT * FROM voucher WHERE ".$field."='".$value."' ORDER BY joindate DESC");
            while ($row = $database->fetch_array($result_set))
            {
                if ($one)
                {
                    $list = $row;
                    break;
                }
                else
                    $list[$row["id"]] = $row;
            }
            return $list;
        }
        public static function _range($office, $from, $to)
        {
            global $database;
            global $officeid;
            $list = array();
            $result_set = $database->query("SELECT * FROM voucher WHERE office=".$officeid." AND (joindate>=".$from." AND joindate<=".$to.")");
            while ($row = $database->fetch_array($result_set))
            {
                $list[$row["id"]] = $row;
            }
            return $list;
        }
        public static function _delete($id)
        {
            global $database;
            global $officeid;
            //$database->query("DELETE FROM room WHERE id IN (".$id.") AND office=".$officeid);
        }
        function __destruct()
        {
            
        }
    }
    $class_Voucher = new Voucher();
?>