<?php defined("WEB_APP") or die("Please wait ... <META http-equiv=\"refresh\" content=\"0; url=".WEBSITE_URL."\" />");?>
<div class="form-group clearfix">
    <div class="pull-left">
        <button type="button" name="btn-datcho" class="btn btn-danger">Đặt chỗ</button>
    </div>
    <div class="pull-right">
        Xin chào <?=$userlogin["username"];?>
        <?=in_array($userlogin["role"], array(1))?', <a target="_blank" href="'.WEBSITE_URL.'/admin.php">Trang quản lý</a>':"";?>
        , <a href="<?=WEBSITE_URL_CP;?>?thoat=1">[Thoát]</a>
    </div>
</div>
<div class="tabbable">
    <ul id="myTab" class="nav nav-tabs">
		<li>
			<a href="#home" data-toggle="tab">
				<i class="green icon-home bigger-110"></i> Trang chủ
			</a>
		</li>
        <li>
			<a href="#vetiepkhach" data-toggle="tab">
				<i class="blue icon-time bigger-110"></i> Vé tiếp khách
			</a>
		</li>
		<li class="active">
			<a href="#thanhtoan" data-toggle="tab">
				<i class="red icon-shopping-cart bigger-110"></i> Thanh toán
			</a>
		</li>
        <li>
			<a href="#ktv" data-toggle="tab">
				<i class="purple icon-user bigger-110"></i> Chọn KTV vào làm
			</a>
		</li>
        <li>
			<a href="#voucher" data-toggle="tab">
				<i class="red icon-gift bigger-110"></i> Code
			</a>
		</li>
        <li>
			<a href="#chitieu" data-toggle="tab">
				<i class="green icon-usd bigger-110"></i> Chi tiêu
			</a>
		</li>
        <li>
			<a href="#stats" data-toggle="tab">
				<i class="blue icon-signal bigger-110"></i> Thống kê
			</a>
		</li>
<?php
    if ($officeid==17)
    {
?>
        <li id="tab_dieuthuyen">
			<a href="#dieuthuyen" data-toggle="tab">
				<i class="blue icon-refresh bigger-110"></i> Theo dõi KTV <span id="theodoi_ktv_dieuthuyen"></span>
			</a>
            <script>
                $(document).on("click", ".dieuthuyen_services_btn", function(){
                    
                });
                function f_dieuthuyen()
                {
                    dt_s_total = 0;
                    $.post(
                        WEBSITE_URL_CP + "?components=aaa",
                        {"a": "b"},
                        function(data){
                            $.each (data.list, function(key, row){
                                o = $("#dieuthuyen_services_" + row.services);
                                if (o.find(".office").html()!=row.office)
                                {
                                    o.find(".office").html() = row.office;
                                    o.find("td:eq(2)").html(row.office_title + " đang gọi ");
                                    dt_s_total++;
                                }
                                else
                                {
                                    
                                }
                            });
                            
                            setTimeout("f_dieuthuyen()", 1000 * 3);
                        },
                        "json"
                    );
                }
                f_dieuthuyen();
            </script>
		</li>
<?php
    }
?>
	</ul>
    <div class="tab-content clearfix">
        <div id="home" class="tab-pane">
            <div class="step step-1 pull-left">
                <div id="khoadatcho-overlay" class="khoadatcho-overlay<?=@$khoadatcho["yesno"]?"":" hide";?>"></div>
                <div id="khoadatcho-form" class="khoadatcho-form hide">
                    <div class="form">
                        <div class="form-group">Nhập mật khẩu vào ô bên dưới</div>
                        <div class="form-group"><input type="text" name="khoadatcho-txt" class="form-control" /></div>
                        <div class="form-group"><button type="button" class="btn btn-danger btn-sm" name="khoadatcho-btn">Đồng ý</button></div>
                    </div>
                </div>
<?php
    if (!empty($listservicesgroup))
    foreach ($listservicesgroup as $key => $row)
    {
?>
                <div class="servicesgroup-item col-sm-4 col-xs-6">
                    <div class="center">
                        <div>
                            <a href="javascript:;" idsua="<?=$row["id"];?>" class="servicesgroup">
                                <span class="a1"><?=$row["title"];?></span>
                                <span class="a2"><?=$row["noidung"];?></span>
                            </a>
                        </div>
                    </div>
                </div>
<?php
    }
