<?php
    defined("WEB_APP") or die("Please wait ... <META http-equiv=\"refresh\" content=\"0; url=".WEBSITE_URL."\" />");
    class User{
        function __construct()
        {
        }
        public static function _full($office, $exclude_userid=0)
        {
            global $database;
            $list = array();
            $exclude_userid = intval($exclude_userid);
            $result_set = $database->query("SELECT u.*, r.title as vaitro, o.title as tenvanphong FROM user u LEFT JOIN role r ON u.role=r.id LEFT JOIN office o ON u.office=o.id WHERE u.office=".$office.($exclude_userid>0?" AND u.id<>".$exclude_userid:""));
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
            $result_set = $database->query("SELECT u.*, r.title as vaitro, o.title as tenvanphong FROM user u LEFT JOIN role r ON u.role=r.id LEFT JOIN office o ON u.office=o.id WHERE u.id=".intval($id));
            while ($row = $database->fetch_array($result_set))
            {
                $list = $row;
            }
            return $list;
        }
        public static function _role($roleid, $office=0)
        {
            global $database;
            $list = array();
            $roleid = intval($roleid);
            $office = intval($office);
            $result_set = $database->query("SELECT u.*, r.title as vaitro, o.title as tenvanphong FROM user u LEFT JOIN role r ON u.role=r.id LEFT JOIN office o ON u.office=o.id WHERE u.role=".$roleid.($office>0?" AND o.id=".$office:""));
            while ($row = $database->fetch_array($result_set))
            {
                $list[$row["id"]] = $row;
            }
            return $list;
        }
        public static function login($username="", $password="", $subdomain, $role="")
        {
            global $database;
            if ($username=="" || $password=="")
            {
                return false;
            }
            else
            {
                $username = htmlspecialchars($username,ENT_QUOTES);
                $result_set = $database->query("SELECT r.components, u.* FROM user u INNER JOIN role r ON u.role=r.id WHERE u.username='".$username."' and subdomain='".$subdomain."'");
                if ($database->num_rows($result_set)>0)
                {
                    while ($row = $database->fetch_array($result_set))
                    {
                        if ($row["password"]==md5(sha1($password)))
                        {
                            if (is_numeric($role))
                            {
                                if ($row["role"]==$role)
                                    return $row;
                                else
                                    return false;
                            }
                            //$_SESSION["userlogin"] = $row;
                            return $row;
                        }
                    }
                    return false;
                }
                else
                {
                    return false;
                }
            }
        }
        public static function check_email($email)
        {
            global $database;
            // check $email valid
            if (!filter_var($email, FILTER_VALIDATE_EMAIL))
                return false;
            $result_set = $database->query("SELECT * FROM user WHERE email='".$email."'");
            while ($row = $database->fetch_array($result_set))
                return $row;
            return false;
            /*if ($database->num_rows($result_set)==1)
            {
                return true;
            }
            else
            {
                return false;
            }*/
        }
        public static function check_field($field, $value)
        {
            global $database;
            $result_set = $database->query("SELECT * FROM user WHERE ".$field."='".htmlspecialchars($value, ENT_QUOTES)."'");
            while ($row = $database->fetch_array($result_set))
                return $row;
            return false;
            /*if ($database->num_rows($result_set)==1)
            {
                return true;
            }
            else
            {
                return false;
            }*/
        }
        public static function _delete($listuser)
        {
            global $database;
            $database->query("DELETE FROM user WHERE id IN (".$listuser.")");
            return true;
        }
        function __destruct()
        {
            
        }
    }
    $class_user = new User();
?>