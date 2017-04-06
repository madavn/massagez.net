<?php defined("WEB_APP") or die("Please wait ... <META http-equiv=\"refresh\" content=\"0; url=".WEBSITE_URL."\" />");?>
<div class="tabbable">
    <ul id="myTab" class="nav nav-tabs">
		<li class="hide">
			<a href="#home" data-toggle="tab">
				<i class="green icon-home bigger-110"></i> Trang chủ
			</a>
		</li>
	</ul>
    <div class="tab-content clearfix">
        <div id="home" class="tab-pane in active">
            <div class="step step-1 pull-left">
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
                        <div class="col-sm-4"></div>
                        <div class="code-right col-sm-4 col-xs-6">
                            <span class="form-group clearfix hide" style="margin-top: 12px;float: right;">
                                <span class="col-xs-6">
                                    <input class="input input-lg form-control" type="text" name="enter-code" placeholder="Nhập mã Code" />
                                </span>
                                <span class="col-xs-6 align-left">
                                    <button type="button" class="btn btn-success" name="btn-enter-code">Đồng ý</button>
                                </span>
                            </span>
                            <span style="color: #ffff00;" class="bigger-150" id="result-enter-code"></span>
                        </div>
                        <div class="code-left col-sm-4 col-xs-6">
                            <div class="center">
                                <div>
                                    <a href="javascript:;" class="servicesgroup-code">Code</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="step step-2 pull-left">
                <div>
                    <button name="btn-back" class="btn btn-danger btn-lg">Trở về</button>
                </div>
                <div class="form-group clearfix">
                    <div class="col-sm-5 control-label no-padding-right bigger-130 align-right">
                        <button type="button" class="btn btn-dangers btn-lg bigger-200" name="btn-yeucau">Yêu cầu</button>
                    </div>
        			<div class="col-sm-7">
                        <div class="service-button clearfix">
<?php
    if (!empty($listservices))
    foreach ($listservices as $k => $row)
    {
?>
                            <div class="service<?=$row["used"]?" used":"";?><?=!$row["checkin"]?" checkin":"";?>">
                                <button type="button" class="btn btn-primary step-2-btn" idsua="<?=$row["id"];?>"><?=$row["title"];?></button>
                            </div>
<?php
    }
?>
                        </div>
        				<input type="text" name="search-services" placeholder="Nhập mã KTV" class="hide" />
        			</div>
                </div>
                <div class="services">
<?php
    if (!empty($listservices))
//    foreach ($listservices as $key => $services)
    {
        foreach ($listservices as $k => $row)
        {
?>
                <div class="service<?=$row["used"]?" used":"";?><?=!$row["checkin"]?" checkin":"";?>">
                    <div class="clearfix">
                        <div class="bigger-200 col-xs-12"><span class="red"><?=$row["title"];?></span></div>
                        <div class="col-xs-9">
<?php
            if (!empty($listservicesfieldtext))
            foreach ($listservicesfieldtext as $a => $b)
            {
                $x = $listservicesfield[$row["id"]]["col_".$b["id"]];
                if ($b["phanloai"]=="img")
                {
                    $href = WEBSITE_URL."/picture.php?type=servicesfield&action=col_".$b["id"]."&idsua=".$listservicesfield[$row["id"]]["id"];
                    $x = '<a class="colorbox" href="'.$href.'"><img src="'.$href.'" /></a>';
                }//!($b["phanloai"]=="img" && $listservicesfield[$row["id"]]["col_".$b["id"]]!="")?"":" hides"
?>
                            <div class="bigger-200 col-md-4 col-xs-6<?=$b["phanloai"]=="img" && $listservicesfield[$row["id"]]["col_".$b["id"]]==""?" hide":"";?>">
                                <?=$b["title"].': '.$x.' '.$b["noidung"];?>
                            </div>
<?php
            }
?>
                        </div>
                        <div class="col-xs-3">
                            <button type="button" class="btn btn-danger step-2-btn btn-lg" idsua="<?=$row["id"];?>">Chọn</button>
                            <div><span class="red bigger-200 bolder"><?=$row["title"];?></span></div>
                        </div>
                    </div>
                </div>
<?php
        }
    }
?>
                </div>
            </div>
            <div class="step step-3">
            </div>
            <div class="step step-4">
                <div class="invoice">
                    <div class="center">
                        <h1>Hóa đơn</h1>
                    </div>
                    <form class="form-horizontal" method="post" name="frm-thanhtoan">
                        <input type="hidden" name="txt-servicesgroup" />
                        <input type="hidden" name="txt-services" />
                        <input type="hidden" name="txt-services-ext" />
                        <input type="hidden" name="txt-room" />
                        <input type="hidden" name="txt-joindate" />
                        <input type="hidden" name="customeractionid" />
                        <input type="hidden" name="txt-code" />
                        <input type="hidden" name="txt-tiepkhach" />
                        <div class="row header" style="border: none;">
                            <div class="col-xs-3">Dịch vụ: <span class="step-4-servicesgroup"></span></div>
                            <div class="col-xs-3">Nhân viên: <span class="step-4-services"></span></div>
                            <div class="col-xs-3">Phòng: <span class="step-4-room"></span></div>
                            <div class="col-xs-3">Giờ vào: <span class="step-4-check-in"></span></div>
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
                                    <td>
                                        <input type="text" name="money-tips" size="5" class="red" />
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th colspan="4" class="align-right bigger-150">Tổng cộng:</th>
                                    <th><div id="total" class="red bigger-150"></div></th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var t;
    
    /*$(function(){
        $(".colorbox").colorbox({
            transition: "fade",
        })
    });*/
    $(document).on("click", ".colorbox", function(){
        if ($("#cboxLoadedContent").length==0)
        {
            //$("#cboxContent").prepend('<div id="cboxLoadedContent"></div>');
        }
        $.colorbox({
            //href: $(this).find("img").attr('src'),
            transition: "fade"
        });
        $("#cboxLoadedContent").css({
            "width": "100%",
            "height": "100%"
        });
        $("#cboxLoadedContent").html($(this).html());
        $("#cboxLoadingOverlay").remove();
        $("#cboxLoadingGraphic").remove();
        return false;
    });
    
    function getaction()
    {
        $.post(
            WEBSITE_URL_CP,
            {"components": "customeraction", "status": "1", "customeractionid": $("[name=customeractionid]").val()},
            function(data){
                if (data.list.length>0)
                {
                    $(".step-1").show();
                    $(".step-1").find(".active").removeClass("active");
                    //$(".step-2").find(".service-checked").removeClass("service-checked");
                    $(".step-4").find("tr.product").remove();
                    $(".step-4").closest(".step").hide();
                    $("[name=customeractionid]").val("");
                    listroom[data.list[0].room].used = 1;
                    total_product = 0;
                    total = 0;
                    bonus = 0;
                    $(".code-right").find("span.form-group").hide();
                    $(".code-right").find("[name=enter-code]").val("").attr("disabled", false);
                    $(".code-right").find("[name=btn-enter-code]").attr("disabled", false);
                    $(".code-right").find("#result-enter-code").html("");
                    $("[name=txt-code]").val("");
                    $("#tr-code").hide();
                    // reset form
                    window.location = WEBSITE_URL + "/client.html";
                }
                setTimeout("getaction()", 1000);
            },
            "json"
        );
    }
    function getroom()
    {
        $.get(
            WEBSITE_URL_CP,
            {"components": "room"},
            function(data){
                $.each(data.list, function(k, v){
                    listroom[v.id].used = v.used;
                })
                setTimeout("getroom()", 1000);
            },
            "json"
        );
    }
    get_services();
    getaction();
</script>