?>
                <div class="servicesgroup-item col-xs-12">
                    <div class="row">
                        <div class="code-left col-sm-4 col-xs-6">
                            <div class="center">
                                <div>
                                    <a href="javascript:;" class="servicesgroup-code">Code</a>
                                </div>
                            </div>
                        </div>
                        <div class="code-right col-sm-4 col-xs-6">
                            <span class="form-group clearfix hide" style="margin-top: 12px;">
                                <span class="col-xs-6">
                                    <input class="input input-lg form-control" type="text" name="enter-code" placeholder="Nhập mã Code" />
                                </span>
                                <span class="col-xs-6 align-left">
                                    <button type="button" class="btn btn-success" name="btn-enter-code">Đồng ý</button>
                                </span>
                            </span>
                            <span class="bigger-150" id="result-enter-code"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="step step-2 pull-left">
                <div class="clearfix">
                    <button type="button" name="btn-back" class="btn btn-danger pull-left">Trở về</button>
                    <button type="button" name="btn-next" class="btn btn-info pull-right">Tiếp theo</button>
                </div>
                <div class="form-group">
                    <label class="col-sm-5 control-label no-padding-right bigger-130 align-right">Yêu cầu</label>
        			<div class="col-sm-7">
        				<input type="text" name="search-services" placeholder="Nhập mã KTV" />
        			</div>
                </div>
                <div class="services">
<?php
    if (!empty($listservices))
//    foreach ($listservices as $key => $services)
//date("d", $row["checkin"])!=date("d", BAYGIO)?" checkin":""
    {
        foreach ($listservices as $k => $row)
        {
?>
                <div class="service<?=!$row["checkin"]?" checkin":"";?>">
                    <div class="clearfix">
                        <div class="col-xs-2"><span class="red"><?=$row["title"];?></span></div>
                        <div class="col-xs-7">
<?php
            if (!empty($listservicesfieldtext))
            foreach ($listservicesfieldtext as $a => $b)
            {
                $x = $listservicesfield[$row["id"]]["col_".$b["id"]];
                if ($b["phanloai"]=="img")
                    $x = '<img src="'.$x.'" />';
?>
                            <div class="col-xs-4">
                                <?=$b["title"].': '.$x.' '.$b["noidung"];?>
                            </div>
<?php
            }
?>
                        </div>
                        <div class="col-xs-3"><button type="button" class="btn btn-primary step-2-btn" idsua="<?=$row["id"];?>">Chọn</button></div>
                    </div>
                </div>
<?php
        }
    }
?>
                </div>
            </div>
            <div class="step step-3 pull-left">
                <div class="clearfix">
                    <button type="button" name="btn-back" class="btn btn-danger pull-left">Trở về</button>
                    <button type="button" name="btn-next" class="btn btn-info pull-right">Tiếp theo</button>
                </div>
                <div class="media tang">
                    <div class="media-body">
<?php
    if (!empty($listroom))
    foreach ($listroom as $key => $row)
    {
?>
                        <div class="col-md-3 col-sm-3 col-xs-6">
                            <div class="center">
                                <div class="position-relative">
                                    <a href="javascript:;" class="step-3-btn<?=$row["used"]?" used":"";?>" idsua="<?=$row["id"];?>"><?=$row["title"];?></a>
                                    <div class="position-absolute nv">
                                        KTV: <span><?=$row["services"];?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
<?php
    }
