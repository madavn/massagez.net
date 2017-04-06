<?php defined("WEB_APP") or die("Please wait ... <META http-equiv=\"refresh\" content=\"0; url=".WEBSITE_URL."\" />");?>
<div class="page-header"><h1><?=$titlecomponents;?></h1></div>
<?php
    if (isset($_GET["edit"]))
    {
?>
<div class="col-xs-12">
    <form class="form-horizontal ajax_form" method="post" name="frmedit">
        <div class="form-group hide">
			<label class="col-sm-3 control-label no-padding-right">Thứ tự</label>
			<div class="col-sm-9">
				<input type="number" class="form-control" name="thutu" value="<?=$thutu;?>" />
			</div>
		</div>
        <div class="form-group">
			<label class="col-sm-3 control-label no-padding-right">Nhóm</label>
			<div class="col-sm-9">
				<select class="form-control" name="groupid"><?=ret_option_filter($listgroup, "title", $groupid);?></select>
			</div>
		</div>
        <div class="form-group">
			<label class="col-sm-3 control-label no-padding-right">Nhóm thêm</label>
			<div class="col-sm-9">
				<select class="select2 width-100" name="grouptext[]" multiple="multiple"><?=ret_option_filter_multi($listgroup, "title", $grouptext);?></select>
			</div>
		</div>
        <div class="form-group">
			<label class="col-sm-3 control-label no-padding-right">Mã KTV</label>
			<div class="col-sm-9">
				<input type="text" class="form-control" name="title" value="<?=$title;?>" required="required" autofocus="autofocus" />
			</div>
		</div>
<?php
    if (!empty($listservicesfieldtext))
    foreach ($listservicesfieldtext as $key => $row)
    {
?>
        <div class="form-group">
			<label class="col-sm-3 control-label no-padding-right"><?=$row["title"];?></label>
			<div class="col-sm-9">
<?php
        if ($row["phanloai"]=="img")
        {
?>
            <input style="float: left;margin-right:20px;width: 80px;" type="file" accept="image/*" />
            <div style="float: left;"><img style="width: 70px;height: 80px;" src="<?=@$listservicesfield[$idsua]["col_".$row["id"]];?>" /></div>
            <input type="hidden" name="col[<?=$row["id"];?>]" value="<?=@$listservicesfield[$idsua]["col_".$row["id"]];?>" />
<?php
        }
        else
        {
?>
				<input type="text" class="form-control" name="col[<?=$row["id"];?>]" value="<?=@$listservicesfield[$idsua]["col_".$row["id"]];?>" />
<?php
        }
?>
			</div>
		</div>
<?php
    }
?>
        <div class="form-group">
			<div class="col-sm-offset-3 col-sm-5">
				<input type="submit" class="btn btn-primary" value="Đồng ý" name="btnsubmit" />
                <input class="btn btn-danger" type="button" value="Trở về" onclick="window.location='<?=WEBSITE_URL_CP;?>?components=<?=$components;?>'" />
			</div>
		</div>
    </form>
</div>
<script>
    $("[type=file]").html5Uploader({
        name: name,
        postUrl: "",
        onClientLoad: function(e, file){
            $("[type=file]").next().find("img").attr("src", e.target.result);
            $("[type=file]").next().next().val(e.target.result);
        }
    });
</script>
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
            <th>Nhóm</th>
            <th>Số lần được chọn</th>
<?php
    if (!empty($listservicesfieldtext))
    foreach ($listservicesfieldtext as $key => $row)
    {
?>
            <th><?=$row["title"];?></th>
<?php
    }
?>
            <th>Giá (VNĐ)</th>
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
                <td>';
        echo $row["titlegroup"];
        if ($row["grouptext"]!="")
        {
            $z = array();
            foreach (explode(",", $row["grouptext"]) as $x => $y)
                $z[] = $listservicesgroup[$y]["title"];
            echo '<br />'.join(", ", $z);
        }
        echo '</td>
                <td>'.number_format($row["used_count"]).'</td>';
        if (!empty($listservicesfieldtext))
        foreach ($listservicesfieldtext as $k => $r)
        {
            $ax = $listservicesfield[$row["id"]]["col_".$r["id"]];
            if ($r["phanloai"]=="img")
                $ax = '<img style="width: 70px;height:80px;" src="'.$ax.'" />';
            echo '<td>'.$ax.'</td>';
        }
        echo ' <td>'.number_format($row["giathuong"]).'</td>
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