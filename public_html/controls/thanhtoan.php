<?php
    defined("WEB_APP") or die("Please wait ... <META http-equiv=\"refresh\" content=\"0; url=".WEBSITE_URL."\" />");
    $ext = array();
    $ext_tong = 0;
    if (!empty($_POST))
    {
        if (isset($_POST["money-tips-2-id"]))
        {
            while(list($key, $value)=each($_POST["money-tips-2-id"]))
            {
                if (is_numeric($_POST["money-tips-2"][$key]))
                {
                    $ext[$value] = $_POST["money-tips-2"][$key]*1000;
                    $ext_tong+= $_POST["money-tips-2"][$key];
                }
            }
        }
        $result = $database->query("select * from customeraction where id='".@$_REQUEST["customeractionid"]."' and office=".$officeid."");
        while($row=$database->fetch_array($result))
        {
            $money_tips_2 = isset($_POST["money-tips-2"])?$_POST["money-tips-2"]:0;
            $x = array(
                    "id" => @$_REQUEST["customeractionid"],
                    "customerid" => intval($_POST["txt-tiepkhach"]),
                    "room" => $row["room"],
                    "office" => $officeid,
                    "services" => $row["services"],
                    "services_ext" => $row["services_ext"],
                    "servicesgroup" => $row["servicesgroup"],
                    "khachtra" => intval($_POST["money-tips"])*1000,
                    "khachtra_ext" => serialize($ext),
                    "method_payment" => intval($row["method_payment"]),
                    "giamgia" => $row["verify_remind"],
                    "total" => intval($_POST["txt-total"]+($_POST["money-tips"]+$ext_tong)*1000),
                    "joindate" => BAYGIO,
                    "userid" => $userlogin["id"]
                );
            $database->insert("invoice", $x);
            if (($invoiceid=$database->insert_id())>0)
            {
                $invoice = $x;
                $invoice["id"] = $invoiceid;
                $re = $database->query("select cad.* from customeractiondetail cad where cad.customeractionid=".$row["id"]." and cad.office=".$row["office"]);
                while ($ro=$database->fetch_array($re))
                {
                    $database->insert("invoicedetail", array(
                            "invoiceid" => $invoiceid,
                            "servicesid" => $ro["serviceid"],
                            "soluong" => $ro["soluong"],
                            "dongia" => $ro["dongia"],
                            "thanhtien" => $ro["thanhtien"],
                            "joindate" => BAYGIO
                        )
                    );
                }
                // reset tất cả
                $database->delete("customeraction", "id=".$row["id"]);
                $database->delete("customeractiondetail", "customeractionid=".$row["id"]);
                $database->update("room", array("used" => 0, "services" => "", "services_ext" => "", "customeractionid" => 0), "id=".$row["room"]);
                $database->update("services", array("used" => 0, "lastupdate" => BAYGIO), "id=".$row["services"].($row["services_ext"]!=""?" or id in ( ".$row["services_ext"].")":""));
                $database->update("voucher", array("status" => 1, "lastupdate" => BAYGIO), "id=".$row["method_payment"]." and office=".$officeid);
            }
            else
            {
                $error = 1;
                $message = "Lỗi: ".$database->last_query;
            }
        }
    }
    echo json_encode(array("error" => intval(@$error), "message" => @$message, "invoice" => @$invoice, "customeraction" => @$_REQUEST["customeractionid"]));
    die();
?>