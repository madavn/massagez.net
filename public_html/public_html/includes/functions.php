<?php
    function __autoload($class_name) {
    	$class_name = strtolower($class_name);
    	$path = MODELS."{$class_name}.php";
    	if(file_exists($path)) {
    		require_once($path);
    	} else {
    		die("File {$class_name}.php không tồn tại!.");
    	}
    }
    function insert_zero_first($str, $length=8)
    {
        $a = $length - strlen($str);
        if ($a>0)
            $str = str_repeat("0", $a).$str;
        return $str;
    }
    function create_password($length=8)
    {
        //$str = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
        //return substr(str_shuffle($str), 0, $length);
        $str1 = "0123456789";
        $str2 = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
        return $str2[rand(26, 51)].substr(str_shuffle($str1), 0, 6).$str2[rand(0, 25)];
    }
    function cut_string($str,$len,$more)
    {
        if ($str=="" || $str==NULL) return $str;
        if (is_array($str)) return $str;
        $str = trim($str);
        if (strlen($str) <= $len) return $str;
        $str = substr($str,0,$len);
        if ($str != "")
        {
            if (!substr_count($str," "))
            {
                if ($more) $str .= "...";
                return $str;
            }
            while(strlen($str) && ($str[strlen($str)-1] != " "))
            {
                $str = substr($str,0,-1);
            }
            $str = substr($str,0,-1);
            if ($more) $str .= "...";
        }
        return $str;
    }
    function check_chairpos($listcustomerwaiting, $chairpos)
    {
        $bool = array();
        foreach($listcustomerwaiting as $key => $row)
            if ($row["chairpos"]==$chairpos)
                $bool = $row;
        return $bool;
    }
    function show_data($data, $listitem, $title)
    {
        if (isset($data[$listitem]))
            return $data[$listitem][$title];
        $str = "";
        foreach(explode(",", $listitem) as $key => $row)
        {
            if (isset($data[$row]))
                $str.= ($str!=""?", ":"") . $data[$row][$title];
        }
        return $str;
    }
    function ret_option_filter($data,$tieude,$valsel)
    {
        $strreturn = "";
        if (empty($data)) return false;
    	foreach ($data as $key => $rowfunc)
        {
    		if ($valsel == $key)
    			$tempfunc = ' selected="selected"';
    		else
    			$tempfunc = "";
    		$strreturn.= "<option value=\"".$key."\"".$tempfunc.">".$rowfunc["$tieude"]."</option>";
    	}
        return $strreturn;
    }
    function ret_option_filter_multi($data, $tieude, $valsel)
    {
        $strreturn = "";
        if (empty($data)) return false;
    	foreach ($data as $key => $rowfunc)
        {
    		if (in_array($key, $valsel))
    			$tempfunc = ' selected="selected"';
    		else
    			$tempfunc = "";
    		$strreturn.= "<option value=\"".$key."\"".$tempfunc.">".$rowfunc["$tieude"]."</option>";
    	}
        return $strreturn;
    }
    function ret_option_filter_min($data, $valsel)
    {
        $strreturn = "";
        if (empty($data)) return false;
    	foreach ($data as $key => $rowfunc)
        {
            if ($valsel == $key)
    			$tempfunc = ' selected';
    		else
    			$tempfunc = "";
    		$strreturn.= "<option value=".$key.$tempfunc.">".$rowfunc."</option>";
        }
        return $strreturn;
    }
    function ret_bo_dau_vn($strvncodau,$thaythekhoangtrang="")
    {
        $strvncodau = str_replace(
        array(' ','%',"/","\\",'"','?','<','>',"#","^","`","'","=","!",":" ,",,","..","*","&","__","▄","&!","(",")"),
        array('-','' ,'' ,'' ,'' ,'' ,'' ,'' ,'' ,'' ,'' ,'' ,'-','' ,'-','' ,'' ,'' , "-" ,"" ,"","","",""),
        $strvncodau);
    	$marTViet=array("à","á","ạ","ả","ã","â","ầ","ấ","ậ","ẩ","ẫ","ă","ằ","ắ","ặ","ẳ","ẵ","è","é","ẹ","ẻ","ẽ","ê","ề","ế","ệ","ể","ễ","ì","í","ị","ỉ","ĩ","ò","ó","ọ","ỏ","õ",
    					"ô","ồ","ố","ộ","ổ","ỗ","ơ","ờ","ớ","ợ","ở","ỡ","ù","ú","ụ","ủ","ũ","ư","ừ","ứ","ự","ử","ữ","ỳ","ý","ỵ","ỷ","ỹ","đ","À","Á","Ạ","Ả","Ã","Â","Ầ","Ấ","Ậ",
    					"Ẩ","Ẫ","Ă","Ằ","Ắ","Ặ","Ẳ","Ẵ","È","É","Ẹ","Ẻ","Ẽ","Ê","Ề","Ế","Ệ","Ể","Ễ","Ì","Í","Ị","Ỉ","Ĩ","Ò","Ó","Ọ","Ỏ","Õ","Ô","Ồ","Ố","Ộ","Ổ","Ỗ","Ơ","Ờ","Ớ",
    					"Ợ","Ở","Ỡ","Ù","Ú","Ụ","Ủ","Ũ","Ư","Ừ","Ứ","Ự","Ử","Ữ","Ỳ","Ý","Ỵ","Ỷ","Ỹ","Đ"," ");
    	$marKoDau=array("a","a","a","a","a","a","a","a","a","a","a","a","a","a","a","a","a","e","e","e","e","e","e","e","e","e","e","e","i","i","i","i","i","o","o","o","o","o",
    					"o","o","o","o","o","o","o","o","o","o","o","o","u","u","u","u","u","u","u","u","u","u","u","y","y","y","y","y","d","A","A","A","A","A","A","A","A","A",
    					"A","A","A","A","A","A","A","A","E","E","E","E","E","E","E","E","E","E","E","I","I","I","I","I","O","O","O","O","O","O","O","O","O","O","O","O","O","O",
    					"O","O","O","U","U","U","U","U","U","U","U","U","U","U","Y","Y","Y","Y","Y","D",$thaythekhoangtrang);
    	return str_replace($marTViet,$marKoDau,$strvncodau);
    }
    function ret_thoigian($time, $type="")
    {
        $strreturn = "";
        switch($type)
        {
            case "abbr":
                $strreturn = '<abbr class="DateTime" data-time="'.$time.'" data-diff="'.(BAYGIO-$time).'" data-datestring="'.date("d/m/Y",$time).'" data-timestring="'.date("H:i",$time).'"></abbr>';
                break;
            default:
                $strreturn = date($type,$time);
                /*if (($remain=BAYGIO-$time)>=86400)
                    $strreturn = date("d-m-Y",$time);
                else
                {
                    if ($remain>=3600)
                        $strreturn = intval($remain/3600)." giờ trước";
                    elseif ($remain>=60)
                        $strreturn = intval($remain/60)." phút trước";
                    else
                        $strreturn = $remain." giây trước";
                }*/
                break;
        }
        return $strreturn;
    }
    function sort_by_joindate_asc($a,$b)
    {
        if ($a["joindate"] == $b["joindate"]) {
            return 0;
        }
        return ($a["joindate"] < $b["joindate"]) ? -1 : 1;
    }
    function sort_by_id_desc($a,$b)
    {
        if ($a["id"] == $b["id"]) {
            return 0;
        }
        return ($a["id"] > $b["id"]) ? -1 : 1;
    }
    function sort_by_id_asc($a,$b)
    {
        if ($a["id"] == $b["id"]) {
            return 0;
        }
        return ($a["id"] < $b["id"]) ? -1 : 1;
    }
    function sort_by_joindate_desc($a,$b)
    {
        if ($a["joindate"] == $b["joindate"]) {
            return 0;
        }
        return ($a["joindate"] > $b["joindate"]) ? -1 : 1;
    }
    function sort_by_lastupdate_asc($a,$b)
    {
        if ($a["lastupdate"] == $b["lastupdate"]) {
            return 0;
        }
        return ($a["lastupdate"] < $b["lastupdate"]) ? -1 : 1;
    }
    function sort_by_lastupdate_desc($a,$b)
    {
        if ($a["lastupdate"] == $b["lastupdate"]) {
            return 0;
        }
        return ($a["lastupdate"] > $b["lastupdate"]) ? -1 : 1;
    }
    function sort_by_thutu_asc($a,$b)
    {
        if ($a["thutu"] == $b["thutu"]) {
            return 0;
        }
        return ($a["thutu"] < $b["thutu"]) ? -1 : 1;
    }
    function ret_pages($urlpage,$num_rows,$itemshow,$pages)
    {
        $strreturn = "";
        if ($num_rows<=$itemshow)
            return $strreturn;
        $sotrang = (int)($num_rows/$itemshow) + ($num_rows%$itemshow?1:0);
        $strreturn = "<ul class=\"pagination\">";
        if ($pages>1)
            $strreturn.= "<li><a href=\"".$urlpage."&amp;pages=".($pages-1)."\">« Trước</a></li>";
        if ($pages<6)
        {
            for ($ipage=1; $ipage<(5+$pages>$sotrang?$sotrang+1:5+$pages); $ipage++)
            {
                $strreturn.= "<li>";
                if ($ipage==$pages)
                    $strreturn.= "<span>".$ipage."</span>";
                else
                    $strreturn.= "<a href=\"".$urlpage."&amp;pages=".$ipage."\">".$ipage."</a> ";
                $strreturn.= "</li>";
            }
        }
        else
        {
            for ($ipage=$pages-5; $ipage<=($pages+4>$sotrang?$sotrang:$pages+4); $ipage++)
            {
                $strreturn.= "<li>";
                if ($ipage==$pages)
    				$strreturn.= "<span>".$ipage."</span>";
                else
    				$strreturn.= "<a href=\"".$urlpage."&amp;pages=".$ipage."\">".$ipage."</a> ";
                $strreturn.= "</li>";
            }
        }
        if ($pages<$sotrang && $sotrang>1)
            $strreturn.= "<li><a href=\"".$urlpage."&amp;pages=".($pages+1)."\">Tiếp »</a></li>";
        $strreturn.= "</ul>";
        return $strreturn;
    }
    
    function ret_title($data)
    {
        if (!is_array($data))
            return;
        $str = array();
        foreach ($data as $key => $row)
        {
            $str[] = $row["title"];
        }
        return join(", ",$str);
    }
    function sum_field($data, $fieldname)
    {
        $tong = 0;
        if (!empty($data))
        foreach ($data as $key => $row)
        {
            $tong+= $row[$fieldname];
        }
        return $tong;
    }
    function sendmail($tomail, $subject, $message)
    {
        try {
        	$mail = new PHPMailer(true); //New instance, with exceptions enabled
        
        	$mail->IsSMTP();                           // tell the class to use SMTP
        	$mail->SMTPAuth   = true;                  // enable SMTP authentication
            $mail->SMTPSecure = "ssl"; 
        	$mail->Port       = 465;                    // set the SMTP server port
        	$mail->Host       = "smtp.gmail.com"; // SMTP server
        	$mail->Username   = "intelli@louis-intelli.com";     // SMTP server username
        	$mail->Password   = "intelli(.*?)2014";            // SMTP server password
            //$mail->Sendmail   = "/var/qmail/bin/sendmail";
            $mail->CharSet    = "UTF-8";
        	//$mail->IsSendmail();  // tell the class to use Sendmail
        
        	$mail->AddReplyTo("intelli@louis-intelli.com", "Công Ty Louis & Intelli");
        
        	$mail->From       = "intelli@louis-intelli.com";
        	$mail->FromName   = "Công Ty Louis & Intelli";
        
        	$mail->AddAddress($tomail);
        
        	$mail->Subject  = $subject;
        
        	//$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
        	//$mail->WordWrap   = 80; // set word wrap
        
        	$mail->MsgHTML($message);
        
        	$mail->IsHTML(true); // send as HTML
        
        	return $mail->Send();
        	//echo 'Message has been sent.';
        } catch (phpmailerException $e) {
        	return $e->errorMessage();
        }
    }
?>