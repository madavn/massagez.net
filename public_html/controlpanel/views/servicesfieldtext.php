<?php defined("WEB_APP") or die("Please wait ... <META http-equiv=\"refresh\" content=\"0; url=".WEBSITE_URL."\" />");?>
<div class="page-header"><h1><?=$titlecomponents;?></h1></div>
<?php
    if (isset($_GET["edit"]))
    {
?>
<div class="col-xs-12">
    <form class="form-horizontal ajax_form" method="post" name="frmedit">
        <div class="form-group">
			<label class="col-sm-3 control-label no-padding-right">Tiêu đề</label>
			<div class="col-sm-9">
				<input type="text" class="form-control" name="title" value="<?=$title;?>" required="required" autofocus="autofocus" />
			</div>
		</div>
        <div class="form-group">
			<label class="col-sm-3 control-label no-padding-right">Mô tả</label>
			<div class="col-sm-9">
				<input type="text" class="form-control" name="noidung" value="<?=$noidung;?>" />
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
            <th>Tiêu đề</th>
            <th>Mô tả</th>
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
                <td><a href="'.$href.'&amp;idsua='.$row["id"].'">'.$row["title"].'</a></td>
                <td>'.$row["noidung"].'</td>
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