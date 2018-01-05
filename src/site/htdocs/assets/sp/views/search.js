$(function() {

	$('#paginate.search a').click(function() {
		var target = $('#paginate.search a');

		if (target.hasClass('click')) return false;
		target.addClass('click');
		target.loading(true);

		var pageNo = target.data('page_no');
		var action = target.data('action');
		var param = target.data('param');

		var option = {};
		option.dataType = 'html';
		option.cache = false;
		option.ifModified = false;

		if (action == 'load') {
			option.url = json.APP_SETTING.URL_ROOT + 'search/' + action + '/' + pageNo + '/';
			option.data = {
				q: param,
				page_no: pageNo
			};
		} else {
			option.url = json.APP_SETTING.URL_ROOT + 'search/' + action + '/' + param + '/' + pageNo + '/';
		}

		$.ajax(option).done(function(data) {
			$('#search.article_list ul').append(data);

			var nextPageNo = $('#search.article_list .next_page_no').last().val();

			if (nextPageNo) {
				target.data('page_no', nextPageNo);
			} else {
				$('#paginate.search a').hide();
			}

			var lazyOption = {
				srcAttr: 'data-original'
			};
			$('img.lazy').lazyLoadXT(lazyOption);

			target.removeClass('click');
			target.loading(false);
		}).fail(function(data) {
			target.removeClass('click');
			target.loading(false);
		});
	});

});