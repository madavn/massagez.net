<?php defined("WEB_APP") or die("Please wait ... <META http-equiv=\"refresh\" content=\"0; url=".WEBSITE_URL."\" />");?>
<div class="page-header"><h1><?=$titlecomponents;?></h1></div>
<div class="col-xs-12">
    <table class="table">
        <thead>
        <tr>
            <th>Tiêu đề</th>
            <th>Nhóm</th>
            <th>Tổng lượt đi</th>
            <th>Giờ đi làm</th>
            <th>Thu nhập</th>
        </tr>
        </thead>
        <tbody><?php
    if (!empty($list))
    foreach ($list as $key => $row)
    {
        echo    '<tr>
                    <td>'.$row["title"].'</td>
                    <td>';
        $z = array();
        $z[] = $row["titlegroup"];
        if ($row["grouptext"]!="")
        {
            foreach (explode(",", $row["grouptext"]) as $x => $y)
                $z[] = $listservicesgroup[$y]["title"];
        }
        asort($z);
        echo ''.join(", ", $z);
        echo        '</td>
                    <td>'.number_format($row["used_count"]).'</td>
                    <td><a href="'.WEBSITE_URL_CP.'?components='.$components.'&amp;action=inout&amp;idsua='.$row["id"].'">Xem chi tiết</a></td>
                    <td><a href="'.WEBSITE_URL_CP.'?components='.$components.'&amp;action=thunhap&amp;idsua='.$row["id"].'">Xem chi tiết</a></td>
                </tr>';
    }
        ?></tbody>
    </table>
    <div class="width-100">
        <?="";//ret_pages(WEBSITE_URL_CP."?components=".$components, $total, $itemshow, $pages);?>
    </div>
</div>