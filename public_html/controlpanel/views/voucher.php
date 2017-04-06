<?php defined("WEB_APP") or die("Please wait ... <META http-equiv=\"refresh\" content=\"0; url=".WEBSITE_URL."\" />");?>
<div class="page-header"><h1><?=$titlecomponents;?></h1></div>
<div class="col-xs-12">
    <form class="form-horizontal" method="get">
        <input type="hidden" name="components" value="<?=$components;?>" />
        <div class="form-group">
            <div class="col-sm-4 col-xs-6">
                <div class="input-group">
                    <input type="text" data-date-format="dd-mm-yyyy" class="form-control date-picker" name="action" value="<?=$action;?>" placeholder="Chọn ngày để xem chi tiết" autocomplete="off" />
                    <span class="input-group-addon"><i class="icon-calendar bigger-110"></i></span>
                </div>
            </div>
            <div class="pull-left">
                <button type="submit" class="btn btn-primary btn-sm">Xem</button>
            </div>
        </div>
    </form>
    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>Code</th>
            <th>Giảm giá</th>
            <th>Trạng thái</th>
            <th>Ngày nhập</th>
            <th>Ngày sử dụng</th>
        </tr>
        </thead>
        <tbody><?php
    if (!empty($list))
    foreach ($list as $key => $row)
    {
?>
            <tr>
                <td><?=$row["title"]?></td>
                <td><?=number_format($row["bonus"]);?></td>
                <td><?=$voucher_status_array[$row["status"]];?></td>
                <td><?=ret_thoigian($row["joindate"],"d/m/Y, H:i")?></td>
                <td><?=ret_thoigian($row["lastupdate"],"d/m/Y, H:i")?></td>
            </tr> 
<?php
    }
        ?></tbody>
    </table>
    <div class="width-100">
        <?="";//ret_pages(WEBSITE_URL_CP."?components=".$components, $total, $itemshow, $pages);?>
    </div>
</div>