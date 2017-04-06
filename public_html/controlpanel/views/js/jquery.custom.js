$(function(){
    $(".select2").select2();
    
    $("[name=checkall]").click(function(){
        c = $(this).is(":checked");
        $(this).closest(".table").find("tbody").find("tr").find("[type=checkbox]").prop("checked", c);
    });
    
    $('.date-picker').datepicker({autoclose: true}).next().on(ace.click_event, function(){
		$(this).prev().focus();
	});
    
    $('.date-picker-month').datepicker({autoclose: true, changeMonth: true, changeYear: true,});
});
$(document).on("click", ".btn-print", function(){
    w = window.open();
    w.document.write('<style>body{font-family:arial;}table{border-collapse:collapse}td,th{border:1px solid #ddd;line-height:1.42857;padding:8px;}table thead tr{background:#f2f2f2 linear-gradient(to bottom, #f8f8f8 0px, #ececec 100%)}@media print{.btn-danger{display:none}}</style>');
    w.document.write('<h2 style="text-align:center;margin:0;">'+windowtitle+'</h2>');
    w.document.write('<h4 style="text-align:center;font-weight:bold;">'+$(".page-header h1").html()+'</h4>');
    w.document.write('<table style="width:100%;padding:0;text-align:center;">');
    w.document.write($(this).closest("form").closest("div").find("table").html());
    w.document.write('<table>');
    w.print();
    w.close();
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
    name = $(this).attr("name"); 
    $(this).parent().next().find("#span_"+name).html(number_format(this.value, 0, ".", ","));
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
$(document).on("click", ".add-excel", function(){
    o = this;
    modal_create("");
    modal_insert("", "Thêm từ file Excel", "");
    a = $("#myModal_").find(".modal-body");
    a.append('<form method="post" enctype="multipart/form-data" class="jqueryform" action="'+window.location+'&amp;edit=1"><input type="file" name="excel" />'+excel_form_contact()+'</form>');
    upload_excel();
    return false;
});
$(document).on("submit", "form.ajax_form", function(){
    o = this;
    $(o).find("[type=submit]").attr("disabled", true);
    $.post(
        $(o).attr("action")!=""?$(o).attr("action"):"",
        $(o).serialize(),
        function(data){
            $(o).find("[type=submit]").attr("disabled", false);
            if (data.error==0)
                window.location = data.redirect;
            else
                alert(data.message)
        },
        "json"
    );
    return false;
});
$(document).on("submit", "form.ajax_form_wysiwyg", function(){
    f = true;
    o = this;
    $(o).find(".wysiwyg-editor").each(function(key, value){
        id = $(this).attr("id");
        //$("[name="+id+"]").val($(this).html());
        $(this).next().val($(this).html());
    });
    $(o).find("[required=required]").each(function(key, value){
        if ($(this).val()=="")
        {
            m = $(this).attr("placeholder");
            if (m!="")
            {
                alert(m);
                f = false;
            }
        }
    });
    return f;
});
$(document).on("submit", "form.ajax_form_wysiwyg_false", function(){
    o = this;
    $(o).find(".wysiwyg-editor").each(function(key, value){
        id = $(this).attr("id");
        //$("[name="+id+"]").val($(this).html());
        $(this).next().val($(this).html());
    });
    $.post(
        "",
        $(o).serialize(),
        function(data){
            $(window).scrollTop(0);
            alert("Lưu dữ liệu thành công");
        },
        "json"
    );
    return false;
});