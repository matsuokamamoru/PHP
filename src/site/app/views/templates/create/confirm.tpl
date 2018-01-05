{include file="../header.tpl" title=$title description=$description keywords=$keywords}
	<div id="column_content" class="column_article">

		<article id="article">

		<form id="create" class="create" method="post" action="{$smarty.const.URL_ROOT}create/complete">

			<label>ジャンル</label>
			<p class="articleLead" style="font-size: 20px;">{$form.genre_name}</p>

			<label>タイトル</label>
			<h1>{$form.title}</h1>

			<label>詳細</label>
			<p class="articleLead mb20">
				{$form.detail|nl2br nofilter}
			</p>

			{foreach from=$form._moving_url item=val}
				<div class="item clearfix">
					<iframe class="lazy" data-original="{$val}" width="300" height="250" frameborder="0" allowfullscreen></iframe>
				</div>
			{/foreach}

			<div class="form-actions">
				<p>
					<a href="javascript:void(0);" class="btn btn-large" id="btn_confirm" onclick="ga('send', 'event', 'pc/投稿', '登録', '{$form.genre_name}');">登録</a>
					<a href="{$smarty.const.URL_ROOT}create" class="btn btn-large" onclick="ga('send', 'event', 'pc/投稿', '戻る', '{$form.genre_name}');">戻る</a>
				</p>
			</div>
			<input type="hidden" name="token" value="{$form.token}" />
		</form>
		</article>
	</div>{*<!-- /#column_content -->*}

{include file="../parts/sidebar/01.tpl"}

{include file="../footer.tpl"}