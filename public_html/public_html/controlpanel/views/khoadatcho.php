<?php defined("WEB_APP") or die("Please wait ... <META http-equiv=\"refresh\" content=\"0; url=".WEBSITE_URL."\" />");?>
<div class="page-header"><h1><?=$titlecomponents;?></h1></div>
<div class="col-xs-12">
    <form class="form-horizontal ajax_form" method="post" name="frmedit">
        <div class="form-group">
			<label class="col-sm-3 control-label no-padding-right">&nbsp;</label>
			<div class="col-sm-9">
				<div class="radio">
					<label>
						<input type="radio" class="ace" name="yesno" value="1"<?=@$item["yesno"]?' checked="checked"':'';?> />
						<span class="lbl"> Khóa</span>
					</label>
				</div>
                <div class="radio">
					<label>
						<input type="radio" class="ace" name="yesno" value="0"<?=@$item["yesno"]?'':' checked="checked"';?> />
						<span class="lbl"> Mở</span>
					</label>
				</div>
			</div>
		</div>
        <div class="form-group hide">
			<label class="col-sm-3 control-label no-padding-right">Mật khẩu để mở khóa đặt chỗ</label>
			<div class="col-sm-9">
				<input type="text" name="password" value="<?=@$item["password"];?>" />
			</div>
		</div>
        <div class="form-group">
			<div class="col-sm-offset-3 col-sm-5">
				<input type="submit" class="btn btn-primary" value="Đồng ý" name="btnsubmit" />
			</div>
		</div>
    </form>
</div>