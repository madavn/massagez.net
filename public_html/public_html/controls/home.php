<?php
    defined("WEB_APP") or die("Please wait ... <META http-equiv=\"refresh\" content=\"0; url=".WEBSITE_URL."\" />");
	$page = 'home'; if(isset($_GET['page'])) $page = $_GET['page'];
    $listservicesgroup = ServicesGroup::_full();
    $listservices = Services::_full_no_group();
    $listservicesfield = Servicesfield::_full_group();
    $listservicesfieldtext = Servicesfieldtext::_full();
    $listproduct = Product::_full();
    $listroom = Room::_full();
    $listcustomeraction = CustomerAction::_full();
    $listcustomeractiondetail = CustomerActionDetail::_full_group();
    $khoadatcho = unserialize($officeitem["khoadatcho"]);
    if (!empty($_POST))
    {
        $arr = array(
            "joindate" => BAYGIO,
            "services" => intval($_POST["txt-services"]),
            "services_ext" => $_POST["txt-services-ext"],
            "servicesgroup" => intval($_POST["txt-servicesgroup"]),
            "room" => intval($_POST["txt-room"]),
            "method_payment" => intval($_POST["txt-code"]),
            //"userid" => $userlogin["id"],
            //"office" => $officeid,
        );
        if ($_POST["customeractionid"]>0)
        {
            $customeractionid = $_POST["customeractionid"];
            $item = CustomerAction::_item($customeractionid);
            if ($item["services"]!=$arr["services"])
            {
                $database->update("services", array("used" => 0), "id=".$item["services"]);
                $database->update("services", array("used" => 1), "id=".$arr["services"]);
            }
            if ($item["room"]!=$arr["room"])
            {
                $database->update("room", array("used" => 0, "services" => "", "customeractionid" => 0), "id=".$item["room"]);
                $database->update("room", array("used" => 1), "id=".$arr["room"]);
            }
            $database->update("customeraction", $arr, "id=".$customeractionid);
        }
        else
        {
            if ($_POST["txt-remind"]>0)
            {
                /*$database->insert("tiepkhach", array(
                    "title" => htmlspecialchars($_POST["txt-tiepkhach"], ENT_QUOTES),
                    "joindate" => BAYGIO,
                    "office" => $officeid
                ));*/
                $arr["customerid"] = intval($_POST["txt-tiepkhach"]) * 1000;
                $arr["verify_remind"] = 1;
            }
            $arr["userid"] = $userlogin["id"];
            $arr["office"] = $officeid;
            if ($arr["servicesgroup"]>0)
            {
                $database->insert("customeraction", $arr);
                $customeractionid = $database->insert_id();
            }
            else
                $customeractionid = 0;
            /*if ($customeractionid>0)
            $database->insert("customeraction", $arr);
            $customeractionid = $database->insert_id();*/
        }
        if ($customeractionid>0)
        {
            $arr["id"] = $customeractionid;
            $x = array(
                "customeractionid" => $customeractionid,
                "serviceid" => 0,
                "soluong" => 1,
                "dongia" => intval($_POST["services-fee"]),
                "thanhtien" => intval($_POST["services-fee"]),
                "office" => $officeid,
                "joindate" => BAYGIO,
            );
            $database->insert("customeractiondetail", $x);
            $i = $database->insert_id();
            $arr_detail[$customeractionid][$i] = $x;
            $arr_detail[$customeractionid][$i]["id"] = $i;
            if (isset($_POST["productid"]))
            while (list($key, $row)=each($_POST["productid"]))
            {
                $x = array(
                    "customeractionid" => $customeractionid,
                    "serviceid" => $row,
                    "soluong" => intval($_POST["soluong"][$key]),
                    "dongia" => intval($_POST["dongia"][$key]),
                    "thanhtien" => intval($_POST["dongia"][$key]*$_POST["soluong"][$key]),
                    "joindate" => BAYGIO,
                );
                $database->insert("customeractiondetail", $x);
                $i = $database->insert_id();
                $arr_detail[$customeractionid][$i] = $x;
                $arr_detail[$customeractionid][$i]["id"] = $i;
            }
            $database->update_self("services", array("used" => "1", "used_count" => "used_count+1"), "(id=".intval($_POST["txt-services"]).($_POST["txt-services-ext"]!=""?" or id in ( ".$_POST["txt-services-ext"].")":"").") and office=".$officeid);
            $database->update_self("servicesgroup", array("used_count" => "used_count+1"), "id=".intval($_POST["txt-servicesgroup"])." and office=".$officeid);
            $database->update("room", array("used" => 1, "services" => $listservices[intval($_POST["txt-services"])]["title"], "customeractionid" => $customeractionid, "duedate" => BAYGIO+($listservicesgroup[$arr["servicesgroup"]]["thoigian"]*60)+($officeitem["congphut"]*60)), "id=".intval($_POST["txt-room"])." and office=".$officeid);
            if ($arr["services_ext"]!="")
            {
                foreach (explode($_POST["txt-services-ext"]) as $a => $b)
                    $database->update("room", array("services_ext" => $listservices[intval($b)]["title"]), "id=".intval($_POST["txt-room"])." and office=".$officeid);
            }
            $database->update("voucher", array("status" => 2, "lastupdate" => BAYGIO), "id=".intval($_POST["txt-code"])." and office=".$officeid);
            $message = "Lưu thông tin thành công";
        }
        else
        {
            $error = 1;
            $message = "Lỗi: ".$database->last_query;
        }
        echo json_encode(array("error" => intval(@$error), "message" => @$message, "customeraction" => array($customeractionid => $arr), "customeractiondetail" => @$arr_detail));
        die();
    }
    $start = date("H", BAYGIO)<12?HOMNAY-43200:HOMNAY+43200;
    $tongve = 0;
    $tongcode = 0;
    $tongtips = 0;
    $truphantram = 0;
    $tongdiennuoc = 0;
    $stats_ktv = array();
    $stats = Invoice::_range($officeid, $start, BAYGIO);
    $listchitieu = Chitieu::_range($officeid, $start, BAYGIO);
    $tongchitieu = sum_field($listchitieu, "money");
    if (!empty($stats))
    foreach ($stats as $key => $row)
    {
        $stats_ktv[$row["services"]] = $row;
        if (isset($stats_ktv[$row["services"]]["soluot"]))
            $stats_ktv[$row["services"]]["soluot"]++;
        else
            $stats_ktv[$row["services"]]["soluot"] = 1;
        if (isset($stats_ktv[$row["services"]]["tips"]))
            $stats_ktv[$row["services"]]["tips"]+= $row["khachtra"];
        else
            $stats_ktv[$row["services"]]["tips"] = $row["khachtra"];
        
        $tongve+= $row["total"];
        $tongcode+= $row["voucher_bonus"];
        $tongtips+= $row["khachtra"];
    }
    $tongve+= $tongcode;
    $truphantram = $tongtips * ($officeitem["truphantram"] / 100);
    $tongdiennuoc = $officeitem["diennuoc"] * count($stats_ktv);
    $tongvoucher = Voucher::_range($officeid, $start, BAYGIO);
?>