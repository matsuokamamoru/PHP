{include file="../header.tpl" title={vsprintf format=$title values=$form.contents.0.title} description=$form.contents.0.description keywords=$keywords}

<article id="article" class="detail">

	{if 0 < count($form.tags)}
	<section class="article_keyword_list">
		<h2 class="title_keyword">このまとめに関するキーワード</h2>
		<ul>
			{foreach from=$form.tags item=i}
			<li class="tag"><a href="{$smarty.const.URL_ROOT}search/index/?q={$i.word}">{$i.word}</a></li>
			{/foreach}
		</ul>
	</section>
	{/if}

	<div class="article_info">
		<p class="update_date">{$form.contents.0.create_date}&nbsp;登録</p>
		{if isset($form.contents.0.view_count)}
		<div class="count"><p class="view"><span>{$form.contents.0.view_count}</span>view</p></div>
		{/if}
	</div>

	<div class="title_article">
	<div class="title_article_inner">
		<div class="title_article_thumb">
	{if isset($form.contents.0.thumbnail_img_url)}
		<img alt="{$form.contents.0.title}" class="lazy" data-original="{$form.contents.0.thumbnail_img_url}" width="75" height="56" />
	{else}
		<img alt="{$form.contents.0.title}" class="lazy" data-original="{$smarty.const.URL_ROOT}assets/images/180135.jpg" width="75" height="56" />
	{/if}
		</div>
		<h1>{$form.contents.0.title}</h1>
	</div>
	</div>
	<p class="article_lead">{$form.contents.0.description|nl2br nofilter}</p>
	<ul class="top_link_area clearfix" style="padding-top: 3px;">
		<li style="padding: 5px 0; float: left; width: 95px;">
			<a href="https://twitter.com/share" class="twitter-share-button" data-via="projectXvideos" data-lang="ja" data-hashtags="xvideos,エロ動画{if isset($form.contents.0.genre_id) && isset($genreList[$form.contents.0.genre_id])},{$genreList[$form.contents.0.genre_id]}{/if}">ツイート</a>
			{literal}<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>{/literal}
		</li>
		<li style="padding: 5px 0; float: left;">
			{literal}
			<script type="text/javascript" src="//media.line.me/js/line-button.js?v=20140411" ></script>
			<script type="text/javascript">
			new media_line_me.LineButton({"pc":false,"lang":"ja","type":"a"});
			</script>
			{/literal}
		</li>
	</ul>
	<div class="content_area">

	{if $smarty.const.DEBUG == 0}
	{include file="../parts/ad.tpl"}
	{/if}

	{foreach from=$form.contents item=i name=contents}
	<div class="item {if $smarty.foreach.contents.iteration != 1}mt20{/if} clearfix">
		<div class="video_container">
			<iframe class="lazy" data-original="{$i.video_url}" width="690" height="550" frameborder="0" allowfullscreen></iframe>
		</div>
		{if isset($i.thumbnail_img_url)}
		<ul class="thumbs">
		{for $no=3 to 10}
			<li style="min-height: 59px;"><img alt="{$i.title}" class="lazy" data-original="{$i['thumbnail_img_url'|cat:$no]}" width="100%" /></li>
		{/for}
		</ul>
		{/if}
	</div>
	{/foreach}

	{if $smarty.const.DEBUG == 0}
	{include file="../parts/ad.tpl"}
	{/if}

	</div>

</article>

{include file="../parts/newVideos.tpl"}


{if 0 < count($form.relatedContents)}
<h2 class="title_section">関連するまとめ</h2>
<section class="article_list">
<ul>
	{foreach from=$form.relatedContents item=i}
	<li>
	<a href="{$smarty.const.URL_ROOT}detail/index/{$i.content_id}" onclick="ga('send', 'event', 'sp/コンテンツ', '関連動画', '{$genreList[$i.genre_id]}');">
	<div class="list_thumb">
	{if isset($i.thumbnail_img_url)}
		<img alt="{$i.title}" class="lazy" data-original="{$i.thumbnail_img_url}" width="120" height="90" />
	{else}
		<img alt="{$i.title}" class="lazy" data-original="{$smarty.const.URL_ROOT}assets/images/180135.jpg" width="120" height="90" />
	{/if}
	{if isset($i.play_time) && $i.play_time != '00:00'}
		<p class="play_time">{$i.play_time}</p>
	{/if}
	</div>
	<div class="list_content">
	<h3><span>{$i.title}</span></h3>
	<div class="list_info">
		<p class="view"><span>{$i.view_count}</span>view</p>
		<p class="author">{if isset($genreList[$i.genre_id])}{$genreList[$i.genre_id]}{/if}</p>
	</div>
	</div>
	</a>
	</li>
	{/foreach}

{include file="../parts/adList.tpl"}

</ul>
</section>
{/if}


{include file="../parts/hotword.tpl"}

{include file="../_footer.tpl"}

{if isset($form.contents.0.genre_id)}
<script type="text/javascript">
$(function() {
	var contentId = '{$form.contents.0.content_id}';
	var genreId = '{$form.contents.0.genre_id}';

	var apiUrl = json.APP_SETTING.API_URL_COUNT.format(contentId, genreId);

	$.ajax({
		url: apiUrl,
		cache: false,
		ifModified: false
	}).done(function(data) {
	}).fail(function(data) {
	});
});
</script>
{/if}

</body>
</html>
{if $smarty.const.DEBUG == 1}{$form|@var_dump}{/if}