<?php defined("WEB_APP") or die("Please wait ... <META http-equiv=\"refresh\" content=\"0; url=".WEBSITE_URL."\" />");?>
<div class="col-xs-12">
    <h3>Thống kê <span style="color: #ff0000;"><?=ret_thoigian($start_day, "H:i, d/m/Y")." - ".ret_thoigian(BAYGIO, "H:i, d/m/Y");?></span>&nbsp; <small><a class="smaller" href="<?=WEBSITE_URL_CP;?>?components=invoice">Xem thêm</a></small></h3>
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th>Tiền vé</th>
                <th>Code</th>
                <th>Phần trăm tips</th>
                <th>Điện nước</th>
                <th>Chi tiêu</th>
                <th>Thực thu</th>
            </tr>
        </thead>
        <tbody class="bigger-150">
            <tr>
                <td><?=number_format($tongve["day"]);?></td>
                <td><?=number_format($tongcode["day"]);?></td>
                <td><?=number_format($truphantram["day"]);?></td>
                <td><?=number_format($tongdiennuoc["day"]);?></td>
                <td><?=number_format($tongchitieu["day"]);?></td>
                <td><?=number_format($tongve["day"]-$tongcode["day"]+$truphantram["day"]+$tongdiennuoc["day"]-$tongchitieu["day"]);?></td>
            </tr>
        </tbody>
    </table>
    
    <h3>Thống kê tháng <span style="color: #ff0000;"><?=date("m-Y", BAYGIO);?></span>&nbsp; <small><a class="smaller" href="<?=WEBSITE_URL_CP;?>?components=stats">Xem thêm</a></small></h3>
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th>Tiền vé</th>
                <th>Code</th>
                <th>Phần trăm tips</th>
                <th>Điện nước</th>
                <th>Chi tiêu</th>
                <th>Thực thu</th>
            </tr>
        </thead>
        <tbody class="bigger-150">
            <tr>
                <td><?=number_format($tongve["month"]);?></td>
                <td><?=number_format($tongcode["month"]);?></td>
                <td><?=number_format($truphantram["month"]);?></td>
                <td><?=number_format($tongdiennuoc["month"]);?></td>
                <td><?=number_format($tongchitieu["month"]);?></td>
                <td><?=number_format($tongve["month"]-$tongcode["month"]+$truphantram["month"]+$tongdiennuoc["month"]-$tongchitieu["month"]);?></td>
            </tr>
        </tbody>
    </table>
    
    <h3>Thống kê năm <span style="color: #ff0000;"><?=date("Y", BAYGIO);?></span></h3>
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th>Tiền vé</th>
                <th>Code</th>
                <th>Phần trăm tips</th>
                <th>Điện nước</th>
                <th>Chi tiêu</th>
                <th>Thực thu</th>
            </tr>
        </thead>
        <tbody class="bigger-150">
            <tr>
                <td><?=number_format($tongve["year"]);?></td>
                <td><?=number_format($tongcode["year"]);?></td>
                <td><?=number_format($truphantram["year"]);?></td>
                <td><?=number_format($tongdiennuoc["year"]);?></td>
                <td><?=number_format($tongchitieu["year"]);?></td>
                <td><?=number_format($tongve["year"]-$tongcode["year"]+$truphantram["year"]+$tongdiennuoc["year"]-$tongchitieu["year"]);?></td>
            </tr>
        </tbody>
    </table>
</div>