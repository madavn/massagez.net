$(document).on("click", "[name=khoadatcho-btn]", function(){
    o = this;
    $(o).attr("disabled", true);
    kv = $(o).closest("#khoadatcho-form").find("[name=khoadatcho-txt]").val();
    $.post(
        WEBSITE_URL_CP,
        {"components": "khoadatcho", "password": kv},
        function(data){
            $(o).attr("disabled", false);
            if (data.error==1)
                alert(data.message);
            else
            {
                window.location = WEBSITE_URL;
            }
        },
        "json"
    );
});
$(document).on("click", "[name=btn-back]", function(){
    a = $(this).closest(".step");
    a.hide();
    a.prev().show();
    return false;
});
$(document).on("click", "[name=btn-next]", function(){
    a = $(this).closest(".step");
    a.hide();
    $(".step-4").show();
    return false;
});
$(document).on("click", "[name=btn-datcho]", function(){
    $("#myTab").find("li").removeClass("active");
    $("#myTab").find("li:eq(0)").addClass("active");
    $(".step-1").find(".servicesgroup").removeClass("active");
    $(".tab-content").find(".tab-pane").removeClass("active");
    $(".tab-content").find(".tab-pane:eq(0)").addClass("active");
    $(".tab-content").find(".tab-pane:eq(0)").find(".step").hide();
    $(".tab-content").find(".tab-pane:eq(0)").find(".step-1").show();
    $("[name=frm-thanhtoan]").find("[name=customeractionid]").val("");
    $("[name=frm-thanhtoan]").find("[name=txt-code]").val("");
});
$(document).on("click", ".servicesgroup", function(){
    groupid_truoc = $("[name=txt-servicesgroup]").val();
    groupid = $(this).attr("idsua");
    $("[name=txt-servicesgroup]").val(groupid);
    $(".step-4-servicesgroup").html(listservicesgroup[groupid].title);
    // check xem có phải đổi dịch vụ ko
    if ($("[name=customeractionid]").val()>0)
    {
        $("#services-fee").find("td:eq(2)").html(number_format(listservicesgroup[groupid].giathuong, 0, ".", ","));
        $("#services-fee").find("td:eq(4)").html(number_format(listservicesgroup[groupid].giathuong, 0, ".", ","));
        total = parseInt($("[name=txt-total]").val()) + (parseInt(listservicesgroup[groupid].giathuong) - listservicesgroup[groupid_truoc].giathuong);
        $("[name=txt-total]").val(total);
        $("#total").html(number_format(total, 0, ".", ","));
        listcustomeraction[$("[name=customeractionid]").val()].servicesgroup = groupid;
        $.each(listcustomeractiondetail[$("[name=customeractionid]").val()], function(key, row){
            listcustomeractiondetail[$("[name=customeractionid]").val()][row.id].dongia = listservicesgroup[groupid].giathuong;
            listcustomeractiondetail[$("[name=customeractionid]").val()][row.id].thanhtien = listservicesgroup[groupid].giathuong;
        });
        modal_delete("");
        // submit đặt chỗ
        $.post(
            "",
            $("[name=frm-thanhtoan]").serialize(),
            function(data){
                if (data.error==0)
                {
                    
                }
            },
            "json"
        );        
        return false;
    }
    a = $(this).closest(".step");
    a.hide();
    a.addClass("step-checked");
    //a.next().find(".services").html(str);*/
    a.find(".servicesgroup").removeClass("active");
    a.next().show();
    a.next().find(".service-button").hide();
    show_services(groupid);
    a.next().find("[name=btn-back]").show();
    a.next().find("[name=btn-next]").hide();
    //$(this).addClass("active");
    $("[name=customeractionid]").val("0");
    //$("[name=txt-servicesgroup]").val(groupid);
    //$(".step-4-servicesgroup").html(listservicesgroup[groupid].title);
    /*$.post(
        "",
        {"components": "services", "idsua": $(this).attr("idsua")},
        function(data){
            str = show_services(data.list);
            a.next().find(".services").html(str);
            a.next().css("width", "50%").show();
        },
        "json"
    );*/
    return false;
});
$(document).on("click", ".servicesgroup-code", function(){
    $(this).closest(".servicesgroup-item").find(".code-right").find("span.form-group").toggleClass("hide");
    ///$(this).closest(".servicesgroup-item").find(".code-right").find("span.form-group").css("display", "block");
    $(this).closest(".servicesgroup-item").find(".code-right").find("span.form-group").find("[name=enter-code]").focus();
});
$(document).on("keyup", "[name=enter-code]", function(e){
    if (e.which==13 || e.keyCode==13)
    {
        $("[name=btn-enter-code]").trigger("click");
        return false;
    }
});
$(document).on("click", "[name=btn-enter-code]", function(){
    o = this;
    $(o).attr("disabled", true);
    v = $(o).closest(".form-group").find("[name=enter-code]").val();
    if (v=="")
    {
        alert("Vui lòng nhập Code");
        $(o).closest(".form-group").find("[name=enter-code]").focus();
        return false;
    }
    $.post(
        WEBSITE_URL_CP,
        {"components": "voucher", "action": v},
        function(data){
            $(o).attr("disabled", false);
            p = $(o).closest(".form-group").next();
            if (data.item=="")
            {
                p.html('<i class=""></i> Code không hợp lệ');
            }
            else if (data.item.status==0)
            {
                $(o).attr("disabled", true);
                $(o).closest(".form-group").find("[name=enter-code]").attr("disabled", true);
                p.html('<i class=""></i> Hợp lệ. ' + (data.item.bonus!=0?'Giảm ' + number_format(data.item.bonus, 0, ".", ","):"Miễn phí"));
                $("[name=txt-code]").val(data.item.id);
                $("#tr-code").show();
                $("#tr-code").find("td:eq(1)").find("span").html(data.item.title);
                $("#tr-code").find("td:eq(2)").html(number_format(data.item.bonus, 0, ".", ","));
                $("#tr-code").find("td:eq(4)").html(number_format(data.item.bonus, 0, ".", ","));
                bonus = parseInt(data.item.bonus);
                total = parseInt(total) - bonus;
                $.each($(".servicesgroup"), function(a, b){
                    z = parseInt($(this).find(".a1").html());
                    z-= 100;
                    $(this).find(".a1").html(z);
                });
            }
            else
            {
                p.html('<i class=""></i> Code đã được sử dụng');
            }
        },
        "json"
    );
});
$(document).on("click", ".step-2-btn", function(){
    a = $(this).closest(".step");
    x = $(this).attr("idsua");
    
    if (parseInt($("[name=customeractionid]").val())>0) // trường hợp đổi KTV
    {
        $("#thanhtoan").find("[idsua="+$("[name=txt-room]").val()+"]").next().find("span").html(listservices[x].title);
        listcustomeraction[$("[name=customeractionid]").val()].services = x;
        $("[name=txt-services]").val(x);
        // submit đặt chỗ
        $.post(
            "",
            $("[name=frm-thanhtoan]").serialize(),
            function(data){
                if (data.error==0)
                {
                    window.location = '/';
                }
            },
            "json"
        );
        $("[name=btn-next]").trigger("click");
    }
    else
    {
        // check trường hợp 2 ktv trở lên
        if (listservicesgroup[groupid].ktv>1)
        {
            $(this).toggleClass("step-2-btn");
            $(this).toggleClass("btn-danger").toggleClass("btn-success");
            $(this).text("Đã chọn");
            if (ktv_ext.length<listservicesgroup[groupid].ktv || ktv_ext.length==undefined)
            {
                stt = ktv_ext.length==undefined?0:ktv_ext.length;
                ktv_ext[stt] = x;
                if (ktv_ext.length<listservicesgroup[groupid].ktv)
                    return false;
            }
            x = ktv_ext.shift();
            /*try {
                if (x1==undefined)
                {
                    x1 = x;
                    return false;
                }
                else
                {
                    x2 = x;
                }
            
            } catch (err) {
                x1 = x;
                return false;
            }*/
        }
        tk = $("[name=txt-tiepkhach]").val();
        $("[name=txt-services]").val(x);
        $("[name=txt-services-ext]").val(ktv_ext.join());
        $(".step-4-services").html(listservices[x].title);
        total = parseInt(total) + (tk>0?0:parseInt(listservices[x].giathuong));
        $("#services-fee").find("td:eq(2)").html(number_format(listservices[x].giathuong, 0, ".", ","));
        $("#services-fee").find("td:eq(4)").html(number_format(listservices[x].giathuong, 0, ".", ","));
        $("#services-fee").find("[name=services-fee]").val(listservices[x].giathuong);
        $("#total").html(number_format(parseInt(total) + total_product, 0, ".", ","));
        a.addClass("step-checked");
        a.find(".service").removeClass("service-checked");
        $(this).closest(".service").addClass("service-checked").insertAfter(a.find(".services").find(".service").last());
        a.hide();
        // xác định phòng và in hóa đơn luôn
        f = false;
        $.each(listroom, function(k, v){
            if (v.used=="0") //v.servicesgroup_array[groupid]!=undefined && 
            {
                f = true;
                r = v;
                return false;
            }
        });
        if (f)
        {
            $("[name=txt-room]").val(r.id);
            $(".step-4-room").html(r.title);
            d = new Date();
            $(".step-4-check-in").html(d.getHours()+"<sup>h</sup>:"+d.getMinutes()+"<sup>p</sup>");
            $("[name=txt-joindate]").val(parseInt(d.getTime()/1000));
            // submit đặt chỗ
            $.post(
                "",
                $("[name=frm-thanhtoan]").serialize(),
                function(data){
                    if (data.error==0)
                    {
                        $("[name=customeractionid]").val(Object.keys(data.customeraction)[0]);
                        $(".step-4").find(".step-4-sohd").html(Object.keys(data.customeraction)[0]);
                        a.next().next().show();
                    }
                    else
                    {
                        alert("Vui lòng chọn lại");
                        window.location = "";
                    }
                },
                "json"
            );
        }
        else
        {
            if ($(".step-3").html()!="")
            {
                a.next().show();
                alert("Vui lòng chọn phòng");
            }
        }
    }
});
$(document).on("click", "[name=btn-yeucau]", function(){
    $(this).closest(".form-group").find(".service-button").show();
});
$(document).on("click", ".step-3-btn", function(){
    if ($(this).hasClass("used"))
    {
        alert("Phòng này đang sử dụng. Vui lòng chọn phòng khác.");
        return false;
    }
    a = $(this).closest(".step");
    a.addClass("step-checked");
    a.find(".room-checked").removeClass("room-checked");
    $(this).addClass("room-checked");
    phong = $("[name=txt-room]").val();
    $("[name=txt-room]").val($(this).attr("idsua"));
    $(".step-4-room").html(listroom[$(this).attr("idsua")].title);
    a.hide();
    a.next().show();
    if (parseInt($("[name=customeractionid]").val())>0) // trường hợp đổi phòng
    {
        a.find("[idsua="+phong+"]").removeClass("used");
        $("#thanhtoan").find("[idsua="+phong+"]").removeClass("used");
        $("#thanhtoan").find("[idsua="+$(this).attr("idsua")+"]").addClass("used");
        $("#thanhtoan").find("[idsua="+$(this).attr("idsua")+"]").find(".duedate").attr("time", $("#thanhtoan").find("[idsua="+phong+"]").find(".duedate").attr("time"));
        z = $("#thanhtoan").find("[idsua="+phong+"]").next().find("span").html();
        $("#thanhtoan").find("[idsua="+phong+"]").next().find("span").html("");
        $("#thanhtoan").find("[idsua="+$(this).attr("idsua")+"]").next().find("span").html(z);
        // submit đặt chỗ
        $.post(
            "",
            $("[name=frm-thanhtoan]").serialize(),
            function(data){
                if (data.error==0)
                {
                    
                }
            },
            "json"
        );
    }
    else
    {
        a.next().find(".trove").show();
        a.next().find(".money-tips").hide();
        a.next().find("#hoanthanh").show();
        a.next().find("#invoice").show();
        d = new Date();
        $(".step-4-check-in").html(d.getHours()+"<sup>h</sup>:"+d.getMinutes()+"<sup>p</sup>");
        $("[name=txt-joindate]").val(parseInt(d.getTime()/1000));
    }
    return false;
});
$(document).on("click", "[name=btn-tiepkhach]", function(){
    o = this;
    $("#myTab").find("li").removeClass("active");
    $("#myTab").find("li:eq(0)").addClass("active");
    ox = $(o).closest(".tab-content").find(".tab-pane:eq(0)");
    $(o).closest(".tab-content").find(".tab-pane").removeClass("active");
    ox.addClass("active");
    //$(o).closest(".tab-content").find(".tab-pane:eq(0)").find(".step").hide();
    //$(o).closest(".tab-content").find(".tab-pane:eq(0)").find(".step-4").show();
    groupid = $(o).closest(".step").find("[name=tiepkhach_servicesgroup]").val();
    x = $(o).closest(".step").find("[name=tiepkhach_services]").val();
    $("[name=txt-tiepkhach]").val($(o).closest(".step").find("[name=tiepkhach]").val());
    $("[name=txt-remind]").val("1");
    ox.find(".step-1").find("[idsua="+groupid+"]").trigger("click");
    ox.find(".step-2").find(".services").find("[idsua="+x+"]").trigger("click");
    //ox.find(".step-4").show();
})
$(document).on("click", "[name=btn-tiepkhach-xacnhan]", function(){
    o = this;
    $(o).attr("disabled", true);
    v = $(o).closest(".input-group").find("[name=tiepkhach_code]").val();
    if (v=="")
    {
        alert("Vui lòng nhập Code");
        $(o).closest(".input-group").find("[name=tiepkhach_code]").focus();
        return false;
    }
    $.post(
        WEBSITE_URL_CP,
        {"components": "voucher", "action": v},
        function(data){
            $(o).attr("disabled", false);
            p = $(".tiepkhach-code-result");
            if (data.item=="")
            {
                p.html('<i class=""></i> Code không hợp lệ');
            }
            else if (data.item.status==0)
            {
                $(o).attr("disabled", true);
                $(o).closest(".input-group").find("[name=tiepkhach_code]").attr("disabled", true);
                p.html('<i class=""></i> Code hợp lệ');
                $("[name=txt-code]").val(data.item.id);
                $("#tr-code").show();
                $("#tr-code").find("td:eq(1)").find("span").html(data.item.title);
                //$("#tr-code").find("td:eq(2)").html(number_format(data.item.bonus, 0, ".", ","));
                //$("#tr-code").find("td:eq(4)").html(number_format(data.item.bonus, 0, ".", ","));
                //bonus = parseInt(data.item.bonus);
                //total = parseInt(total) - bonus;
                /*$.each($(".servicesgroup"), function(a, b){
                    z = parseInt($(this).find(".a1").html());
                    z-= 100;
                    $(this).find(".a1").html(z);
                });*/
            }
            else
            {
                p.html('<i class=""></i> Code đã được sử dụng');
            }
        },
        "json"
    );
})
$(document).on("click", ".nv", function(){
    $(this).prev().trigger("click");
})
$(document).on("click", ".btn-room-thanhtoan", function(){
    o = this;
    if (!$(o).hasClass("used"))
    {
        alert("Phòng này chưa sử dụng nên không thanh toán được. Vui lòng chọn phòng khác.");
        return false;
    }
    $("#myTab").find("li").removeClass("active");
    $("#myTab").find("li:eq(0)").addClass("active");
    $(o).closest(".tab-content").find(".tab-pane").removeClass("active");
    $(o).closest(".tab-content").find(".tab-pane:eq(0)").addClass("active");
    $("#home").find(".step").hide();
    $("#home").find(".step-4").show();
    $("#home").find(".step-4").find(".trove").hide();
    $("#home").find(".step-4").find(".money-tips").show();
    $("#home").find(".step-4").find("#hoanthanh").hide();
    $("#home").find(".step-4").find("#invoice").show();
    v = listcustomeraction[$(o).attr("customeractionid")];
    $("[name=txt-servicesgroup]").val(v.servicesgroup);
    $(".step-4-servicesgroup").html(listservicesgroup[v.servicesgroup].title);
    $("[name=txt-services]").val(v.services);
    $(".step-4-services").html(listservices[v.services].title);
    $("[name=txt-room]").val(v.room);
    $(".step-4-room").html(listroom[v.room].title);
    d = new Date(v.joindate*1000);
    $(".step-4-check-in").html(d.getHours()+"<sup>h</sup>:"+d.getMinutes()+"<sup>p</sup>");
    $("[name=txt-joindate]").val(parseInt(v.joindate));
    $("[name=customeractionid]").val(v.id);
    $(".step-4").find(".step-4-sohd").html(v.id);
    $("[name=txt-tiepkhach]").val(v.customerid);
    total = (v.customerid!=0 || v.verify_remind!=0)?v.customerid:listservicesgroup[v.servicesgroup].giathuong;
    $("[name=frm-thanhtoan]").find(".table").find("tbody").find("tr#services-fee").find("td:eq(2)").html(number_format(listservicesgroup[v.servicesgroup].giathuong, 0, ".", ","));
    $("[name=frm-thanhtoan]").find(".table").find("tbody").find("tr#services-fee").find("td:eq(4)").html(number_format(total, 0, ".", ","));
    $("[name=services-fee]").val(total);
    $("#tips-ktv1").find("span").html(listservices[v.services].title);
    if (v.services_ext!="")
    {
        services_ext = v.services_ext.split(",");
        $("[name=txt-services-ext]").val(v.services_ext);
        $.each (services_ext, function(a, b){
            $(".step-4-services").append(", " + listservices[b].title);
            if ($("#tips-ktv"+b).length==0)
            {
                str =   '<div id="tips-ktv'+b+'" class="col-xs-12 form-group">'+
                            '<span class="white pull-left" style="width: 50px;">'+listservices[b].title+'</span>'+
                            '<input type="hidden" name="money-tips-2-id[]" value="'+b+'" />'+
                            '<input type="text" name="money-tips-2[]" size="5" class="red keyup_money pull-left" />'+
                            '<p style="font-weight: bold;float: left;color: #fff;margin-left: 10px"></p>'+
                        '</div>';
                $(str).insertAfter("#tips-ktv1");
            }
        });
    }
    p = $("[name=frm-thanhtoan]").find("table").find("tbody");
    l = p.find("tr").length + 1;
    total_product = 0;
    $.each(listcustomeractiondetail[v.id], function(x, y){
        if (y.serviceid!="0")
        {
            p.append(
                '<tr class="product" id="product-'+y.serviceid+'">'+
                    '<td>'+((l<10?"0":"")+l)+'</td>'+
                    '<td>'+listproduct[y.serviceid].title+'</td>'+
                    '<td>'+number_format(listproduct[y.serviceid].dongia, 0, ".", ",")+'</td>'+
                    '<td>'+((listproduct[y.serviceid].soluong<10?"0":"")+listproduct[y.serviceid].soluong)+'</td>'+
                    '<td>'+number_format(listproduct[y.serviceid].thanhtien, 0, ".", ",")+'</td>'+
                    '<td>'+
                        '<button type="button" class="btn btn-danger btn-xs" name="delete-product">Xóa</button>'+
                        '<input type="hidden" class="productid" name="productid[]" value="'+y.serviceid+'" />'+
                        '<input type="hidden" class="dongia" name="dongia[]" value="'+listproduct[y.serviceid].dongia+'" />'+
                        '<input type="hidden" class="soluong" name="soluong[]" value="'+listproduct[y.serviceid].soluong+'" />'+
                        '<input type="hidden" class="customeractiondetail" name="customeractiondetail[]" value="'+y.id+'" />'+
                    '</td>'+
                '</tr>'
            );
            total_product+= parseInt(listproduct[y.serviceid].thanhtien);
        }
    });
    total = parseInt(total) + total_product;
    if (v.method_payment!="0")
    {
        $("[name=txt-code]").val(v.method_payment);
        $("#tr-code").show();
        $("#tr-code").find("td:eq(1)").find("span").html(v.voucher_title);
        if (v.verify_remind==0)
        {
            $("#tr-code").find("td:eq(2)").html(number_format(v.voucher_bonus, 0, ".", ","));
            $("#tr-code").find("td:eq(4)").html(number_format(v.voucher_bonus, 0, ".", ","));
            bonus = parseInt(v.voucher_bonus);
            total = parseInt(total) - bonus;
        }
        else
        {
            $("#tr-code").find("td:eq(2)").html(0);
            $("#tr-code").find("td:eq(4)").html(0);
        }
    }
    else
    {
        $("[name=txt-code]").val("");
        $("#tr-code").hide();
    }
    $("#total").html(number_format(total, 0, ".", ","));
    $("[name=txt-total]").val(total);
    /*$.each(listcustomeraction, function(k, v){
        if (v.room==$(o).attr("idsua"))
        {
            $("[name=txt-servicesgroup]").val(v.servicesgroup);
            $(".step-4-servicesgroup").html(listservicesgroup[v.servicesgroup].title);
            $("[name=txt-services]").val(v.services);
            $(".step-4-services").html(listservices[v.servicesgroup][v.services].title);
            $("[name=txt-room]").val(v.room);
            $(".step-4-room").html($(o).text());
            d = new Date(v.joindate*1000);
            $(".step-4-check-in").html(d.getHours()+"<sup>h</sup>:"+d.getMinutes()+"<sup>p</sup>");
            $("[name=txt-joindate]").val(parseInt(v.joindate));
            $.each(listcustomeractiondetail[v.id], function(x, y){
                
            })
            /*total = v.servicesgroup][v.services].giathuong;
            $("#services-fee").find("td:eq(2)").html(number_format(total, 0, ".", ","));
            $("#services-fee").find("td:eq(4)").html(number_format(total, 0, ".", ","));
            $("#services-fee").find("[name=services-fee]").val(total);
            
            $("#total").html(number_format(parseInt(total) + total_product, 0, ".", ","));*/
            /*return false;
        }
    });*/
});
$(document).on("click", "[name=add-product]", function(){
    modal_create("");
    str = create_product(listproduct);
    modal_insert("", "Thêm đồ uống", str);
});
$(document).on("click", "[name=delete-product]", function(){
    if (!confirm("Bạn có chắc là muốn xóa không?"))
        return false;
    
});
$(document).on("click", "[name=step-4-btn-hoanthanh]", function(){
    o = this;
    /*$(o).attr("disabled", true);
    $.post(
        "",
        $("[name=frm-thanhtoan]").serialize(),
        function(data){
            $(o).attr("disabled", false);
            if (data.error==0)
            {
                $("[name=customeraction]").val(data.addon.id);
                $(".step-1").show();
                $(".step-1").find(".active").removeClass("active");
                $(".step-2").find(".service-checked").remove();
                $(".step-3").find(".room-checked").next().find("span").html($(".step-4-services").html());
                $(".step-3").find(".room-checked").removeClass("room-checked").addClass("used");
                $.each($("#thanhtoan").find(".btn-room-thanhtoan"), function(k, v){
                    idsua = $(v).attr("idsua");
                    if (idsua==$("[name=frm-thanhtoan]").find("[name=txt-room]").val())
                    {
                        $(v).addClass("used");
                        return false;
                    }
                });
                $(".step-4").find("tr.product").remove();
                $(".step-4").closest(".step").hide();
                total_product = 0;
                total = 0;
            }
            if (data.message!="" && data.message!=null)
                alert(data.message);
        },
        "json"
    );*/
});
$(document).on("click", "[name=step-4-btn-thanhtoan]", function(){
    o = this;
    /*if ($("[name=money-tips]").val()=="" || $("[name=money-tips]").val()==0)
    {
        alert("Vui lòng nhập tiền tips");
        $("[name=money-tips]").focus();
        return false;
    }*/
    $(o).attr("disabled", true);
    $.post(
        WEBSITE_URL_CP + "?components=thanhtoan",
        $("[name=frm-thanhtoan]").serialize(),
        function(data){
            $(o).attr("disabled", false);
            if (data.error==0)
            {
                // in hóa đơn lần 2
                window.open(WEBSITE_URL + "/printbill2.php?idsua=" + data.invoice.id);
                // reset form
                window.location = WEBSITE_URL;
            }
        },
        "json"
    );
});
$(document).on("click", "[name=step-4-btn-change-room]", function(){
    if (parseInt($("[name=customeractionid]").val())>0)
    {
        $(this).closest(".step").hide();
        $(".step-3").show();
        $(".step-3").find("[name=btn-back]").hide();
        $(".step-3").find("[name=btn-next]").show();
    }
    else
        alert("Không đổi phòng được")
});
$(document).on("click", "[name=step-4-btn-change-servicesgroup]", function(){
    modal_create("");
    str =   '<div>Dịch vụ hiện tại: <span class="bolder red bigger-120">' +
            $(".step-4-servicesgroup").html() +
            ' - ' + listservicesgroup[$("[name=txt-servicesgroup]").val()].noidung +
            '</span></div>' +
            '<div class="form-group">Dịch vụ muốn đổi:</div><div class="step-1-change">';
    $.each(listservicesgroup, function(key, row){
        if (row.id!=$("[name=txt-servicesgroup]").val())
        {
            str+=   '<div class="servicesgroup-item col-xs-6">' +
                        '<div class="center">' +
                            '<div>' +
                                '<a class="servicesgroup" idsua="' + row.id + '" href="javascript:;">' +
                                    '<span class="a1">' + row.title + '</span>' +
                                    '<span class="a2">' + row.noidung + '</span>' +
                                '</a>' +
                            '</div>' +
                        '</div>' +
                    '</div>';
        }
    });
    str+=   '</div>';
    modal_insert("", "Đổi dịch vụ", str);
    /*if (parseInt($("[name=customeractionid]").val())>0)
    {
        $(this).closest(".step").hide();
        $(".step-1").show();
        //$(".step-3").find("[name=btn-back]").hide();
        //$(".step-3").find("[name=btn-next]").show();
    }
    else
        alert("Không đổi dịch vụ được")*/
});
$(document).on("click", "[name=step-4-btn-change-services]", function(){
    if (parseInt($("[name=customeractionid]").val())>0)
    {
        $(this).closest(".step").hide();
        $(".step-2").show();
        $(".step-2").find("[name=btn-back]").hide();
        $(".step-2").find("[name=btn-next]").show();
    }
    else
        alert("Không đổi KTV được")
});
$(document).on("click", "[name=step-4-btn-reprint]", function(){
    window.location.href=WEBSITE_URL + "/printbill.php?idsua=" + $("[name=frm-thanhtoan]").find("[name=customeractionid]").val();
});
$(document).on("click", "[name=step-4-btn-thanhtoan-huy]", function(){
    a = $(this).closest(".step");
    a.hide();
    $(".step-1").show();
    $(".step-1").find(".servicesgroup").removeClass("active");
    $("[name=frm-thanhtoan]").find("[name=customeractionid]").val("");
    $("[name=frm-thanhtoan]").find("[name=txt-code]").val("");
});
$(document).on("click", ".btn-ktv-clear", function(){
    o = this;
    $(o).attr("disabled", true);
    $.each($(o).closest(".tab-pane").find(".services").find(".service"), function(k, v){
        $(v).find(".ktv-btn-checkin").removeClass("hide");
        $(v).find(".ktv-btn-checkout").addClass("hide");
    });
    $.post(
        WEBSITE_URL_CP,
        {"components": "services", "clear": "1"},
        function(data){
            $(o).attr("disabled", false);
        },
        "json"
    );
});
$(document).on("click", ".ktv-btn-checkin", function(){
    //$(this).attr("disabled", true);
    //$(this).closest(".service").slideUp();
    $(this).closest("div").find("button").toggleClass("hide");
    $(".step-2").find("[idsua="+($(this).attr("idsua"))+"]").closest(".service").removeClass("checkin");
    $.post(
        WEBSITE_URL_CP,
        {"components": "services", "checkin": $(this).attr("idsua"), "checkout": "0"},
        function(data){
            
        },
        "json"
    );
});
$(document).on("click", ".ktv-btn-checkout", function(){
    $(".step-2").find("[idsua="+($(this).attr("idsua"))+"]").closest(".service").addClass("checkin");
    $(this).closest("div").find("button").toggleClass("hide");
    $.post(
        WEBSITE_URL_CP,
        {"components": "services", "checkin": $(this).attr("idsua"), "checkout": "1"},
        function(data){
            
        },
        "json"
    );
});
$(document).on("keyup", "[name=search-services]", function(){
    if (this.value=="")
    {
        $(this).closest(".step").find(".service").removeClass("search-services").removeClass("no-search-services");
    }
    else
    {
        va = this.value;
        $.each($(this).closest(".step").find(".services").find(".service"), function(k, v){
            x = $(this).find(".col-xs-2").html();
            if (x.indexOf(va)!=-1)
                $(this).removeClass("no-search-services").addClass("search-services");
            else
                $(this).removeClass("search-services").addClass("no-search-services");
        });
    }
});
$(document).on("focus", "[name=txt-voucher]", function(e){
    $(this).val("");
});
$(document).on("keyup", "[name=txt-voucher]", function(e){
    if (e.which==13 || e.keyCode==13)
    {
        $("[name=btn-voucher]").trigger("click");
        return false;
    }
});
$(document).on("click", "[name=btn-voucher]", function(){
    o = this;
    v = $(o).closest(".form-group").find("[name=txt-voucher]").val();
    if (v=="")
    {
        alert("Vui lòng nhập Code");
        $(o).closest(".form-group").find("[name=txt-voucher]").focus();
        return false;
    }
    $.post(
        WEBSITE_URL_CP,
        {"components": "voucher", "action": v},
        function(data){
            if (data.item=="")
            {
                str = '<tr><td>'+v+'</td>';
                //str+= '<td><input name="txt-voucher-bonus" type="text" size="10" value="100000" /></td><td></td><td></td><td></td>';
                str+= '<td><select name="txt-voucher-bonus"><option value="100000">100.000</option><option value="0">Miễn phí</option></select></td><td></td><td></td><td></td>';
                str+= '<td><button class="btn btn-success btn-xs" type="button" name="btn-voucher-add">Thêm</button></td>';
                str+= '</tr>';
                $("#result-voucher").find("tbody").prepend(str);
            }
            else
            {
                alert("Code này đã có trong hệ thống");
                /*str+=   '<td>'+number_format(data.item.bonus, 0, ".", ",")+'</td>'+
                        '<td>'+data.item.status_text+'</td>'+
                        '<td>'+ret_thoigian(data.item.joindate, "")+'</td>'+
                        '<td>'+(data.item.lastupdate>0?ret_thoigian(data.item.lastupdate, ""):"")+'</td>'+
                        '<td></td>';*/
                
            }
        },
        "json"
    );
});
$(document).on("click", "[name=btn-voucher-add]", function(){
    o = this;
    v = $("[name=txt-voucher]").val();
    bonus = $(o).closest("tr").find("[name=txt-voucher-bonus]").val();
    if (v=="")
    {
        alert("Vui lòng nhập Code");
        $(o).closest(".form-group").find("[name=txt-voucher]").focus();
        return false;
    }
    if (bonus=="")
    {
        alert("Vui lòng nhập số tiền giảm giá");
        return false;
    }
    $(o).attr("disabled", true);
    $.post(
        WEBSITE_URL_CP,
        {"components": "voucher", "type": "add", "action": v, "bonus": bonus},
        function(data){
            //$(o).closest("tr").remove();
            //$("[name=btn-voucher]").trigger("click");
            if (data.item=="")
            {
                $(o).attr("disabled", false);
                alert(data.message);
            }
            else
            {
                $(o).remove();
            }
        },
        "json"
    );
});
$(document).on("click", "[name=btn-voucher-use]", function(){
    o = this;
    $(o).attr("disabled", true);
    $.post(
        WEBSITE_URL_CP,
        {"components": "voucher", "type": "use", "action": $("[name=txt-voucher]").val()},
        function(data){
            $(o).attr("disabled", false);
            $("[name=btn-voucher]").trigger("click");
        },
        "json"
    );
});
$(document).on("click", "[name=chitieu-btn]", function(){
    o = this;
    $(o).attr("disabled", true);
    f = $(o).closest(".form-group");
    $.post(
        WEBSITE_URL_CP,
        {"components": "chitieu", "title": f.find("[name=chitieu-title]").val(), "money": f.find("[name=chitieu-money]").val(), "ghichu": f.find("[name=chitieu-ghichu]").val()},
        function(data){
            $(o).attr("disabled", false);
            str =   '<tr>'+
                        '<td>'+data.list.title+'</td>'+
                        '<td>'+number_format(data.list.money, 0, ".", ",")+'</td>'+
                        '<td>'+data.list.ghichu+'</td>'+
                        '<td>'+data.list.joindate_text+'</td>'+
                    '</tr>';
            f.next().find("tbody").prepend(str);
            f.find("[type=text]").val("");
        },
        "json"
    );
});
$(document).on("keyup", ".search-ktv", function(){
    v = $(this).val();
    if (v=="")
    {
        $(this).closest(".step").find("table").find("tbody").find("tr").removeClass("hide");
    }
    else
    {
        $.each($(this).closest(".step").find("table:eq(1)").find("tbody").find("tr"), function(){
            q = $(this).find("td:eq(0)").html();
            if (q.indexOf(v)!=-1)
            {
                $(this).removeClass("hide");
            }
            else
            {
                $(this).addClass("hide");
            }
        });
    }
});
$(document).on("click", ".editable", function(){
    o = this;
    if ($(o).hasClass("editing"))
        return;
    $(o).toggleClass("editing");
    iditem = $(o).attr("idsua");
    loai = $(o).attr("type");
    tmp_text = $(o).html();
    tmp_name = $(o).attr("fieldname");
    switch (loai) {
        case "text":
            $(o).html('<input type="'+loai+'" name="'+tmp_name+'" value="'+tmp_text+'" placeholder="Nhập nội dung" />');
            $(o).find("input").focus();
            break;
    }
    $(o).find("input[type=text]").keypress(function(e){
        if (e.keyCode==13 || e.which==13)
        {
            save_data($(this).val(), tmp_name, iditem);
            return false;
        }
        if (e.keyCode==27 || e.which==27)
        {
            $(o).html(tmp_text);
            $(o).toggleClass("editing");
        }
    });
    function save_data(data, field, iditem)
    {
        $(o).html(data);
        $(o).toggleClass("editing");
        $.post(
            "",
            {"edit": "1", "fieldname": field, "valuename": data, "idsua": iditem},
            function(data){
                
            },
            "json"
        );
    }
});
$(document).on("keyup", ".keyup_money", function(){
    v1 = 0;
    if (this.value=="" || isNaN(this.value))
        v = 0;
    else
        v = parseInt(this.value);
    $(this).next().html(number_format(v*1000, 0, ".", ","));
    if (!isNaN(v))
    {
        $.each($(".keyup_money"), function(a, b){
            if (b.value!="" && !isNaN(b.value))
                v1+= parseInt(b.value);
        });
    }
    $("#total").html(number_format(parseInt(total)+(v1*1000), 0, ".", ","));
    //name = $(this).attr("name"); 
    //$(this).parent().next().find("#span_"+name).html(number_format(this.value, 0, ".", ","));
    //$(this).parent().next().html(number_format(this.value, 0, ".", ","));
});
$(document).on("click", ".ace-switch", function(){
    o = this;
    $.post(
        "",
        {"edit": "1", "action": "switch", "idsua": o.value, "rewrite": $(o).is(":checked")},
        function(data){
            alert(data.message);
        },
        "json"
    );
});
$(document).on("click", ".ajax_add_quick", function(){
    o = this;
    modal_create("");
    $.get(
        $(o).attr("href"),
        function(data){
            title = $(data).find(".page-header").html();
            content = '<form class="position-relative form-horizontal ajax_form" method="post" name="frmedit" action="' + $(o).attr("href") + '">' + $(data).find("form").html() + "</form>";
            modal_insert("", title, content);
        },
        "html"
    )
    return false;
});
$(document).on("click", ".a_ajax", function(){
    $.get(
        $(this).attr("href"),
        function(data){
            alert(data.message);
        },
        "json"
    )
    return false;
});
$(document).on("click", ".a_ajax_modal", function(){
    $.get(
        $(this).attr("href"),
        function(data){
            alert(data.message);
        },
        "json"
    )
    return false;
});
$(document).on("click", ".ajax_delete_tr", function(){
    o = this;
    if (!$(o).attr("flag"))
        if (!confirm("Bạn có chắc là muốn xóa không?"))
            return false;
    $.get(
        $(o).attr("href"),
        function(data){
            $(o).closest("tr").remove();
        },
        "json"
    )
    return false;
});
$(document).on("click", ".ajax_view_tr", function(){
    o = this;
    modal_create("");
    $.get(
        $(o).attr("href"),
        function(data){
            content = create_cart(data.addon);
            modal_insert("", data.title, content);
        },
        "json"
    )
    return false;
});