<?php
    //date_default_timezone_set("Asia/Ho_Chi_Minh");
    define("WEBSITE_URL","http://".$_SERVER["SERVER_NAME"]);
    define("WEBSITE_URL_CP","http://".$_SERVER["SERVER_NAME"]."/soap.php");
    define("BASE_URL",getcwd());
    define("INCLUDES",BASE_URL."/libs/");
    define("CONTROLS",BASE_URL."/controls/");
    define("MODELS",BASE_URL."/models/");
    define("BAYGIO",time());
    define("HOMNAY",mktime(0,0,0,date("m",BAYGIO),date("d",BAYGIO),date("Y",BAYGIO)));
    define("MONSUN",date("w",BAYGIO));
    define('WEB_APP', base64_encode(WEBSITE_URL));
    
    //require_once INCLUDES."init.php";
    
    global $database;
    global $database2;
    
    class service
    {
        public function service()
        {
            
        }
        
        public function getID($imei) // phải tra ve so neu ko thi bi loi
        {
            return 3;
        }
        public function capNhatTin($id, $status, $smsid)
        {
            global $database, $database2;
            $trangthai = array("S", "F", "D", "S");
            
            if (strripos($smsid, "_")!==false)
            {
                $x = explode("_", $smsid);
                $database2->update("smsserver_out", array("trangthai" => $trangthai[$status], "lastupdate" => BAYGIO), "id=".$x[1]);
                return "Ket qua cap nhat tin: ".$id.": ".$smsid.": ".$status." => ".$database2->affected_rows();
            }
            //$result = $database2->query("select * from smsserver_out where dt='".."'");
            else
            {
                $database->update("smsserver_out", array("status" => $trangthai[$status], "sent_date" => date("Y-m-d H:i:s", BAYGIO)), "id=".$smsid);
                if ($status==1) // lỗi
                {
                    $database->update_self("smsserver_out", array("status" => "'F'", "errors" => "errors+1"), "id=".$smsid);
                    //file_put_contents("0.txt", BAYGIO-90);
                    //file_put_contents("1.txt", BAYGIO-90);
                }
                //." and gateway_id='".$id."'"
                //file_put_contents(time().".txt", "id: ".$id." - smsid: ".$smsid." - status:".$trangthai[$trangthai]);
                //$database->close_connection();
                return "Ket qua cap nhat tin: ".$id.": ".$smsid.": ".$status." => ".$database->affected_rows();
                //.": ".$database->affected_rows().": ".$database->last_query;
            }
        }
        public function luutin($id, $noidung, $dt)
        {
            global $database, $database2;
            $r = $database->query("select id from smsserver_in order by id desc limit 1");
            while ($row=$database->fetch_array($r))
                $lastid = $row["id"];
            //$database->insert("smsserver_in", array("id" => (++$lastid), "originator" => $dt, "receive_date" => date("Y-m-d H:i:s", BAYGIO), "text" => $noidung, "gateway_id" => $id, "status" => 0));
            $r = $database->query("insert into smsserver_in (id, originator, receive_date, text, gateway_id, status) values ('".($lastid+1)."', '".$dt."', '".date("Y-m-d H:i:s", BAYGIO)."', '".$noidung."', '".$id."', '0')");
            return $database->confirm_query($r);
            //return "save: ".$database->insert_id()."=>".$id.": ".$dt.": ".$noidung;
        }
        public function layTin($id)
        {
            $message = "lấy tin";
            return array("", $message);
        }
    }
    $server = new SoapServer(null, array("uri" => WEBSITE_URL_CP));
    $server->setClass("service");     
    $server->handle();
?>