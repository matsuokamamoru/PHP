{include file="../header.tpl" title=$title description=$description keywords=$keywords}

	<div id="column_content" class="column_article">

		<article id="article">

		<form id="create" class="create" method="post" action="{$smarty.const.URL_ROOT}create/confirm">

			<label>ジャンル</label>
			<p>{html_options name=genre_id options=$genreList selected=$form.genre_id|default:0}</p>
			{parts_error error=$form.error key=genre_id}

			<label>タイトル</label>
			<p><input type="text" class="input-xlarge" name="title" value="{$form.title|default:''}" /></p>
			{parts_error error=$form.error key=title}

			<label>詳細</label>
			<p><textarea name="detail" rows="10" cols="80">{$form.detail|default:''}</textarea></p>


			<div id="moving_field" class="mt20">

			<label>動画URL <span class="article_date">※最大5件まで登録できます。</span></label>
			{if count($form.moving_url)  > 0 }
				{foreach from=$form.moving_url item=val name=urlList }
					{if $smarty.foreach.urlList.first}
						<p class="url"><input type="text" value="{$val}" name="moving_url[]" class="input-xxlarge"></p>
					{else}
						<p class="url"><input type="text" value="{$val}" name="moving_url[]" class="input-xxlarge"><a class="btn remove" href="javascript:void(0);" style="opacity: 1;">削除</a></p>
					{/if}
					{parts_error error=$form.error key='moving_url'|cat:{$smarty.foreach.urlList.iteration}}
				{/foreach}
			{else}
				<p class="url"><input type="text" value="" name="moving_url[]" class="input-xxlarge"></p>
			{/if}

			<p class="mt10">
			{if count($form.moving_url)  < 5 }
				<a id="btnUrlAdd" href="javascript:void(0);" class="btn">動画をさらに追加する</a>
			{else}
				<a id="btnUrlAdd" class="btn" href="javascript:void(0);" style="display: none; opacity: 1;">動画をさらに追加する</a>
			{/if}
			</p>

			</div>


			<label class="mt30">画像認証</label>
			<p class="mt10"><img alt="" src="{$smarty.const.URL_ROOT}api/image/secur/" /></p>
			<p class="mt10"><input type="text" class="input-xlarge" name="captcha_code" value="" /></p>
			{parts_error error=$form.error key=captcha_code}

			<div class="form-actions">
				<p><a href="javascript:void(0);" class="btn btn-large" id="btn_confirm">確認</a></p>
			</div>
		</form>

		<div id="copyUrl">
			<p class="url" style="display: none;"><input type="text" value="" name="moving_url[]" class="input-xxlarge"><a href="javascript:void(0);" class="btn remove">削除</a></p>
		</div>

		</article>

	</div>{*<!-- /#column_content -->*}

{include file="../parts/sidebar/01.tpl"}

{include file="../footer.tpl"}