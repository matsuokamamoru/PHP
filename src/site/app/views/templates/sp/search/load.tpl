
{if 0 < count($form.contents)}
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
	{/if}

	{/foreach}
	<input type="hidden" class="next_page_no" value="{if isset($form.nextPageNo)}{$form.nextPageNo}{/if}" />
{/if}
