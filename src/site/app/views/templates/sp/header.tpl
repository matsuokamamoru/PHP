<!DOCTYPE html>
<html lang="ja" >
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta name="format-detection" content="telephone=no">
	<title>{$title}</title>
	<meta name="description" content="{$description}" />
	<meta name="keywords" content="{$keywords}" />
	<link rel="stylesheet" type="text/css" href="{$smarty.const.URL_ROOT}assets/sp/dest/all.css.gz?t={$smarty.const.APP_VERSION}" media="all" />
</head>
<body>
<div id="normal_view">
<header id="header">
	<div class="hd_inner">
		<h1><a href="{$smarty.const.URL_ROOT}">XVIDEOS&nbsp;まとめ（仮）</a></h1>
		<a class="btn_hd_menu btn_hd btn_slide" href="javascript:void(0);"></a>
		<a id="header_search_btn" class="btn_hd_search btn_hd" href="javascript:void(0);"></a>
	</div>
</header>
<div id="page_wrapp">
	<div id="wrapper">
		<div id="overlay"></div>
{if $smarty.const.DEBUG == 0}
<section class="ad" style="margin-top: 8px;">
{literal}
<script type="text/javascript">
var adstir_vars = {
  ver    : "4.0",
  app_id : "MEDIA-10d9ce2c",
  ad_spot: 7,
  center : false
};
</script>
<script type="text/javascript" src="http://js.ad-stir.com/js/adstir.js?20130527"></script>
{/literal}
</section>
{/if}