?>
                    </div>
                </div>
            </div>
            <div class="step step-4 clearfix">
                <div class="invoice" style="color:#fff">
                    <div class="trove">
                        <button type="button" name="btn-back" class="btn btn-danger">Trở về</button>
                    </div>
                    <div class="center">
                        <h1>Hóa đơn</h1>
                    </div>
                    <form class="form-horizontal" method="post" name="frm-thanhtoan">
                        <input type="hidden" name="txt-total" />
                        <input type="hidden" name="txt-servicesgroup" />
                        <input type="hidden" name="txt-services" />
                        <input type="hidden" name="txt-services-ext" />
                        <input type="hidden" name="txt-room" />
                        <input type="hidden" name="txt-joindate" />
                        <input type="hidden" name="customeractionid" />
                        <input type="hidden" name="txt-code" />
                        <input type="hidden" name="txt-tiepkhach" />
                        <input type="hidden" name="txt-remind" />
                        <div class="row header" style="border: none;">
                            <div class="col-xs-2">Dịch vụ: <span class="step-4-servicesgroup"></span></div>
                            <div class="col-xs-2">Nhân viên: <span class="step-4-services"></span></div>
                            <div class="col-xs-2">Phòng: <span class="step-4-room"></span></div>
                            <div class="col-xs-2">Giờ vào: <span class="step-4-check-in"></span></div>
                            <div class="col-xs-2">Số HĐ: <span class="step-4-sohd"></span></div>
                        </div>
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>stt</th>
                                    <th>Tiêu đề</th>
                                    <th>Đơn giá</th>
                                    <th>Số lượng</th>
                                    <th>Thành tiền</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr id="services-fee">
                                    <td>01</td>
                                    <td>Phí dịch vụ</td>
                                    <td></td>
                                    <td>01</td>
                                    <td class="blue bolder"></td>
                                    <td><input type="hidden" name="services-fee" /></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr id="tr-code" style="display: none;">
                                    <td>#</td>
                                    <td>Code: <span class="green bolder"></span></td>
                                    <td></td>
                                    <td>01</td>
                                    <td class="green bolder"></td>
                                    <td></td>
                                </tr>
                                <tr class="money-tips" style="display: none;">
                                    <td colspan="4" class="align-right">
                                        <label class="control-label">Tiền Tips</label>
                                    </td>
                                    <td style="width: 30%;">
                                        <div id="tips-ktv1" class="col-xs-12 form-group">
                                            <span class="white pull-left" style="width: 50px;"></span>
                                            <input type="text" name="money-tips" size="5" class="red keyup_money pull-left" />
                                            <p style="font-weight: bold;float: left;color: #fff;margin-left: 10px"></p>
                                        </div>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th colspan="4" class="align-right bigger-150">Tổng cộng:</th>
                                    <th><div id="total" class="red bigger-150"></div></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td colspan="6">
                                        <div class="center">
                                            <button type="button" name="add-product" class="btn btn-purple">Thêm đồ uống</button>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </form>
                    <div class="clearfix pull-right">
                        <div id="hoanthanh" class="pull-left" style="display: none;">
                            <button type="button" class="btn btn-primary" name="step-4-btn-hoanthanh">Hoàn thành</button>
                        </div>
                        <div id="invoice" class="pull-left" style="display: none;">
                            <button type="button" class="btn btn-purple" name="step-4-btn-reprint">In hóa đơn</button>
                            &nbsp;&nbsp;&nbsp;
                            <button type="button" class="btn btn-primary hide" name="step-4-btn-change-room">Đổi phòng</button>
                            <button type="button" class="btn btn-primary" name="step-4-btn-change-servicesgroup">Đổi dịch vụ</button>
                            &nbsp;&nbsp;&nbsp;
                            <button type="button" class="btn btn-primary" name="step-4-btn-change-services">Đổi KTV</button>
                            &nbsp;&nbsp;&nbsp;
                            <button type="button" class="btn btn-success" name="step-4-btn-thanhtoan">Thanh toán</button>
                            &nbsp;&nbsp;&nbsp;
                            <button type="button" class="btn btn-danger" name="step-4-btn-thanhtoan-huy">Hủy</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="vetiepkhach" class="tab-pane">
            <div class="step clearfix" style="display: block;color: #fff;">
                <div class="form-group clearfix">
                    <div class="col-xs-3">
                        <h4>Nhập giá tiền (Bỏ 3 số 0 cuối)</h4>
                        <input type="text" class="form-control" name="tiepkhach" />
                    </div>
                    <div class="col-xs-3">
                        <h4>Nhập Code</h4>
                        <div class="input-group">
    						<input type="text" class="form-control" name="tiepkhach_code" />
    						<span class="input-group-btn">
    							<button class="btn btn-purple btn-sm" type="button" name="btn-tiepkhach-xacnhan">Xác nhận</button>
    						</span>
    					</div>
                    </div>
                    <div class="col-xs-3">
                        <h4>Chọn dịch vu</h4>
                        <select name="tiepkhach_servicesgroup" class="form-control">
                            <?=ret_option_filter($listservicesgroup, "noidung", 0);?>
                        </select>
                    </div>
                    <div class="col-xs-3">
                        <h4>Chọn KTV</h4>
                        <select name="tiepkhach_services" class="form-control">
