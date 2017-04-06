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
function create_cart(data)
{
    i = 0;
    tong = 0;
    str = '<table class="table">';
    str+= '<thead>';
    str+= '<tr>';
    str+= '<th>STT</th>';
    str+= '<th>Tên sản phẩm</th>';
    str+= '<th>Hình ảnh</th>';
    str+= '<th>Đơn giá</th>';
    str+= '<th>Số lượng</th>';
    str+= '<th>Thành tiền</th>';
    str+= '</tr>';
    str+= '</thead>';
    str+= '<tbody>';
    $.each(data, function(index, value){
        str+= '<tr>';
        str+= '<td>'+(++i)+'</td>';
        str+= '<td>'+value.tieude+'</td>';
        str+= '<td><img width="50px" height="50px" src="'+value.hinhanh+'" /></td>';
        str+= '<td>'+number_format(value.price, 0, ".", ",")+'</td>';
        str+= '<td>'+number_format(value.soluong, 0, ".", ",")+'</td>';
        str+= '<td>'+number_format(value.thanhtien, 0, ".", ",")+'</td>';
        str+= '</tr>';
        tong+= parseFloat(value.thanhtien);
    });
    str+= '</tbody>';
    str+= '<tfoot>';
    str+= '<tr>';
    str+= '<td colspan="5" align="right">Tổng cộng:</td>';
    str+= '<td><span class="red">'+number_format(tong, 0, ".", ",")+'</span></td>';
    str+= '</tr>';
    str+= '</tfoot>';
    str+= '</table>';
    str+= '<div class="pull-right">';
    str+= '<a class="btn btn-primary" href="'+WEBSITE_URL+'/thanh-toan.html">Thanh toán</a>';
    str+= '</div>';
    return str;
}
function dutinhchiphisms(f)
{
    $.post(
        window.location + "&action=dutinhchiphisms",
        $(f).serialize(),
        function(data){
            $(f).find("#dutinhchiphisms").html(number_format(data.addon, 0, ".", ","));
        },
        "json"
    );
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
                strreturn = b.getDate() + "-" + b.getMonth() + "-" + b.getFullYear();
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