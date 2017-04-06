<?php
    defined("WEB_APP") or die("Please wait ... <META http-equiv=\"refresh\" content=\"0; url=".WEBSITE_URL."\" />");
    class CustomerAction{
        protected static $list;
        function __construct()
        {
            global $database;
            global $officeid;
            $result_set = $database->query("SELECT ca.*, v.title as voucher_title, v.bonus as voucher_bonus FROM customeraction ca left join voucher v on ca.method_payment=v.id WHERE ca.office=".$officeid);
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
    $class_CustomerAction = new CustomerAction();
?>