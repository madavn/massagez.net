<?php defined("WEB_APP") or die("Please wait ... <META http-equiv=\"refresh\" content=\"0; url=".WEBSITE_URL."\" />");?>
<div class="page-header"><h1><?=$titlecomponents;?></h1></div>
<div class="col-xs-12">
    <form class="form-horizontal ajax_form" method="post" name="frmedit">
<?php
    if (isset($_GET["edit"]))
    {
?>
        <div class="clearfix">
			<label class="col-sm-3 control-label no-padding-right">&nbsp;</label>
			<div class="col-sm-9">
				<div class="alert alert-success pull-left">
					<i class="icon-ok"></i> Đổi mật khẩu thành công.
				</div>
			</div>
		</div>
<?php
    }
?>
        <div class="form-group">
			<label class="col-sm-3 control-label no-padding-right">Tên đăng nhập</label>
			<div class="col-sm-9">
				<input type="text" class="form-control" value="<?=$userlogin["username"];?>" disabled="disabled" />
			</div>
		</div>
        <div class="form-group">
			<label class="col-sm-3 control-label no-padding-right">Mật khẩu cũ</label>
			<div class="col-sm-9">
				<input type="password" class="form-control" name="oldpassword" required="required" />
			</div>
		</div>
        <div class="form-group">
			<label class="col-sm-3 control-label no-padding-right">Mật khẩu mới</label>
			<div class="col-sm-9">
				<input type="password" class="form-control" name="newpassword" required="required" />
			</div>
		</div>
        <div class="form-group">
			<div class="col-sm-offset-3 col-sm-5">
				<input type="submit" class="btn btn-primary" value="Đồng ý" name="btnsubmit" />
                <input class="btn btn-danger" type="button" value="Trở về" onclick="window.location='<?=WEBSITE_URL_CP;?>'" />
			</div>
		</div>
    </form>
</div>