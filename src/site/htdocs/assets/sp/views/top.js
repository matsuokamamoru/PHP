$(function() {

	$('#paginate.top a').click(function() {
		var target = $('#paginate.top a');

		if (target.hasClass('click')) return false;
		target.addClass('click');
		target.loading(true);

		$.ajax({
			url: json.APP_SETTING.URL_ROOT + 'top/load/' + target.data('page_no') + '/',
			dataType: 'html',
			cache: false,
			ifModified: false
		}).done(function(data) {
			$('#today.article_list ul').append(data);

			var nextPageNo = $('#today.article_list .next_page_no').last().val();
			if (nextPageNo) {
				target.data('page_no', nextPageNo);
			} else {
				$('#paginate.top a').hide();
			}

			var lazyOption = { srcAttr: 'data-original' };
			$('img.lazy').lazyLoadXT(lazyOption);

			target.removeClass('click');
			target.loading(false);
		}).fail(function(data) {
			target.removeClass('click');
			target.loading(false);
		});
	});

});