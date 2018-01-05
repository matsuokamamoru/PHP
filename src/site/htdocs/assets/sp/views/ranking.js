$(function() {

	$('#paginate.ranking a').click(function() {
		var target = $('#paginate.ranking a');

		if (target.hasClass('click')) return false;
		target.addClass('click');
		target.loading(true);

		$.ajax({
			url: json.APP_SETTING.URL_ROOT + 'ranking/load/' + target.data('page_no') + '/',
			dataType: 'html',
			cache: false,
			ifModified: false
		}).done(function(data) {
			$('#ranking.article_list ul').append(data);

			var nextPageNo = $('#ranking.article_list .next_page_no').last().val();
			if (nextPageNo) {
				target.data('page_no', nextPageNo);
			} else {
				$('#paginate.ranking a').hide();
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