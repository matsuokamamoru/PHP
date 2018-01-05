{include file="../header.tpl" title={vsprintf format=$title values=$form.contents.0.title} description=$form.contents.0.description keywords=$keywords}

	<div id="column_content" class="column_article">

	{if isset($form.contents.0.genre_id)}
		<div class="title_list mt0 clearfix">
			<h2>このまとめに関するキーワード</h2>
		</div>
		<ul id="tags" class="afterTags clearfix show_tag">
		{if 0 < count($form.tags)}
			{foreach from=$form.tags item=i}
			<li class="tag"><a href="{$smarty.const.URL_ROOT}search/index/?q={$i.word}">{$i.word}</a></li>
			{/foreach}
		{/if}
		</ul>

		<div id="edit_tags" class="mb10" style="display: none;"><input name="tags" id="content_tags" value="" /></div>

		<div class="mb20">
			<a class="btn" href="javascript:void(0);" id="btnEditTags" style="opacity: 1;" onclick="ga('send', 'event', 'pc/コンテンツ', 'タグ登録（編集）', '{$genreList[$form.contents.0.genre_id]}/{$form.contents.0.content_id}');">タグ登録</a>
			<a class="btn" style="display: none;" href="javascript:void(0);" id="btnInsertTags" style="opacity: 1;">入力した内容で登録する</a>
			<span class="comment">※最大3件まで登録できます。</span>
		</div>
	{/if}

		<article id="article">

			<p class="article_date">{$form.contents.0.create_date}&nbsp;登録</p>
			<h1>{$form.contents.0.title}</h1>
			<p class="articleLead">
				{$form.contents.0.description|nl2br nofilter}
			</p>

			<div class="articleInfo clearfix mb20">
				<ul class="share">
					<li>
						<a href="https://twitter.com/share" class="twitter-share-button" data-via="projectXvideos" data-lang="ja" data-hashtags="xvideos,エロ動画{if isset($form.contents.0.genre_id) && isset($genreList[$form.contents.0.genre_id])},{$genreList[$form.contents.0.genre_id]}{/if}">ツイート</a>
						{literal}<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>{/literal}
					</li>
				</ul>
				{if isset($form.contents.0.view_count)}
				<ul class="articleData">
					<li class="view"><span>{$form.contents.0.view_count}</span>view</li>
				</ul>
				{/if}
			</div>

			{foreach from=$form.contents item=i}
			<div class="item clearfix">
				<iframe class="lazy" data-original="{$i.video_url}" width="690" height="550" frameborder="0" allowfullscreen></iframe>
				{if isset($i.thumbnail_img_url)}
				<ul class="thumbs">
				{for $no=1 to 10}
					<li><img alt="{$i.title}" class="lazy" data-original="{$i['thumbnail_img_url'|cat:$no]}" width="138" height="104" /></li>
				{/for}
				</ul>
				{/if}
			</div>
			{/foreach}

		</article>

	{if 0 < count($form.relatedContents)}
		<div class="title_list mb10 clearfix" id="relatedPostAnalyse">
			<h2>関連するまとめ</h2>
			<p>こんなまとめも人気です♪</p>
		</div>

		<div class="clearfix related_post_list">
		{foreach from=$form.relatedContents item=i name=contents}
			<div class="article_list_thumb" style="{if $smarty.foreach.contents.iteration % 4 != 0 }margin-right: 10px;{/if}">
				<a class="detail" href="{$smarty.const.URL_ROOT}detail/index/{$i.content_id}" onclick="ga('send', 'event', 'pc/コンテンツ', '関連動画', '{$genreList[$i.genre_id]}');">
				{if isset($i.thumbnail_img_url)}
					<img alt="{$i.title}" class="lazy" data-original="{$i.thumbnail_img_url}" width="165" height="124" />
				{else}
					<img alt="{$i.title}" class="lazy" data-original="{$smarty.const.URL_ROOT}assets/images/180135.jpg" width="165" height="124" />
				{/if}
				</a>
				{if isset($i.play_time) && $i.play_time != '00:00'}
				<p class="play_time">{$i.play_time}</p>
				{/if}
				<p class="article_list_title"><a class="detail" href="{$smarty.const.URL_ROOT}detail/index/{$i.content_id}">{$i.title}</a></p>
				<ul class="article_list_info">
					<li><a href="{$smarty.const.URL_ROOT}search{if $i.genre_id != 0}/genre/{$i.genre_id}{/if}">{if isset($genreList[$i.genre_id])}{$genreList[$i.genre_id]}{/if}</a></li>
					<li>｜<span>{$i.view_count}</span>view</li>
				</ul>
			</div>
		{/foreach}
		</div>
	{/if}

	</div>{*<!-- /#column_content -->*}

{include file="../parts/sidebar/01.tpl"}

{include file="../_footer.tpl"}

<script type="text/javascript">
$(function() {

	function setToken() {
		$.ajax({
			url: '{$smarty.const.URL_ROOT}api/tags/token/',
			cache: false,
			ifModified: false
		}).done(function(data) {
			$('#btnInsertTags').data('token', data.token);
		}).fail(function(data) {
		});
	}

	$('#content_tags').tagsInput({
		'height': '60px',
		'width': '678px',
		'interactive': true,
		'defaultText': 'タグを入力してください。',
		'onAddTag': function() {
			},
		'onRemoveTag': function() {
			},
		'onChange': function() {
			},
		'removeWithBackspace': true,
		'minChars': 0,
		'maxChars': 20,
		'placeholderColor': '#666666'
	});

{if 0 < count($form.tags)}
	{foreach from=$form.tags item=i}
	$('#content_tags').addTag('{$i.word}');
	{/foreach}
{/if}

	$('#btnEditTags').on('click', function() {
		$(this).hide();
		$('#btnInsertTags').show();

		$('#tags').hide();
		$('#edit_tags').show();

		setToken();
	});

	$('#btnInsertTags').on('click', function() {

		var words = new Array();

		$.each($('#content_tags_tagsinput .tag'), function(i) {
			words.push($.trim($(this).find('span').html()));
		});

{if isset($form.contents.0.genre_id)}
		var label = '{$genreList[$form.contents.0.genre_id]}/{$form.contents.0.content_id}/' +  words.join(',');
		ga('send', 'event', 'pc/コンテンツ', 'タグ登録（確定）', label);
{/if}

		$.ajax({
			type: 'POST',
			url: '{$smarty.const.URL_ROOT}api/tags/add/',
			data: {
				token: $(this).data('token'),
				content_id: '{$form.contents.0.content_id}',
				words: words.join(',')
			},
			cache: false,
			ifModified: false
		}).done(function(data) {

			if (data.status == 'success') {
				$('#tags li').remove();

				for (var i = 0; i < words.length; i++) {
					$('#tags').append('<li class="tag"><a href="{$smarty.const.URL_ROOT}search/index/?q=' + words[i] + '">' + words[i] + '</a></li>');
				}

				$('#btnInsertTags').hide();
				$('#btnEditTags').show();

				$('#edit_tags').hide();
				$('#tags').show();
			} else {
				setToken();
			}

		}).fail(function(data) {
			setToken();
		});

	});

});
</script>

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