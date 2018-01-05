{if isset($words) && $words != ''}
{include file="../header.tpl" title={vsprintf format=$title values=$words} description=$description keywords=$keywords}
{elseif isset($genre)}
{include file="../header.tpl" title={vsprintf format=$title values=$genre} description=$description keywords=$keywords}
{else}
{include file="../header.tpl" title={vsprintf format=$title values='全て'} description=$description keywords=$keywords}
{/if}

	<div id="column_content">

{include file="../parts/nav01.tpl"}

		<div id="content">
			<div class="title_list clearfix" style="padding-top:10px;">
				<h2>検索結果{if isset($words) && $words != ''}（{$words}）{elseif isset($genre)}（{$genre}）{else}（全て）{/if}</h2>
			</div>

			<div id="search_result" class="article_list pickup_list">

			{if 0 < count($form.contents)}

				{foreach from=$form.contents item=i}
				<div class="article_list_content clearfix">
					<div class="article_list_thumb" style="width:110px;">
						<a class="detail" href="{$smarty.const.URL_ROOT}detail/index/{$i.content_id}">
						{if isset($i.thumbnail_img_url)}
							<img alt="{$i.title}" class="lazy" data-original="{$i.thumbnail_img_url}" width="100" height="75" />
						{else}
							<img alt="{$i.title}" class="lazy" data-original="{$smarty.const.URL_ROOT}assets/images/180135.jpg" width="100" height="75" />
						{/if}
						</a>
						{if isset($i.play_time) && $i.play_time != '00:00'}
						<p class="play_time">{$i.play_time}</p>
						{/if}
					</div>
					<div class="article_list_text">
						<p class="article_list_title"><a class="detail" href="{$smarty.const.URL_ROOT}detail/index/{$i.content_id}">{$i.title}</a></p>
						<p class="article_list_lead">{$i.description|truncate:70:'...'}</p>
						<ul class="article_list_info">
							<li><a href="{$smarty.const.URL_ROOT}search{if $i.genre_id != 0}/genre/{$i.genre_id}{/if}">{if isset($genreList[$i.genre_id])}{$genreList[$i.genre_id]}{/if}</a></li>
							<li>｜<span>{$i.view_count}</span>view</li>
						</ul>
					</div>
				</div>
				{/foreach}
			{/if}

			{$form.pager nofilter}

			</div>{*<!-- /.article_list -->*}
		</div>{*<!-- /#content -->*}
	</div>{*<!-- /#column_content -->*}

{include file="../parts/sidebar/01.tpl"}
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