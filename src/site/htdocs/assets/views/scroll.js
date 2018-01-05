!function () {
	$(function () {
		if (0 < $("#scroll_follow").length) {
			var o = $("#scroll_follow"),
			t = $("#nav"),
			i = $("#column_content"),
			s = t.offset().top;
			fixTop = o.offset().top,
			mainTop = i.offset().top,
			w = $(window);
			var n = function () {
				fixTop = "static" === o.css("position") ? s + o.position().top : fixTop;
				var t = o.outerHeight(!0),
				n = i.outerHeight(),
				p = w.scrollTop();
				p + t > mainTop + n ? o.css({
					position : "absolute",
					top : n - t - 40
				}) : p >= fixTop ? o.css({
					position : "fixed",
					top : 20
				}) : o.css("position", "static")
			};
			w.on("scroll", n)
		}

//		if (0 < $("#column_side_ad").length) {
//			var ad = $('#column_side_ad .wrap'),
//				offset = ad.offset();
//
//			$(window).scroll(function() {
//				if($(window).scrollTop() > offset.top - 20) {
//					ad.css({ position : "fixed", top : 20});
//				} else {
//					ad.css({ position : "static" });
//				}
//			});
//		}

		if ($('#column_sidebar').height() < $('#column_content').height()) {
			if (0 < $("#scroll_sidebar").length) {
				var sidebar = $('#scroll_sidebar .wrap'),
					soffset = sidebar.offset();

				$(window).scroll(function() {
					if($(window).scrollTop() > soffset.top - 20) {
						sidebar.css({ position : "fixed", top : 0});
					} else {
						sidebar.css({ position : "static" });
					}
				});
			}
		}
	})
}
(jQuery);
