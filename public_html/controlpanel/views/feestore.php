<?php defined("WEB_APP") or die("Please wait ... <META http-equiv=\"refresh\" content=\"0; url=".WEBSITE_URL."\" />");?>
<div class="page-header"><h1><?=$titlecomponents;?></h1></div>
<?php
    if (isset($_GET["edit"]))
    {
?>
<div class="col-xs-12">
    <form class="form-horizontal ajax_form" method="post" name="frmedit">
        <div class="form-group">
			<label class="col-sm-3 control-label no-padding-right">Tên</label>
			<div class="col-sm-9">
				<div id="addfeesinput" class="hide"><input type="text" name="feetitle" class="form-control" /></div>
                <div id="selectfees"><select class="" name="feeid"><?=ret_option_filter($listfee, "title", $feeid);?></select> <a href="javascript:;" onclick="$('#addfeesinput').removeClass('hide');$('#selectfees').addClass('hide');">Thêm tên phí mới</a></div>
			</div>
		</div>
        <div class="form-group">
			<label class="col-sm-3 control-label no-padding-right">Giá tiền</label>
			<div class="col-sm-9">
				<input type="number" class="form-control" name="thanhtien" value="<?=$thanhtien;?>" />
			</div>
		</div>
        <div class="form-group">
			<label class="col-sm-3 control-label no-padding-right">Ghi chú</label>
			<div class="col-sm-9">
				<textarea class="form-control" name="ghichu"><?=$ghichu;?></textarea>
			</div>
		</div>
        <div class="form-group">
			<div class="col-sm-offset-3 col-sm-5">
				<input type="submit" class="btn btn-primary" value="Đồng ý" name="btnsubmit" />
                <input class="btn btn-danger" type="button" value="Trở về" onclick="window.location='<?=WEBSITE_URL_CP;?>?components=<?=$components;?>'" />
			</div>
		</div>
    </form>
</div>
<?php
    }
    else
    {
?>
<div class="col-xs-12">
    <div>
        <a class="btn btn-primary" href="<?=WEBSITE_URL_CP;?>?components=<?=$components;?>&amp;edit=1">Thêm mới</a>
        <a class="btn btn-danger" onclick="deleteall(this, 1)" href="javascript:;">Xóa</a>
    </div>
    <div class="space-6"></div>
    <table class="table">
        <thead>
        <tr>
            <th><input type="checkbox" name="checkall" /></th>
            <th>Tên phí</th>
            <th>Thành tiền</th>
            <th>Ghi chú</th>
            <th>Ngày nhập</th>
            <th></th>
        </tr>
        </thead>
        <tbody><?php
    if (!empty($list))
    foreach ($list as $key => $row)
    {
        $href = WEBSITE_URL_CP."?components=".$components."&amp;edit=1&amp;";
        echo '<tr>
                <td><input type="checkbox" name="checkbox[]" value="'.$row["id"].'" /></td>
                <td>'.$row["title"].'</td>
                <td>'.number_format($row["thanhtien"]).'</td>
                <td>'.$row["ghichu"].'</td>
                <td>'.ret_thoigian($row["joindate"],"d/m/Y").'</td>
                <td>
                    <a href="'.$href.'&amp;idsua='.$row["id"].'"><i class="fa fa-pencil bigger-130"></i></a>
                    &nbsp;&nbsp;&nbsp;
                    <a class="ajax_delete_tr" href="'.$href.'&amp;idxoa='.$row["id"].'"><i class="fa fa-trash bigger-130 red"></i></a>
                </td>
            </tr>';
    }
        ?></tbody>
    </table>
    <div class="width-100">
        <?="";//ret_pages(WEBSITE_URL_CP."?components=".$components, $total, $itemshow, $pages);?>
    </div>
</div>
<?php }?>