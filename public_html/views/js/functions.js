function get_services()
{
    $.get(
        WEBSITE_URL_CP,
        {"components": "services"},
        function(data){
            $.each(data.list, function(k, v){
                listservices[v.id].used = v.used;
                if (v.used=="1")
                {
                    $(".step-2").find(".services").find("[idsua="+v.id+"]").closest(".service").addClass("used");
                    $(".step-2").find(".service-button").find("[idsua="+v.id+"]").closest(".service").addClass("used");
                }
                else
                {
                    $(".step-2").find(".services").find("[idsua="+v.id+"]").closest(".service").removeClass("used");
                    $(".step-2").find(".service-button").find("[idsua="+v.id+"]").closest(".service").removeClass("used");
                }
                if (v.checkin=="1")
                {
                    $(".step-2").find(".services").find("[idsua="+v.id+"]").closest(".service").removeClass("checkin");
                    $(".step-2").find(".service-button").find("[idsua="+v.id+"]").closest(".service").removeClass("checkin");
                }
                else
                {
                    $(".step-2").find(".services").find("[idsua="+v.id+"]").closest(".service").addClass("checkin");
                    $(".step-2").find(".service-button").find("[idsua="+v.id+"]").closest(".service").addClass("checkin");
                }
            })
            setTimeout("get_services()", 1000);
        },
        "json"
    );
}
function show_services(groupid)
{
    stts = 0;
    $.each($(".step-2").find(".service"), function(key, row){
        idsua = $(row).find("button").attr("idsua");
        if (!(listservices[idsua].groupid==groupid || listservices[idsua].grouptext_array[groupid]!=undefined))
            $(this).addClass("hide");
        else
        {
            $(this).removeClass("hide")
            if (!($(this).hasClass("checkin") || $(this).hasClass("used")))
            {
                $(this).removeClass("s0");
                $(this).addClass("s"+(stts%2));
                stts++;
            }
            
        }
    });
    /*str = "";
    $.each(listservices, function(key, row){
        if (row.groupid==groupid)
        {
            str+=   '<div class="service'+(row.used==1?" used":"")+(row.checkin==0?" checkin":"")+'">'+
                        '<div class="clearfix">'+
                            '<div class="col-xs-2">'+row.title+'</div>'+
                            '<div class="col-xs-7">';
            $.each(listservicesfieldtext, function(k, v){
                eval('ax = listservicesfield['+row.id+'].col_'+v.id+';');
                if (v.phanloai=="img")
                    ax = '<a class="colorbox" href="http://localhost/ace-v1.2--bs-v3.0.0/assets/images/gallery/image-2.jpg"><img src="'+ax+'" /></a>';
                str+=           '<div class="col-xs-4">'+v.title+': '+ax+' '+v.noidung+'</div>';
            });
            str+=           '</div>'+
                            //'<div class="col-xs-3">'+number_format(row.giathuong, 0, ".", ",")+'</div>'+
                            '<div class="col-xs-3"><button type="button" idsua="'+row.id+'" class="btn btn-primary step-2-btn">Chọn</button></div>'+
                        '</div>'+
                    '</div>';
        }
    });
    return str;*/
}
function create_product(list)
{
    str =   '<div class="align-right red bolder bigger-150">'+
                '<span class="total-temp">'+number_format(total_product, 0, ".", ",")+'</span> VNĐ'+
            '</div>'+
            '<div class="clearfix center">';
    $.each(list, function(k, v){
        t = $("[name=frm-thanhtoan]").find("tr#product-"+v.id).find(".soluong").val();
        if (t==undefined)
            t = 0;
        str+=   '<div class="product-item col-sm-4 col-xs-2">'+
                    '<section class="'+(t>0?"selected":"")+'">'+
                        '<div class="pointer">'+v.title+'</div>'+
                        '<div class="dongia">'+number_format(v.price, 0, ".", ",")+'</div>'+
                        '<div>'+
                            '<label onclick="soluong_plus_minus(this, listproduct, '+v.id+', \'-\')" class="badge badge-danger"><i class="fa fa-minus"></i></label>'+
                            '&nbsp;&nbsp;<input readonly="readonly" type="text" name="soluong" size="2" class="center" value="'+t+'" />&nbsp;&nbsp;'+
                            '<label onclick="soluong_plus_minus(this, listproduct, '+v.id+', \'+\')" class="badge badge-success"><i class="fa fa-plus"></i></label>'+
                        '</div>'+
                    '</section>'+
                '</div>';
    });
    str+=   '</div>';
    return str;
}
function soluong_plus_minus(o, data, id, plus_minus)
{
    soluong = parseInt($(o).closest("div").find("[name=soluong]").val()); // số lượng hiện tại
    if (soluong<1 && plus_minus=="-")
        return;
    eval("soluongsau = soluong "+plus_minus+" 1;");
    $(o).closest("div").find("[name=soluong]").val(soluongsau);
    thanhtien = (soluongsau - soluong) * parseInt(listproduct[id].price);
    total_product+= thanhtien;
    total = parseInt(total) + thanhtien;
    
    if (soluong==0 || (soluong==1 && plus_minus=="-"))
        $(o).closest("section").toggleClass("selected");
    p = $("[name=frm-thanhtoan]").find("table").find("tbody");
    q = p.find("tr#product-"+id);
    if (soluongsau>0)
    {
        if (q.length>0)
        {
            q.find("td:eq(3)").html((soluongsau<10?"0":"") + soluongsau);
            q.find("td:eq(4)").html(number_format(soluongsau*parseInt(listproduct[id].price), 0, ".", ","));
            q.find(".soluong").val(soluongsau);
            // update database
            if ($("[name=customeractionid]").val()!=0)
            {
                $.post(
                    WEBSITE_URL_CP,
                    {"components": "customeraction", "status": "-1", "customeractiondetail": q.find(".customeractiondetail").val(), "customeractionid": $("[name=customeractionid]").val(), "serviceid": listproduct[id].id, "soluong": soluongsau, "dongia": listproduct[id].price, "thanhtien": thanhtien},
                    function(data){
                        
                    },
                    "json"
                )
            }
        }
        else
        {
            l = p.find("tr").length + 1;
            p.append(
                '<tr class="product" id="product-'+id+'">'+
                    '<td>'+((l<10?"0":"")+l)+'</td>'+
                    '<td>'+listproduct[id].title+'</td>'+
                    '<td>'+number_format(listproduct[id].price, 0, ".", ",")+'</td>'+
                    '<td>'+((soluongsau<10?"0":"")+soluongsau)+'</td>'+
                    '<td>'+number_format(thanhtien, 0, ".", ",")+'</td>'+
                    '<td>'+
                        '<button type="button" class="btn btn-danger btn-xs" name="delete-product">Xóa</button>'+
                        '<input type="hidden" class="productid" name="productid[]" value="'+id+'" />'+
                        '<input type="hidden" class="dongia" name="dongia[]" value="'+listproduct[id].price+'" />'+
                        '<input type="hidden" class="soluong" name="soluong[]" value="'+soluongsau+'" />'+
                        '<input type="hidden" class="customeractiondetail" name="customeractiondetail[]" />'+
                    '</td>'+
                '</tr>'
            );
            // insert database
            if ($("[name=customeractionid]").val()!=0)
            {
                $.post(
                    WEBSITE_URL_CP,
                    {"components": "customeraction", "status": "-1", "customeractiondetail": 0, "customeractionid": $("[name=customeractionid]").val(), "serviceid": listproduct[id].id, "soluong": soluongsau, "dongia": listproduct[id].price, "thanhtien": thanhtien},
                    function(data){
                        p.find("tr#product-"+id).find(".customeractiondetail").val(data.list[0]);
                    },
                    "json"
                )
            }
        }
    }
    else
    {
        q.remove();
    }
    $(".total-temp").html(number_format(total_product, 0, ".", ","));
    $("#total").html(number_format(total, 0, ".", ","));
}
function modal_create(modal_id)
{
    modal_delete(modal_id);
    str = '<div id="myModal_'+modal_id+'" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" tabindex="-1"><div class="modal-dialog"><div class="modal-content">';
    str+= '<div class="modal-header">';
    str+= '<h4 class="modal-title"></h4>';
    str+= '</div>';
    str+= '<div class="modal-body clearfix">';
    str+= '</div>';
    str+= '<div class="modal-footer"><button class="btn" data-dismiss="modal" aria-hidden="true">Đóng</button></div>';
    $('body').append(str);
    $("#myModal_"+modal_id).modal();
}
function modal_insert(modal_id, title, content)
{
    $("#myModal_"+modal_id).find(".modal-header").find("h4").html(title);
    $("#myModal_"+modal_id).find(".modal-body").html(content);
}
function modal_delete(modal_id)
{
    if ($("#myModal_"+modal_id).length>0)
    {
        $("#myModal_"+modal_id).find("button.close").trigger("click");
        $("#myModal_"+modal_id).remove();
        $(".modal-backdrop").remove();
    }
}
function select_duyet(o)
{
    $.post(
        "",
        {"edit": 1, "idsua": $(o).attr("idsua"), "fieldname": $(o).attr("name"), "valuename": $(o).val()},
        function(data){
            
        },
        "json"
    );
}
function change_select(o)
{
    $.post(
        "",
        {"idsua": $(o).attr("idsua"), "fieldname": $(o).attr("fieldname"), "valuename": $(o).val()},
        function(data){
            
        },
        "json"
    );
}
function deleteall(o, flag)
{
    if (flag)
    {
        if (!confirm("Bạn có chắc là muốn xóa không?"))
            return false;
        $(o).attr("disabled", true);
    }
    a = $(".table").find("tbody").find("[type=checkbox]:checked").first();
    if (a.length>0)
    {
        a.prop("checked", false);
        $.get(
            a.closest("tr").find(".ajax_delete_tr").attr("href"),
            function(data){
                a.closest("tr").remove();
                deleteall(o, false);
            },
            "json"
        )
    }
    else
    {
        $(o).attr("disabled", false);
        $(".table").find("[name=checkall]").prop("checked", false);
        alert("Đã xóa xong.");
    }
    /*
    t = $(".table").find("tbody").find("tr").length();
    /*$.each($(".table").find("tbody").find("tr"), function(index, value){
        if ($(this).find("[type=checkbox]").is(":checked"))
        {
            iii+;
            $(this).find(".ajax_delete_tr").attr("flag", "1"); //.trigger("click");
            /*
            return false;
        }
    });*/
    return false;
}
function create_editor(o)
{
    $(function(){
        $(o).ace_wysiwyg().prev().addClass('wysiwyg-style1');
    });
}
function upload_html_2(o, url)
{
    var attach;
    var size;
    $(o).html5Uploader({
        name: "Filedata",
		postUrl: url,
        onClientLoad:function(e, file){
            attach = e.target.result;
            size = file.size;
        },
        onSuccess: function(e, file, response){
            $(o).next().find("img").attr("src", attach);
        }
	});
}
function excel_form_contact()
{
    str = '<h4>Dữ liệu mẫu từ file Excel</h4>';
    str+= '<table class="table">';
    str+= '<thead>';
    str+= '<tr>';
    str+= '<th>Họ và tên</th>';
    str+= '<th>Số điện thoại</th>';
    str+= '<th>Email</th>';
    str+= '<th>Địa chỉ</th>';
    str+= '</tr>';
    str+= '</thead>';
    str+= '<tbody>';
    str+= '</tbody>';
    str+= '</table>';
    str+= '<div class="width-100">';
    str+= '<button class="btn btn-primary" type="submit">Lưu lại</button>';
    str+= '</div>';
    return str;
}
function upload_excel()
{
    $("#myModal_").find(".modal-body").find("input[type=file]").html5Uploader({
        name: "FiledataExcel",
		postUrl: window.location + "&edit=1",
        onSuccess: function(e, file, data){
            data = $.parseJSON(data);
            $.each(data.addon, function(index, value){
                str = '<tr>';
                str+= '<td>'+value[0]+'</td>';
                str+= '<td>'+value[1]+'</td>';
                str+= '<td>'+value[2]+'</td>';
                str+= '<td>'+value[3]+'</td>';
                str+= '</tr>';
                $("#myModal_").find(".modal-body").find('tbody').append(str);
            });
        }
    });
}
function jqGrid_update()
{
    jQuery(grid_selector).jqGrid('clearGridData').jqGrid('setGridParam', {data: grid_data, datatype: "local"}).trigger("reloadGrid");
}
function ret_thoigian(timedate, typedate)
{
    a = new Date();
    b = new Date(timedate*1000);
    baygio = a.getTime();
    strreturn = "";
    switch(typedate){
        default:
            if ((remain=baygio-timedate)>=86400)
                strreturn = (b.getDate()<10?"0":"") + b.getDate() + "-" + (b.getMonth()<9?0:"") + (b.getMonth()+1) + "-" + b.getFullYear();
            else
            {
                if (remain>=3600)
                    strreturn = parseInt(remain/3600) + " giờ trước";
                else if (remain>=60)
                    strreturn = parseInt(remain/60) + " phút trước";
                else
                    strreturn = remain > 0 ? remain + " giây trước" : "Vừa mới xong";
            }
            break;  
    };
    return strreturn;
}
function number_format(number, decimals, dec_point, thousands_sep)
{
    // Formats a number with grouped thousands
    //
    // version: 906.1806
    // discuss at: http://phpjs.org/functions/number_format
    // +   original by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +     bugfix by: Michael White (http://getsprink.com)
    // +     bugfix by: Benjamin Lupton
    // +     bugfix by: Allan Jensen (http://www.winternet.no)
    // +    revised by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
    // +     bugfix by: Howard Yeend
    // +    revised by: Luke Smith (http://lucassmith.name)
    // +     bugfix by: Diogo Resende
    // +     bugfix by: Rival
    // +     input by: Kheang Hok Chin (http://www.distantia.ca/)
    // +     improved by: davook
    // +     improved by: Brett Zamir (http://brett-zamir.me)
    // +     input by: Jay Klehr
    // +     improved by: Brett Zamir (http://brett-zamir.me)
    // +     input by: Amir Habibi (http://www.residence-mixte.com/)
    // +     bugfix by: Brett Zamir (http://brett-zamir.me)
    // *     example 1: number_format(1234.56);
    // *     returns 1: '1,235'
    // *     example 2: number_format(1234.56, 2, ',', ' ');
    // *     returns 2: '1 234,56'
    // *     example 3: number_format(1234.5678, 2, '.', '');
    // *     returns 3: '1234.57'
    // *     example 4: number_format(67, 2, ',', '.');
    // *     returns 4: '67,00'
    // *     example 5: number_format(1000);
    // *     returns 5: '1,000'
    // *     example 6: number_format(67.311, 2);
    // *     returns 6: '67.31'
    // *     example 7: number_format(1000.55, 1);
    // *     returns 7: '1,000.6'
    // *     example 8: number_format(67000, 5, ',', '.');
    // *     returns 8: '67.000,00000'
    // *     example 9: number_format(0.9, 0);
    // *     returns 9: '1'
    // *     example 10: number_format('1.20', 2);
    // *     returns 10: '1.20'
    // *     example 11: number_format('1.20', 4);
    // *     returns 11: '1.2000'
    // *     example 12: number_format('1.2000', 3);
    // *     returns 12: '1.200'
    var n = number, prec = decimals;
    
    var toFixedFix = function (n,prec) {
        var k = Math.pow(10,prec);
        return (Math.round(n*k)/k).toString();
    };
    
    n = !isFinite(+n) ? 0 : +n;
    prec = !isFinite(+prec) ? 0 : Math.abs(prec);
    var sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep;
    var dec = (typeof dec_point === 'undefined') ? '.' : dec_point;
    
    var s = (prec > 0) ? toFixedFix(n, prec) : toFixedFix(Math.round(n), prec); //fix for IE parseFloat(0.55).toFixed(0) = 0;
    
    var abs = toFixedFix(Math.abs(n), prec);
    var _, i;
    
    if (abs >= 1000) {
        _ = abs.split(/\D/);
        i = _[0].length % 3 || 3;
    
        _[0] = s.slice(0,i + (n < 0)) +
              _[0].slice(i).replace(/(\d{3})/g, sep+'$1');
        s = _.join(dec);
    } else {
        s = s.replace('.', dec);
    }
    
    var decPos = s.indexOf(dec);
    if (prec >= 1 && decPos !== -1 && (s.length-decPos-1) < prec) {
        s += new Array(prec-(s.length-decPos-1)).join(0)+'0';
    }
    else if (prec >= 1 && decPos === -1) {
        s += dec+new Array(prec).join(0)+'0';
    }
    return s;
}