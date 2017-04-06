<?php
    defined("WEB_APP") or die("Please wait ... <META http-equiv=\"refresh\" content=\"0; url=".WEBSITE_URL."\" />");
    $listservicesgroup = ServicesGroup::_full();
    $listservices = Services::_full_no_group();
    $listservicesfield = Servicesfield::_full_group();
    $listservicesfieldtext = Servicesfieldtext::_full();
    $listproduct = Product::_full();
    $listroom = Room::_full();
    $listcustomeraction = CustomerAction::_full();
    $listcustomeractiondetail = CustomerActionDetail::_full_group();
    
    if (!empty($_POST))
    {
        $arr = array(
            "joindate" => BAYGIO,
            "services" => intval($_POST["txt-services"]),
            "services_ext" => $_POST["txt-services-ext"],
            "servicesgroup" => intval($_POST["txt-servicesgroup"]),
            "room" => intval($_POST["txt-room"]),
            "method_payment" => intval($_POST["txt-code"]),
            "userid" => @$userlogin["id"],
            "office" => $officeid,
        );
        if ($arr["servicesgroup"]>0)
        {
            $database->insert("customeraction", $arr);
            $customeractionid = $database->insert_id();
        }
        else
            $customeractionid = 0;
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
            $arr_detail[$customeractionid][] = $x;
            $database->insert("customeractiondetail", $x);
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
                $arr_detail[$customeractionid][] = $x;
                $database->insert("customeractiondetail", $x);
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
?>