<?php defined("WEB_APP") or die("Please wait ... <META http-equiv=\"refresh\" content=\"0; url=".WEBSITE_URL."\" />");?>
<div class="page-header"><h1>Thu nhập: <?=$list[$idsua]["title"];?> <span style="color: #ff0000;">tháng <?=$gettype;?></span></h1></div>
<div class="col-xs-12">
    <form class="form-horizontal" method="get">
        <input type="hidden" name="components" value="<?=$_GET["components"];?>" />
        <input type="hidden" name="action" value="<?=$action;?>" />
        <input type="hidden" name="idsua" value="<?=$idsua;?>" />
        <div class="form-group">
            <div class="pull-left" style="padding-right: 12px;text-align: right;padding-left: 12px;">
                <label class="control-label no-padding-right">Chọn tháng:</label>
            </div>
            <div class="col-sm-4 col-xs-6">
                <div class="input-group">
                    <input type="text" data-date-format="mm-yyyy" class="form-control date-picker-month" name="type" value="<?=$gettype;?>" />
                    <span class="input-group-addon"><i class="icon-calendar bigger-110"></i></span>
                </div>
            </div>
            <div class="pull-left" style="padding-right: 12px;">
                <button type="submit" class="btn btn-primary btn-sm">Xem</button>
            </div>
        </div>
    </form>
    <table class="table">
        <thead>
        <tr>
            <th>Ngày</th>
            <th>Số lượt</th>
            <th>Tiền tips</th>
            <th>Trừ phần trăm</th>
            <th>Trừ điện nước</th>
            <th>Thực lãnh</th>
        </tr>
        </thead>
        <tbody>
<?php
    $tips_tong = 0;
    $truphantram_tong = 0;
    $diennuoc_tong = 0;
    $thucthu_tong = 0;
    $soluot = 0;
    if (!empty($a))
    foreach ($a as $key => $row)
    {
        $tips = sum_field($row, "khachtra");
        $truphantram = $tips * ($officeitem["truphantram"] / 100);
        $diennuoc = $officeitem["diennuoc"];
        $thucthu = $tips - $truphantram - $diennuoc;
        
        $tips_tong+= $tips;
        $truphantram_tong+= $truphantram;
        $diennuoc_tong+= $diennuoc;
        $thucthu_tong+= $thucthu;
        $soluot+= count($row);
        echo    '<tr>
                    <td>'.ret_thoigian(@$row[0]["joindate"], "d-m-Y").'</td>
                    <td>'.count($row).'</td>
                    <td>'.number_format($tips).'</td>
                    <td>'.number_format($truphantram).'</td>
                    <td>'.number_format($diennuoc).'</td>
                    <td>'.number_format($thucthu).'</td>
                </tr>';
    }
?>
        </tbody>
        <tfoot>
            <tr>
                <th>Tổng cộng:</th>
                <th><?=number_format($soluot);?></th>
                <th><?=number_format($tips_tong);?></th>
                <th><?=number_format($truphantram_tong);?></th>
                <th><?=number_format($diennuoc_tong);?></th>
                <th><?=number_format($thucthu_tong);?></th>
            </tr>
        </tfoot>
    </table>
    <div class="width-100">
        <?="";//ret_pages(WEBSITE_URL_CP."?components=".$components, $total, $itemshow, $pages);?>
    </div>
</div>