<?php
    if (!empty($listservices))
    foreach ($listservices as $key => $row)
    {
        if ($row["used"]==0 && $row["checkin"]==1)
            echo '<option value="'.$row["id"].'">'.$row["title"].'</option>';
    }
?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-3">
                    <button class="btn btn-danger" name="btn-tiepkhach">Chọn</button>
                </div>
                <div class="col-xs-3">
                    <div class="tiepkhach-code-result bigger-150" style="color: #FFFF00;"></div>
                </div>
            </div>
        </div>
        <div id="thanhtoan" class="tab-pane active">
            <div class="step-3" style="display: block;">
                <div class="media tang">
                    <div class="media-body">
<?php
    if (!empty($listroom))
    foreach ($listroom as $key => $row)
    {
?>
                        <div class="col-md-3 col-sm-3 col-xs-6">
                            <div class="center">
                                <div class="position-relative">
                                    <a href="javascript:;" class="clearfix btn-room-thanhtoan<?=$row["used"]?" used":"";?>" idsua="<?=$row["id"];?>" customeractionid="<?=$row["customeractionid"];?>">
                                        <span class="col-xs-6">&nbsp;</span>
                                        <span class="col-xs-6 duedate" time="<?=$row["duedate"];?>"></span>
                                    </a>
                                    <div class="position-absolute nv">
                                        <span><?=$row["services"];?></span>
                                        <?=($row["services_ext"]!=""?'<span>'.$row["services_ext"].'</span>':"");?>
                                    </div>
                                </div>
                            </div>
                        </div>
<?php
    }
?>
                    </div>
                </div>
            </div>
        </div>
        <div id="ktv" class="tab-pane">
            <div class="clearfix">
                <button type="button" class="btn btn-success pull-right btn-ktv-clear">Clear</button>
            </div>
            <div class="services">
<?php
    if (!empty($listservices))
//    foreach ($listservices as $key => $services)
    {
        foreach ($listservices as $k => $row)
        {
?>
                <div class="service">
                    <div class="clearfix">
                        <div class="col-xs-2"><?=$row["title"];?></div>
                        <div class="col-xs-7">
<?php
            if (!empty($listservicesfieldtext))
            foreach ($listservicesfieldtext as $a => $b)
            {
                $x = $listservicesfield[$row["id"]]["col_".$b["id"]];
                if ($b["phanloai"]=="img")
                    $x = '<img src="'.$x.'" />';
?>
                            <div class="col-xs-4">
                                <?=$b["title"].': '.$x.' '.$b["noidung"];?>
                            </div>
<?php
            }
?>
                        </div>
                        <div class="col-xs-3">
                            <button type="button" class="btn btn-primary ktv-btn-checkin<?=$row["checkin"]?" hide":"";?>" idsua="<?=$row["id"];?>">Vào làm</button>
                            <button type="button" class="btn btn-danger ktv-btn-checkout<?=!$row["checkin"]?" hide":"";?>" idsua="<?=$row["id"];?>">Ra về</button>
                        </div>
                    </div>
                </div>
<?php
        }
    }
?>
            </div>
        </div>
        <div id="voucher" class="tab-pane">
            <div class="form-group clearfix">
                <label style="color: #FFFF00;" class="col-sm-3 control-label no-padding-right align-right">Nhập Code</label>
    			<div class="col-sm-3">
    				<input type="text" class="form-control" name="txt-voucher" />
    			</div>
                <div class="col-sm-3">
                    <button name="btn-voucher" type="button" class="btn btn-primary btn-sm">Đồng ý</button>
                </div>
            </div>
            <div id="result-voucher">
                <div style="width: 70%; margin: 0 auto;">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Giảm giá</th>
                                <th>Trạng thái</th>
                                <th>Ngày tạo</th>
                                <th>Ngày sử dụng</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
