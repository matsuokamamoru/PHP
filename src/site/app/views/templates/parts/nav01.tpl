
		<nav id="nav">
			<ul id="scroll_follow">
		{if 0 < count($genreList)}
			{foreach from=$genreList key=key item=i name=genre}

				{if $smarty.foreach.genre.index < 10}
					{if $key == 0 && !isset($genreId)}
				<li><strong><a href="{$smarty.const.URL_ROOT}search">{$i}</a></strong></li>
					{elseif $key == 0}
				<li><a href="{$smarty.const.URL_ROOT}search">{$i}</a></li>
					{elseif isset($genreId) && $genreId == $key}
				<li><strong><a href="{$smarty.const.URL_ROOT}search/genre/{$key}">{$i}</a></strong></li>
					{else}
				<li><a href="{$smarty.const.URL_ROOT}search/genre/{$key}">{$i}</a></li>
					{/if}
				{/if}

			{/foreach}
		{/if}
			</ul>
		</nav>
