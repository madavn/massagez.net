<?php defined("WEB_APP") or die("Please wait ... <META http-equiv=\"refresh\" content=\"0; url=".WEBSITE_URL."\" />");?>
<div class="page-header"><h1>Giờ đi làm: <?=$list[$idsua]["title"];?> <span style="color: #ff0000;">tháng <?=$gettype;?></span></h1></div>
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
            <th>Giờ vào</th>
            <th>Giờ ra</th>
        </tr>
        </thead>
        <tbody><?php
    if (!empty($a))
    foreach ($a as $key => $row)
    {
        echo    '<tr>
                    <td>'.ret_thoigian(@$row[0]["joindate"], "d-m-Y").'</td>
                    <td>'.(isset($row[1])?ret_thoigian(@$row[1]["joindate"], "H:i"):"Không có giờ").'</td>
                    <td>'.(isset($row[0])?ret_thoigian(@$row[0]["joindate"], "H:i"):"Không có giờ").'</td>
                </tr>';
    }
        ?></tbody>
    </table>
    <div class="width-100">
        <?="";//ret_pages(WEBSITE_URL_CP."?components=".$components, $total, $itemshow, $pages);?>
    </div>
</div>