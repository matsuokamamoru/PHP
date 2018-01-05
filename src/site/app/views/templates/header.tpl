<!DOCTYPE html>
<html lang="ja" >
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=1010px" />
	<title>{$title}</title>
	<meta name="description" content="{$description}" />
	<meta name="keywords" content="{$keywords}" />
	<!--[if lte IE 8]>
	<script type="text/javascript" src="{$smarty.const.URL_ROOT}assets/html5.js"></script>
	<![endif]-->
	<link rel="stylesheet" type="text/css" href="{$smarty.const.URL_ROOT}assets/dest/all.css?t={$smarty.const.APP_VERSION}" media="all" />
</head>
<body>
<header id="header">
	<div class="hd_in">
		<h1 class="logo"><a href="{$smarty.const.URL_ROOT}">XVIDEOS<span>&nbsp;まとめ（仮）</span></a></h1>

		<form accept-charset="UTF-8" action="{$smarty.const.URL_ROOT}search/index/" class="hd_search" id="searchForm" method="get">
			<div style="margin:0;padding:0;display:inline"><input type="hidden" /></div>
			<input type="text" class="hd_search_input" id="q" name="q" placeholder="気になるワードを入力" value="{if isset($words)}{$words}{/if}" />
			<input class="hd_search_btn" type="submit" value="" />
		</form>

		<ul class="hd_nav clearfix">
			<li><a href="{$smarty.const.URL_ROOT}create">まとめを作る</a></li>
			<li><a href="{$smarty.const.URL_ROOT}ranking">ランキング</a></li>
		</ul>
	</div>{*<!-- /.hd_in -->*}
</header>
{if $smarty.const.DEBUG == 0}
<!--
<section id="eyecatch">
<div id="ad_top">
	<div class="adsense" style="text-align: center; height: 70px;">
		<a href="http://click.dtiserv2.com/Click/2006005-6-171068" target="_blank"><img src="http://affiliate.dtiserv.com/image/carib/06-460-03.gif" border="0"></a>
	</div>
</div>
</section>
-->
{/if}
{if $controller == 'top'}
{include file="./parts/eyecatch.tpl"}
{/if}
<div id="wrapper" class="clearfix">
