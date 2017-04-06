<!DOCTYPE html>
<html lang="vi-VN" dir="ltr" xmlns:fb="http://www.facebook.com/2008/fbml" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="<?=$strdescipt;?>" />
    <meta name="keywords" content="<?=$strkeyword;?>" />
    <meta name="robots" content="INDEX,FOLLOW" />
    <title><?=$strtitle;?></title>
    <link type="text/css" rel="stylesheet" href="<?=VIEWS_FOLDER;?>css/bootstrap.min.css" />
    <link type="text/css" rel="stylesheet" href="<?=VIEWS_FOLDER;?>css/font-awesome.min.css" />
    <link type="text/css" rel="stylesheet" href="<?=VIEWS_FOLDER;?>css/font-awesome.min.v4.css" />
    <!--[if IE 7]>
        <link rel="stylesheet" href="<?=VIEWS_FOLDER;?>css/font-awesome-ie7.min.css" />
    <![endif]-->
    <link type="text/css" rel="stylesheet" href="<?=VIEWS_FOLDER;?>css/ace-fonts.css" />
    <link type="text/css" rel="stylesheet" href="<?=VIEWS_FOLDER;?>css/ace.min.css" />
    <!--[if lte IE 8]>
        <link rel="stylesheet" href="<?=VIEWS_FOLDER;?>css/ace-ie.min.css" />
    <![endif]-->
    <link type="text/css" rel="stylesheet" href="<?=VIEWS_FOLDER;?>css/colorbox.css" />
    <link type="text/css" rel="stylesheet" href="<?=VIEWS_FOLDER;?>css/style.css" />
    
    <!--[if lt IE 9]>
        <script src="<?=VIEWS_FOLDER;?>js/html5shiv.js"></script>
		<script src="<?=VIEWS_FOLDER;?>js/respond.min.js"></script>
    <![endif]-->
    <!--[if !IE]> -->
        <script type="text/javascript">
            window.jQuery || document.write("<script src='<?=VIEWS_FOLDER;?>js/jquery-2.0.3.min.js'>"+"<"+"/script>");
		</script>
    <!-- <![endif]-->
    <!--[if IE]>
        <script type="text/javascript">
            window.jQuery || document.write("<script src='<?=VIEWS_FOLDER;?>js/jquery-1.10.2.min.js'>"+"<"+"/script>");
        </script>
    <![endif]-->
    <script type="text/javascript" src="<?=VIEWS_FOLDER;?>js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?=VIEWS_FOLDER;?>js/ace.min.js"></script>
    <script type="text/javascript" src="<?=VIEWS_FOLDER;?>js/jquery.colorbox-min.js"></script>
    <script type="text/javascript" src="<?=VIEWS_FOLDER;?>js/jquery.custom.js"></script>
    <script type="text/javascript" src="<?=VIEWS_FOLDER;?>js/functions.js"></script>
    
    <script>
        var groupid;
        var total = 0;
        var total_product = 0;
        var bonus = 0;
        var product = {};
        var ktv_ext = new Array();
        var WEBSITE_URL = '<?=WEBSITE_URL;?>';
        var WEBSITE_URL_CP = '<?=WEBSITE_URL_CP;?>';
        var listservicesgroup = <?=json_encode($listservicesgroup);?>;
        var listservices = <?=json_encode($listservices);?>;
        var listservicesfield = <?=json_encode($listservicesfield);?>;
        var listservicesfieldtext = <?=json_encode($listservicesfieldtext);?>;
        var listproduct = <?=json_encode($listproduct);?>;
        var listroom = <?=json_encode($listroom);?>;
        var listcustomeraction = <?=json_encode($listcustomeraction);?>;
        var listcustomeractiondetail = <?=json_encode($listcustomeractiondetail);?>;
    </script>
</head>
<body>