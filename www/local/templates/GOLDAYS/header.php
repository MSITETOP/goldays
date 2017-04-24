<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
IncludeTemplateLangFile(__FILE__);
$CurPage = $APPLICATION->GetCurPage();
?><!DOCTYPE html>
<html>
	<head>
	<!--======= POP-UP start =======-->
		<title><?$APPLICATION->ShowTitle();?></title>
		<!--[if lt IE 9]>
			<script type="text/javascript">
				document.createElement('header');
				document.createElement('nav');
				document.createElement('section');
				document.createElement('article');
				document.createElement('aside');
				document.createElement('footer');
			</script>
			<link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/css/ie8-style.css" />
		<![endif]-->
		<link rel="shortcut icon" type="image/x-icon" href="<?=SITE_TEMPLATE_PATH?>/favicon.ico" />
		<link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/css/style.css" />

        <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/scripts/jquery-1.10.2.min.js"></script>
 <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/scripts/jquery-migrate-1.2.1.js"></script>

<!--[if lte IE 8]><style>.item-sizes .sizes span.active {
color: #e9ae47;
}</style><![endif]-->

        <?$APPLICATION->ShowHead();?>
	<!--======= POP-UP end =======-->

	</head>

	<body>
	<div id="overlay"></div>	
		<div id="panel">
			<?$APPLICATION->ShowPanel();?>
		</div>

 