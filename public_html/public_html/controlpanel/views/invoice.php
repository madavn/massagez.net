<?php defined("WEB_APP") or die("Please wait ... <META http-equiv=\"refresh\" content=\"0; url=".WEBSITE_URL."\" />");?>
<div class="page-header"><h1>Thống kê ngày <span class="red"><?=$action;?></span></h1></div>
<div class="col-xs-12">
    <form class="form-horizontal" method="get">
        <input type="hidden" name="components" value="<?=$components;?>" />
        <div class="form-group">
            <div class="pull-left" style="padding-right: 12px;text-align: right;padding-left: 12px;">
                <label class="control-label no-padding-right">Chọn ngày:</label>
            </div>
            <div class="col-sm-4 col-xs-6">
                <div class="input-group">
                    <input type="text" data-date-format="dd-mm-yyyy" class="form-control date-picker" name="action" value="<?=$action;?>" placeholder="Chọn ngày để xem chi tiết" autocomplete="off" />
                    <span class="input-group-addon"><i class="icon-calendar bigger-110"></i></span>
                </div>
            </div>
            <div class="pull-left" style="padding-right: 12px;">
                <button type="submit" class="btn btn-primary btn-sm">Xem</button>
            </div>
            <div class="pull-left">
                <a class="btn btn-success btn-sm btn-print" href="javascript:;">In/ Print</a>
            </div>
        </div>
    </form>
    <div class="form-group">
<?php
    $sort_a = WEBSITE_URL_CP."?components=".$components."&amp;action=".$action."&amp;sort=";
?>
        <div class="">Sắp xếp theo số hóa đơn: &nbsp; <a href="<?=$sort_a."id-asc";?>">Nhỏ - Lớn</a> &nbsp; &nbsp; <a href="<?=$sort_a."id-desc";?>">Lớn - Nhỏ</a></div>
    </div>
    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>Số hóa đơn</th>
            <th>Loại vé</th>
            <th>KTV</th>
            <th>Code</th>
            <th>Tiền tips</th>
            <th>Thực thu</th>
            <th>Thời gian</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
<?php
    $code = 0;
    $tips = 0;
    $tong = 0;
    if (!empty($list))
    foreach ($list as $key => $row)
    {
        $code+= $row["voucher_bonus"];
        $tips+= $row["khachtra"];
        $tong+= $row["total"];
        $href = WEBSITE_URL_CP."?components=".$components."&amp;edit=1&amp;";
?>
            <tr>
                <td><?=$row["id"]?></td>
                <td><?=$row["giave"];?></td>
                <td><?=$row["ktv"];?></td>
                <td><?=$row["voucher_title"]!=""?$row["voucher_title"]." - ".number_format($row["voucher_bonus"]):"";?></td>
                <td><?=number_format($row["khachtra"]);?></td>
                <td><?=number_format($row["total"]);?></td>
                <td><?=ret_thoigian($row["joindate"],"d/m/Y, H:i")?></td>
                <td>
                    <a class="ajax_delete_tr btn btn-danger btn-sm" href="<?=$href.'&amp;idxoa='.$row["id"];?>">Xóa</a>
                </td>
            </tr> 
<?php
    }
?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2"></th>
                <th>Tổng cộng:</th>
                <th><?=number_format($code);?></th>
                <th><?=number_format($tips);?></th>
                <th><?=number_format($tong);?></th>
                <th></th>
                <th></th>
            </tr>
        </tfoot>
    </table>
    <div class="width-100">
        <?="";//ret_pages(WEBSITE_URL_CP."?components=".$components, $total, $itemshow, $pages);?>
    </div>
</div>