<?php
    if (!empty($tongvoucher))
    foreach ($tongvoucher as $key => $row)
    {
?>
                            <tr>
                                <td><?=$row["title"];?></td>
                                <td><?=$row["bonus"]>0?$row["bonus"]:"Miễn phí";?></td>
                                <td><?=$voucher_status_array[$row["status"]];?></td>
                                <td><?=ret_thoigian($row["joindate"], "H:i, d/m/Y");?></td>
                                <td><?=$row["lastupdate"]==0?"":ret_thoigian($row["lastupdate"], "H:i, d/m/Y");?></td>
                                <td></td>
                            </tr>
<?php
    }
?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div id="stats" class="tab-pane">
            <div class="center">
                <h3>Thống kê từ <span style="color: #ff0000;"><?=ret_thoigian($start, "H:i, d/m/Y")." đến ".ret_thoigian(BAYGIO, "H:i, d/m/Y");?></span></h3>
            </div>
            <div class="step">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <th>Tiền vé</th>
                        <th>Code</th>
                        <th>Phần trăm tips</th>
                        <th>Điện nước</th>
                        <th>Chi tiêu</th>
                        <th>Thực thu</th>
                    </thead>
                    <tbody class="bigger-150">
                        <td><?=number_format($tongve);?></td>
                        <td><?=number_format($tongcode);?></td>
                        <td><?=number_format($truphantram);?></td>
                        <td><?=number_format($tongdiennuoc);?></td>
                        <td><?=number_format($tongchitieu);?></td>
                        <td><?=number_format($tongve-$tongcode+$truphantram+$tongdiennuoc-$tongchitieu);?></td>
                    </tbody>
                </table>
                <div class="form-group clearfix">
                    <div class="col-sm-2">
                        <input type="text" class="form-control search-ktv" placeholder="Nhập mã số KTV" />
                    </div>
                </div>
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>KTV</th>
                        <th>Số lượt</th>
                        <th>Tiền tips</th>
                        <th>Trừ %</th>
                        <th>Điện nước</th>
                        <th>Thực lĩnh</th>
                    </tr>
                    </thead>
                    <tbody>
<?php
    if (!empty($stats_ktv))
    foreach ($stats_ktv as $key => $row)
    {
        $percent = $row["tips"] * ($officeitem["truphantram"] / 100);
?>
                <tr>
                    <td><?=$row["ktv"];?></td>
                    <td><?=$row["soluot"];?></td>
                    <td><?=number_format($row["tips"]);?></td>
                    <td><?=number_format($percent);?></td>
                    <td><?=number_format($officeitem["diennuoc"]);?></td>
                    <td><?=number_format($row["tips"] - $percent - $officeitem["diennuoc"])?></td>
                </tr> 
<?php
    }
        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div id="chitieu" class="tab-pane">
            <div class="center">
                <h3 class="white">Quản lý chi tiêu</h3>
            </div>
            <div class="form-group clearfix white">
                <div class="col-sm-3">
                    <div>Tên chi phí</div>
                    <input type="text" name="chitieu-title" class="form-control" />
                </div>
                <div class="col-sm-2">
                    <div>Số tiền (Bỏ 3 số 0 cuối)</div>
                    <input type="text" name="chitieu-money" class="form-control" />
                </div>
                <div class="col-sm-4">
                    <div>Ghi chú</div>
                    <input type="text" name="chitieu-ghichu" class="form-control" />
                </div>
                <div class="col-sm-1">
                    <div>&nbsp;</div>
                    <button type="button" class="btn btn-danger btn-sm" name="chitieu-btn">Thêm</button>
                </div>
            </div>
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Tiêu đề</th>
                        <th>Số tiền</th>
                        <th>Ghi chú</th>
                        <th>Thời gian</th>
                    </tr>
                </thead>
                <tbody>
<?php
    if (!empty($listchitieu))
    foreach ($listchitieu as $key => $row)
    {
?>
                    <tr>
                        <td><?=$row["title"];?></td>
                        <td><?=number_format($row["money"]);?></td>
                        <td><?=$row["ghichu"];?></td>
                        <td><?=ret_thoigian($row["joindate"], "H:i, d/m/Y");?></td>
                    </tr>
<?php
    }
