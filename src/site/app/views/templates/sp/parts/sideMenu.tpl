
<nav id="side_menu">
	<p class="title_side_menu">まとめのジャンル一覧</p>
	<section class="side_menu_content">
{if 0 < count($genreList)}
	<ul class="side_menu_nav">
	{foreach from=$genreList key=key item=i name=genre}
		<li><a href="{$smarty.const.URL_ROOT}search{if $key != 0}/genre/{$key}{/if}">{$i}</a></li>
	{/foreach}
	</ul>
{/if}
	</section>{*<!-- /.side_menu_content -->*}
</nav>{*<!-- /#side_menu -->*}
