<?php
    defined("WEB_APP") or die("Please wait ... <META http-equiv=\"refresh\" content=\"0; url=".WEBSITE_URL."\" />");
    class Invoice{
        function __construct()
        {
          
        }
        public static function _full($officeid)
        {
            global $database;
            $list = array();
            $result_set = $database->query("SELECT i.*, r.title as tenphong, s.title ktv, sg.title as giave, v.title as voucher_title, v.bonus as voucher_bonus FROM invoice i LEFT JOIN room r ON i.room=r.id LEFT JOIN services s ON i.services=s.id LEFT JOIN servicesgroup sg ON i.servicesgroup=sg.id LEFT JOIN voucher v ON i.method_payment=v.id WHERE i.office=".intval($officeid));
            while ($row = $database->fetch_array($result_set))
            {
                $list[$row["id"]] = $row;
            }
            return $list;
        }
        public static function _item($billid, $officeid)
        {
            global $database;
            $list = array();
            $result_set = $database->query("SELECT c.fullname as tenkhach, u.fullname as thochinh, s.title as tendichvu, ivd.phidichvu, iv.* FROM invoice iv LEFT JOIN invoicedetail ivd ON iv.id=ivd.invoiceid LEFT JOIN customer c ON iv.customerid=c.id LEFT JOIN user u ON iv.usermain=u.id LEFT JOIN services s ON ivd.servicesid=s.id WHERE iv.id=".intval($billid)." ORDER BY ivd.joindate ASC");
            while ($row = $database->fetch_array($result_set))
            {
                $list[] = $row;
            }
            return $list;
        }
        public static function _range($officeid, $from, $to)
        {
            global $database;
            $list = array();
            $result_set = $database->query("SELECT i.*, r.title as tenphong, s.title ktv, sg.title as giave, v.title as voucher_title, v.bonus as voucher_bonus FROM invoice i LEFT JOIN room r ON i.room=r.id LEFT JOIN services s ON i.services=s.id LEFT JOIN servicesgroup sg ON i.servicesgroup=sg.id LEFT JOIN voucher v ON i.method_payment=v.id WHERE i.office=".intval($officeid)." AND (i.joindate>=".$from." AND i.joindate<=".$to.")");
            while ($row = $database->fetch_array($result_set))
            {
                $list[$row["id"]] = $row;
            }
            return $list;
        }
        function __destruct()
        {
            
        }
    }
    $class_Invoice = new Invoice();
?>