?>
                </tbody>
            </table>
        </div>
        <div id="dieuthuyen" class="tab-pane">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Tiêu đề</th>
                        <th>Địa điểm</th>
                        <th>Trạng thái</th>
                        <th>Xử lý</th>
                    </tr>
                </thead>
                <tbody>
<?php
    if (!empty($listservices))
    foreach ($listservices as $key => $row)
    {
?>
                    <tr id="dieuthuyen_services_<?=$row["id"];?>">
                        <td><?=$row["title"];?></td>
                        <td><div class="hide office">17</div><div class="office_text">Điêu Thuyền</div></td>
                        <td></td>
                        <td><button class="btn btn-danger dieuthuyen_services_btn" style="display: none;">Xử l</button></td>
                    </tr>
<?php
    }
?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    function getaction()
    {
        $.post(
            WEBSITE_URL_CP,
            {"components": "customeraction", "status": 0},
            function(data){
                ca = data.list;
                if (ca.length>0)
                {
                    ca = ca[0];
                    // nếu ko có phòng
                    if (ca.room==0)
                    {
                        if ($("[name=txt-room]").val()=="" || $("[name=txt-room]").val()=="0")
                        {
                            $("#home").find(".step").hide();
                            $("#home").find(".step-3").show();
                            $("[name=txt-servicesgroup]").val(ca.servicesgroup);
                            $("[name=txt-services]").val(ca.services);
                            $("[name=customeractionid]").val(ca.id);
                        }
                    }
                    else
                    {
                        $(".step-1").find(".active").removeClass("active");
                        $(".step-1").show();
                        $(".step-2").find(".service-checked").removeClass("service-checked").addClass("used");
                        $(".step-3").find("[idsua="+ca.room+"]").addClass("used");
                        $(".step-3").find("[idsua="+ca.room+"]").next().find("span").html(listservices[ca.services].title);
                        $(".step-3").find("[idsua="+ca.room+"]").attr("customeractionid", ca.id);
                        $(".step-4").hide();
                        $("#thanhtoan").find("[idsua="+ca.room+"]").find(".duedate").attr("time", ca.duedate);
                        listroom[ca.room].used = 1;
                        listcustomeraction = $.extend(listcustomeraction, data.customeraction);
                        listcustomeractiondetail = $.extend(listcustomeractiondetail, data.listcustomeractiondetail);
                        total_product = 0;
                        total = 0;
                        bonus = 0;
                        $(".code-right").find("span.form-group").hide();
                        $(".code-right").find("[name=enter-code]").val("").attr("disabled", false);
                        $(".code-right").find("[name=btn-enter-code]").attr("disabled", false);
                        $(".code-right").find("#result-enter-code").html("");
                        $("[name=txt-code]").val("");
                        $("#tr-code").hide();
                        // in hóa đơn
                        window.open(WEBSITE_URL + "/printbill.php?idsua=" + ca.id);
                        // reset form
                        window.location = WEBSITE_URL;
                    }
                }
                setTimeout("getaction()", 1000);
            },
            "json"
        );
    }
    function room_downtime()
    {
        var d = new Date();
        d1 = parseInt(d.getTime()/1000);
        $.each($("#thanhtoan").find(".btn-room-thanhtoan"), function(k, v){
            if ($(this).hasClass("used"))
            {
                d2 = parseInt($(this).find(".duedate").attr("time"));
                d3 = d2 - d1;
                if (d3>0)
                {
                    phut = parseInt(d3/60);
                    giay = d3 - (phut*60);
                    $(this).find(".duedate").html(phut + ":" + (giay<10?"0":"") + giay);
                }
                else
                {
                    // nhấp nháy?
                    $(this).find(".duedate").toggleClass("blink");
                    $(this).find(".duedate").html("00:00");
                }
            }
            else
            {
                $(this).find(".duedate").html("00:00");
            }
        });
        setTimeout("room_downtime()", 1000);
    }
    room_downtime();
    get_services();
    getaction();
</script>