<?php
    defined("WEB_APP") or die("Please wait ... <META http-equiv=\"refresh\" content=\"0; url=".WEBSITE_URL."\" />");
    class Product{
        protected static $list;
        function __construct()
        {
            global $database;
            $result_set = $database->query("SELECT * FROM product");
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
        public static function _delete($id)
        {
            global $database;
            $database->query("DELETE FROM product WHERE id IN (".$id.")");
        }
        function __destruct()
        {
            
        }
    }
    $class_Product = new Product();
?>