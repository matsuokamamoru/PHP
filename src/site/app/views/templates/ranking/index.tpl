{include file="../header.tpl" title=$title description=$description keywords=$keywords}

	<div id="column_content">

{include file="../parts/nav01.tpl"}

		<div id="content">
			<div class="title_list clearfix" style="padding-top:10px;">
				<h2>アクセスランキング</h2>
				<p>昨日人気のあったまとめランキング</p>
			</div>

			<div id="search_result" class="article_list pickup_list">

			{if 0 < count($form.contents)}

				{foreach from=$form.contents item=i}
				<div class="article_list_content clearfix">
					<p class="rank_number rank_number_{$i.rownum}">{$i.rownum}</p>
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
						</ul>
					</div>
				</div>
				{/foreach}
			{/if}

			{$form.pager nofilter}

			</div>{*<!-- /.article_list -->*}
		</div>{*<!-- /#content -->*}
	</div>{*<!-- /#column_content -->*}

{include file="../parts/sidebar/02.tpl"}

{include file="../_footer.tpl"}

</body>
</html>
{if $smarty.const.DEBUG == 1}{$form|@var_dump}{/if}