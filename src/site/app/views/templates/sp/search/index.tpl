{if isset($words) && $words != ''}
{include file="../header.tpl" title={vsprintf format=$title values=$words} description=$description keywords=$keywords}
{elseif isset($genre)}
{include file="../header.tpl" title={vsprintf format=$title values=$genre} description=$description keywords=$keywords}
{else}
{include file="../header.tpl" title={vsprintf format=$title values='全て'} description=$description keywords=$keywords}
{/if}

<h2 class="title_archive">検索結果{if isset($words) && $words != ''}（{$words}）{elseif isset($genre)}（{$genre}）{else}（全て）{/if}</h2>

<section id="search" class="article_list">
{if 0 < count($form.contents)}
<ul>
	{foreach from=$form.contents item=i name=contents}
	<li>
	<a href="{$smarty.const.URL_ROOT}detail/index/{$i.content_id}">
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

	{if $smarty.foreach.contents.iteration % 5 == 0 }
	{include file="../parts/adList.tpl"}
	{/if}

	{/foreach}
</ul>

<div id="paginate" class="search">
{if !is_null($form.nextPageNo)}
<a href="javascript:void(0);" data-action="{$loadAction}" data-param="{if isset($words)}{$words}{elseif isset($genreId)}{$genreId}{/if}" data-page_no="2"
{if isset($words)}
onclick="ga('send', 'event', 'sp/検索', 'ページング', '検索/{$words}');"
{elseif isset($genre)}
onclick="ga('send', 'event', 'sp/検索', 'ページング', '検索/{$genre}');"
{/if}
>
<span class="load">もっと・・・</span>
<span class="loading" style="display: none;"><img alt="" src="{$smarty.const.URL_ROOT}assets/sp/images/loader.gif" /></span>
</a>
{/if}
</div>

{else}
<section class="article_list">
<p class="text_search_empty">「{if isset($words) && $words != ''}{$words}{elseif isset($genre)}{$genre}{else}全て{/if}」に関するまとめはありませんでした。</p>
<div id="paginate"></div>
</section>
{/if}

</section>

{include file="../parts/newVideos.tpl"}

{include file="../parts/ranking.tpl"}

{include file="../parts/hotword.tpl"}

{include file="../_footer.tpl"}

{if isset($words) && $words != ''}
<script type="text/javascript">
$(function() {
	var val = '{$words}';

	if (val != '') {
		var url = json.APP_SETTING.API_URL_COUNT_WORDS.format(encodeURIComponent(val));
		$.ajax({
			url: url,
			dataType: 'json',
			cache: false,
			ifModified: false
		}).done(function(data) {
		}).fail(function(data) {
		});
	}
});
</script>
{/if}

</body>
</html>
{if $smarty.const.DEBUG == 1}{$form|@var_dump}{/if}