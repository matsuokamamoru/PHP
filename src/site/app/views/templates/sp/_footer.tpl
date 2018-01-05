
{if $smarty.const.DEBUG == 0}
<section class="ad">
<!-- <a href="http://click.dtiserv2.com/Click2/1103001-103-171068" target="_blank"><img src="http://affiliate.dtiserv.com/image/dxlive/dxauto1.jpg" border="0" width="300"></a> -->
{literal}
<script type="text/javascript">
var adstir_vars = {
  ver    : "4.0",
  app_id : "MEDIA-10d9ce2c",
  ad_spot: 8,
  center : false
};
</script>
<script type="text/javascript" src="http://js.ad-stir.com/js/adstir.js?20130527"></script>
{/literal}
</section>
{/if}

<h2 class="title_section">まとめのジャンル一覧</h2>
<section class="category_list">
{if 0 < count($genreList)}
	<ul>
	{foreach from=$genreList key=key item=i name=genre}
		{if $smarty.foreach.genre.index < 10}
			{if $key == 0 && !isset($genreId)}
		<li {if $controller == 'search'}class="active"{/if}><a href="{$smarty.const.URL_ROOT}search">{$i}</a></li>
			{elseif $key == 0}
		<li><a href="{$smarty.const.URL_ROOT}search">{$i}</a></li>
			{elseif isset($genreId) && $genreId == $key}
		<li class="active"><a href="{$smarty.const.URL_ROOT}search/genre/{$key}">{$i}</a></li>
			{else}
		<li><a href="{$smarty.const.URL_ROOT}search/genre/{$key}">{$i}</a></li>
			{/if}
		{/if}
	{/foreach}
	</ul>
{/if}
</section>

{if $smarty.const.DEBUG == 0}
<section class="ad">
<!-- <a href="http://click.dtiserv2.com/Click2/1103001-103-171068" target="_blank"><img src="http://affiliate.dtiserv.com/image/dxlive/dxauto1.jpg" border="0" width="300"></a> -->
{literal}
<script type="text/javascript">
var adstir_vars = {
  ver    : "4.0",
  app_id : "MEDIA-10d9ce2c",
  ad_spot: 9,
  center : false
};
</script>
<script type="text/javascript" src="http://js.ad-stir.com/js/adstir.js?20130527"></script>
{/literal}
</section>
{/if}

{include file="./parts/rssEropon.tpl"}

<footer id="footer">
<ul>
	<li><a href="{$smarty.const.URL_ROOT}">トップページ</a></li>
	<li><a href="#wrapper"><span>▲</span>ページトップへ</a></li>
	<li><a href="{$smarty.const.URL_ROOT}ranking">ランキング</a></li>
	<li><a href="{$smarty.const.URL_ROOT}agreement">利用規約</a></li>
</ul>
<p class="copyright"><a id="changePC" href="javascript:void(0);" data-url="{$smarty.server.REQUEST_URI}">PCモード</a></p>
</footer>

	</div>{*<!--#wrapper -->*}
</div>{*<!--#page_wrapp -->*}

{include file="./parts/sideMenu.tpl"}

<script type="text/javascript">
{if isset($json)}
var json = {$json|@json_encode nofilter}
{/if}
</script>
<div id="script">
<script src="{$smarty.const.URL_ROOT}assets/sp/dest/all.js.gz?t={$smarty.const.APP_VERSION}" type="text/javascript"></script>
</div>
{literal}
<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-52774298-1', {'cookieDomain': 'matomes.net'});
</script>
{/literal}
<script>
{if isset($form.gaSendPageView)}
ga('send', 'pageview', '{$form.gaSendPageView}');
{else}
ga('send', 'pageview');
{/if}
</script>

</div>{*<!-- /#normal_view -->*}

{include file="./parts/searchView.tpl"}
