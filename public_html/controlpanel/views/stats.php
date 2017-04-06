<?php defined("WEB_APP") or die("Please wait ... <META http-equiv=\"refresh\" content=\"0; url=".WEBSITE_URL."\" />");?>
<div class="page-header"><h1>Thống kê tháng <span class="red"><?=$action;?></span></h1></div>
<div class="col-xs-12">
    <form class="form-horizontal" method="get">
        <input type="hidden" name="components" value="<?=$components;?>" />
        <div class="form-group">
            <div class="pull-left" style="padding-right: 12px;text-align: right;padding-left: 12px;">
                <label class="control-label no-padding-right">Chọn tháng:</label>
            </div>
            <div class="col-sm-4 col-xs-6">
                <div class="input-group">
                    <input type="text" data-date-format="mm-yyyy" class="form-control date-picker-month" name="action" value="<?=$action;?>" />
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
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Ngày</th>
<?php
    $tongve_tong = array();
    if (!empty($servicesgroup))
    foreach ($servicesgroup as $k => $v)
    {
        $tongve_tong[$v["id"]] = 0;
?>
                <th>Tổng vé <?=$v["title"];?></th>
<?php
    }
?>
                <th>Tổng Code</th>
                <th>Phần trăm tips</th>
                <th>Điện nước</th>
                <th>Chi tiêu</th>
            </tr>
        </thead>
        <tbody>
<?php
    $tienve_tong = 0;
    $code_tong = 0;
    $tips_tong = 0;
    $diennuoc_tong = 0;
    $chitieu_tong = 0;
    $thucthu_tong = 0;
    if (!empty($list))
    foreach ($list as $key => $row)
    {
        $tienve = sum_field($row, "tienve");
        $code = sum_field($row, "code");
        $tips = sum_field($row, "tips") * ($officeitem["truphantram"] / 100);
        $diennuoc = @array_sum(@$stats_ktv[$key]);
        $chitieu = @array_sum($tongchitieu[$key]);
        $thucthu = $tienve + $tips + $diennuoc - $chitieu;
        $tienve_tong+= $tienve;
        //$code_tong+= $code;
        $code_ngay = count($tongcode[$key])>0?count($tongcode[$key])-1:0;
        $code_tong+= $code_ngay;
        $tips_tong+= $tips;
        $diennuoc_tong+= $diennuoc;
        $chitieu_tong+= $chitieu;
        $thucthu_tong+= $thucthu;
        echo    '<tr>
                    <td>'.$row[0]["day"].'</td>';
        if (!empty($servicesgroup))
        foreach ($servicesgroup as $k => $v)
        {
            echo    '<td>'.count($tongve[$key][$v["id"]]).'</td>';
            $tongve_tong[$v["id"]]+= count($tongve[$key][$v["id"]]);
        }
                    //<td>'.number_format($tienve+$code).'</td>
                    //<td>'.number_format($code).'</td>
        echo        '<td>'.number_format($code_ngay).'</td>
                    <td>'.number_format($tips).'</td>
                    <td>'.number_format($diennuoc).'</td>
                    <td>'.number_format($chitieu).'</td>
                </tr>';
    }
?>
        </tbody>
        <tfoot>
            <tr>
                <th>Tổng cộng:</th>
<?php
    if (!empty($servicesgroup))
    foreach ($servicesgroup as $k => $v)
    {
?>
                <th><?=number_format($tongve_tong[$v["id"]]);?></th>
<?php
    }
?>
                <th><?=number_format($code_tong);?></th>
                <th><?=number_format($tips_tong);?></th>
                <th><?=number_format($diennuoc_tong);?></th>
                <th><?=number_format($chitieu_tong);?></th>
            </tr>
        </tfoot>
    </table>
</div>