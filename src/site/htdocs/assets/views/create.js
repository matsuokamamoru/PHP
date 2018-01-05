$(function() {

	$('#btnUrlAdd').click(function() {

		if ($('#moving_field p.error').length != 0) {
			$('#moving_field p.error').remove();
		}

		var urlCount = $('form.create p.url').length;

		// 追加する要素をコピーして表示
		var obj = $('#copyUrl').clone().children().insertAfter($('form.create p.url').last()).show(0, function() {
		});

		// 追加した要素に削除イベントを追加
		$(obj.find('a.btn.remove')).bind('click', removeUrl);
		$(obj.find('a.btn.remove')).fadeHover();

		// 追加する上限に達した場合、追加するボタンを消す
		if ((urlCount + 1) === 5) {
			$(this).hide();
		}

	});

	function removeUrl() {

		if ($('#moving_field p.error').length != 0) {
			$('#moving_field p.error').remove();
		}

		$(this).parent().hide(0, function() {
			$(this).remove();

			if ($('form.create p.url').length < 10) {
				$('#btnUrlAdd').show();
			}
		});
	}

	$('#create a.btn.remove').bind('click', removeUrl);

	$('#btn_confirm').click(function() {
		var genre = $('select[name="genre_id"] option:selected').text();
		ga('send', 'event', 'pc/投稿', '確認', genre);

		$('#create').submit();
	});

});