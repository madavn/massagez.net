<!DOCTYPE html>
<html lang="vi-VN">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <!--[if gt IE 8]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <![endif]-->
    <title>Phần mềm quản lý</title>
    <style>
        body {
            font-family: tahoma !important;
            background: url("http://diendanmassagez.com/styles/massage/background.jpg") no-repeat fixed;
        }
    </style>
</head>
<body class="login-layout">
<script src="<?=VIEWS_FOLDER;?>js/jquery-1.10.2.min.js" type="text/javascript"></script>

<link href="<?=VIEWS_FOLDER;?>css/bootstrap.min.css" media="screen" rel="stylesheet" type="text/css" />
<link href="<?=VIEWS_FOLDER;?>css/font-awesome.min.css" media="screen" rel="stylesheet" type="text/css" />
<link href="<?=VIEWS_FOLDER;?>css/ace.min.css" media="screen" rel="stylesheet" type="text/css" />
<div class="main-container">
	<div class="main-content">
		<div class="row">
			<div class="col-sm-10 col-sm-offset-1">
				<div class="login-container">
					<div class="center">
                        <a target="_blank" href="http://louis-intelli.com">
                            
                        </a>
					</div>
					<div class="position-relative">
						<div id="login-box" class="login-box visible widget-box no-border">
							<div class="widget-body">
								<div class="widget-main">
									<h4 class="header blue lighter bigger">
										<i class="icon-coffee green"></i>
										Nhập tên và mật khẩu vào ô bên dưới 
									</h4>
									<div class="space-6"></div>
									<form name="frm-login" method="post">
										<fieldset>
											<label class="block clearfix">
												<span class="block input-icon input-icon-right">
													<input type="text" class="form-control" placeholder="Tên đăng nhập" required="required" name="username" autofocus="autofocus" />
													<i class="icon-user"></i>
												</span>
											</label>
											<label class="block clearfix">
												<span class="block input-icon input-icon-right">
													<input type="password" class="form-control" placeholder="Mật khẩu" required="required" name="password" />
													<i class="icon-lock"></i>
												</span>
											</label>
											<div class="space"></div>
											<div class="clearfix">
												<label class="inlines hide">
													<input type="checkbox" class="ace" />
													<span class="lbl"> Remember Me</span>
												</label>
												<button type="submit" class="pull-right btn btn-sm btn-primary">
													<i class="icon-key"></i> Đăng nhập
												</button>
											</div>
										</fieldset>
									</form>
								</div><!-- /widget-main -->
                                <div class="toolbar clearfix">
									<div>
										<a class="forgot-password-link" onclick="show_box('forgot-box'); return false;" href="#">
											<i class="icon-arrow-left"></i>
											Quên mật khẩu?
										</a>
									</div>

									<div>
										<a class="user-signup-link" href="/register.php">
											Đăng ký
											<i class="icon-arrow-right"></i>
										</a>
									</div>
								</div>
							</div><!-- /widget-body -->
						</div><!-- /login-box -->
                        <div id="forgot-box" class="forgot-box widget-box no-border">
							<div class="widget-body">
								<div class="widget-main">
									<h4 class="header red lighter bigger">
										<i class="icon-key"></i>
										Phục hồi mật khẩu
									</h4>

									<div class="space-6"></div>
									<p>
										Nhập địa chỉ Email
									</p>

									<form name="frm-forgot" method="post" action="/forgot.php">
										<fieldset>
											<label class="block clearfix">
												<span class="block input-icon input-icon-right">
													<input type="email" class="form-control" placeholder="Email" required="required" autofocus="autofocus" name="email" />
													<i class="icon-envelope"></i>
												</span>
											</label>

											<div class="clearfix">
												<button type="submit" class="width-35 pull-right btn btn-sm btn-danger">
													<i class="icon-lightbulb"></i>
													Đồng ý
												</button>
											</div>
										</fieldset>
									</form>
								</div><!-- /widget-main -->

								<div class="toolbar center">
									<a href="#" onclick="show_box('login-box'); return false;" class="back-to-login-link">
										Đăng nhập
										<i class="icon-arrow-right"></i>
									</a>
								</div>
							</div><!-- /widget-body -->
						</div><!-- /forgot-box -->

					</div><!-- /position-relative -->
				</div>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div>
</div><!-- /.main-container -->
<script type="text/javascript">
	function show_box(id) {
	 $('.widget-box.visible').removeClass('visible');
	 $('#'+id).addClass('visible');
	}
    $(document).on("submit", "form[name=frm-login]", function(){
        o = this;
        $(o).find("[type=button], [type=submit], [type=reset], button").attr("disabled", true);
        $.post(
            $(o).attr("action"),
            $(o).serialize(),
            function(data){
                $(o).find("[type=button], [type=submit], [type=reset], button").attr("disabled", false);
                if (data.error) {
                    alert(data.message);
                }
                else {
                    window.location = data.redirect;
                }
            },
            "json"
        );
        return false;
    });
    $(document).on("submit", "form[name=frm-forgot]", function(){
        o = this;
        $(o).find("[type=button], [type=submit], [type=reset], button").attr("disabled", true);
        $.post(
            $(o).attr("action"),
            $(o).serialize(),
            function(data){
                $(o).find("[type=button], [type=submit], [type=reset], button").attr("disabled", false);
                $(o).trigger("reset");
                alert(data.message);
            },
            "json"
        );
        return false;
    });
</script>
</body>
</html>