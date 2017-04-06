<?php defined("WEB_APP") or die("Please wait ... <META http-equiv=\"refresh\" content=\"0; url=".WEBSITE_URL."\" />");?>
<div class="page-header"><h1><?=$titlecomponents;?></h1></div>
<div class="col-xs-12">
    <form class="form-horizontal ajax_form" method="post">
        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right">Nhập tên quản lý</label>
            <div class="col-sm-4 col-xs-6">
                <input type="text" class="form-control" name="title" required="required" />
            </div>
            <div class="pull-left">
                <button type="submit" class="btn btn-primary btn-sm">Thêm</button>
            </div>
        </div>
    </form>
    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>Tên quản lý</th>
            <th>Ngày nhập</th>
            <th></th>
        </tr>
        </thead>
        <tbody><?php
    if (!empty($list))
    foreach ($list as $key => $row)
    {
        $href = WEBSITE_URL_CP."?components=".$components."&amp;edit=1&amp;";
?>
            <tr>
                <td><?=$row["title"]?></td>
                <td><?=ret_thoigian($row["joindate"],"d/m/Y, H:i")?></td>
                <td><a class="ajax_delete_tr btn btn-danger btn-sm" href="<?=$href.'&amp;idxoa='.$row["id"];?>">Xóa</a></td>
            </tr> 
<?php
    }
        ?></tbody>
    </table>
    <div class="width-100">
        <?="";//ret_pages(WEBSITE_URL_CP."?components=".$components, $total, $itemshow, $pages);?>
    </div>
</div>