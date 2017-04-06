<?php
    defined("WEB_APP") or die("Please wait ... <META http-equiv=\"refresh\" content=\"0; url=".WEBSITE_URL."\" />");
    $list = array();
    $customeraction = array();
    $customeractiondetail = array();
    if (!empty($_POST))
    {
        $status = @$_REQUEST["status"];
        if ($status==0)
        {
            $result = $database->query("select ca.*, sg.thoigian, o.congphut, v.title as voucher_title, v.bonus as voucher_bonus from customeraction ca left join servicesgroup sg on ca.servicesgroup=sg.id left join office o on ca.office=o.id left join voucher v on ca.method_payment=v.id where ca.status='".$status."' and ca.office=".$officeid."");
            while($row=$database->fetch_array($result))
            {
                $customeraction[$row["id"]] = $row;
                $re = $database->query("select * from customeractiondetail where customeractionid=".$row["id"]." and office=".$officeid."");
                while ($ro=$database->fetch_array($re))
                    $customeractiondetail[$row["id"]][$ro["id"]] = $ro;
                $list[0] = $row;
                $list[0]["duedate"] = BAYGIO+($row["thoigian"]*60)+($row["congphut"]*60);
                if ($row["room"]>0)
                    $database->update_self("customeraction", array("status" => "status+1"), "id=".$row["id"]);
                break;
            }
        }
        else if ($status==1)
        {
            $result = $database->query("select * from customeraction where id='".@$_REQUEST["customeractionid"]."' and office=".$officeid."");
            while($row=$database->fetch_array($result))
            {
                if ($row["status"]==$status)
                {
                    $list[] = $row;
                    break;
                }
            }
        }
        if (isset($_POST["customeractiondetail"]))
        {
            if ($_POST["customeractiondetail"]>0)
                $database->update("customeractiondetail", array(
                        "soluong" => intval($_POST["soluong"]),
                        "dongia" => intval($_POST["dongia"]),
                        "thanhtien" => intval($_POST["thanhtien"])
                    ), "customeractiondetail=".intval($_POST["customeractiondetail"])." and office=".$officeid
                );
            else
            {    
                $database->insert("customeractiondetail", array(
                        "customeractionid" => intval($_POST["customeractionid"]),
                        "serviceid" => intval($_POST["serviceid"]),
                        "soluong" => intval($_POST["soluong"]),
                        "dongia" => intval($_POST["dongia"]),
                        "thanhtien" => intval($_POST["thanhtien"]),
                        "office" => $officeid,
                        "joindate" => BAYGIO
                    )
                );
                $list[] = $database->insert_id();
            }
        }
    }
    echo json_encode(array("list" => $list, "customeraction" => $customeraction, "customeractiondetail" => $customeractiondetail));
    die();
?>