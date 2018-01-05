
</div>{*<!-- /#wrapper -->*}

<footer>
	<div class="footer_in clearfix">
		<div class="footer_logo">
		</div>
		<div class="footer_cat footer_column">
			<p>まとめのジャンル一覧</p>
		{if 0 < count($genreList)}

			<ul>
			{foreach from=$genreList key=key item=i name=genre}
				{if $smarty.foreach.genre.index < 5}
				<li><a href="{$smarty.const.URL_ROOT}search{if $key != 0}/genre/{$key}{/if}">{$i}</a></li>
				{/if}
			{/foreach}
			</ul>

			<ul>
			{foreach from=$genreList key=key item=i name=genre}
				{if 4 < $smarty.foreach.genre.index && $smarty.foreach.genre.index < 10}
				<li><a href="{$smarty.const.URL_ROOT}search/genre/{$key}">{$i}</a></li>
				{/if}
			{/foreach}
			</ul>

			<ul>
			{foreach from=$genreList key=key item=i name=genre}
				{if 9 < $smarty.foreach.genre.index && $smarty.foreach.genre.index < 15}
				<li><a href="{$smarty.const.URL_ROOT}search/genre/{$key}">{$i}</a></li>
				{/if}
			{/foreach}
			</ul>

			<ul>
			{foreach from=$genreList key=key item=i name=genre}
				{if 14 < $smarty.foreach.genre.index && $smarty.foreach.genre.index < 20}
				<li><a href="{$smarty.const.URL_ROOT}search/genre/{$key}">{$i}</a></li>
				{/if}
			{/foreach}
			</ul>

			<ul>
			{foreach from=$genreList key=key item=i name=genre}
				{if 19 < $smarty.foreach.genre.index && $smarty.foreach.genre.index < 25}
				<li><a href="{$smarty.const.URL_ROOT}search/genre/{$key}">{$i}</a></li>
				{/if}
			{/foreach}
			</ul>

			<ul>
			{foreach from=$genreList key=key item=i name=genre}
				{if 24 < $smarty.foreach.genre.index && $smarty.foreach.genre.index < 30}
				<li><a href="{$smarty.const.URL_ROOT}search/genre/{$key}">{$i}</a></li>
				{/if}
			{/foreach}
			</ul>

		{/if}
		</div>{*<!-- /.footer_cat -->*}
		<div class="footer_about footer_column">
			<p>XVIDEOS&nbsp;まとめ（仮）について</p>
			<ul>
				<li><a href="{$smarty.const.URL_ROOT}create">まとめを作る</a></li>
				<li><a href="{$smarty.const.URL_ROOT}ranking">ランキング</a></li>
				<li><a href="{$smarty.const.URL_ROOT}agreement">利用規約</a></li>
			</ul>
		</div>{*<!-- /.footer_about -->*}
	</div>{*<!-- /.footer_in -->*}
</footer>
<div class="bottom_tagline clearfix">
	<p>XVIDEOS&nbsp;まとめ（仮）| XVIDEOSをより快適に楽しむためのキュレーションサービス</p>
	<p class="copyright"></p>
</div>{*<!-- /.bottom_tagline -->*}

{if $siteType == $smarty.const.SITE_TYPE_SP}
<p style="padding:30px 0;font-weight:bold;color:#555;text-align:center;background:#f8f8f8;border-top:solid 1px #d4d4d4;line-height:1.2;font-size:40px;" class="FooteriPhoneLink"><a id="changePC" style="color: #1435a9;text-decoration:underline;" href="javascript:void(0);" data-url="{$smarty.server.REQUEST_URI}">スマートフォン版で表示</a></p>
{/if}

<script type="text/javascript">
{if isset($json)}
var json = {$json|@json_encode nofilter}
{/if}
</script>
<script type="text/javascript" src="{$smarty.const.URL_ROOT}assets/dest/all.js?t={$smarty.const.APP_VERSION}"></script>
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
