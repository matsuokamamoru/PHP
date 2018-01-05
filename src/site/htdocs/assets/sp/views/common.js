/* =Check User Agent
-----------------------------------------------------------------------------*/
var nut = navigator.userAgent.toLowerCase();
var uaCheck = {
	'ie'		:nut.indexOf('msie') != -1,
	'ie6'		:nut.indexOf('msie 6') != -1,
	'ie7'		:nut.indexOf('msie 7') != -1,
	'ie8'		:nut.indexOf('msie 8') != -1,
	'ff'		:nut.indexOf('firefox') != -1,
	'safari'	:nut.indexOf('safari') != -1,
	'chrome'	:nut.indexOf('chrome') != -1,
	'opera'		:nut.indexOf('opera') != -1,
	'iphone'	:nut.match(/iPhone/i),
	'ipad'		:nut.match(/iPad/i),
	'ipod'		:nut.match(/iPod/i),
	'android'	:nut.match(/Android/i),
	'win'		:navigator.appVersion.indexOf('Win'),
	'mac'		:navigator.appVersion.indexOf('Macintosh'),
	'sp'		:nut.match(/iPhone/i) || nut.match(/iPad/i) || nut.match(/iPod/i) || nut.match(/Android/i)
};

function ua(target) {
	return uaCheck[target];
}

/* =Check Browser Size
-----------------------------------------------------------------------------*/
function getBrowserWidth() {
	return ua("ie") ? document.documentElement.clientWidth : window.innerWidth;
}

function getBrowserHeight() {
	return ua("ie") ? document.documentElement.clientHeight : window.innerHeight;
}

String.prototype.format = function() {
	var val = this;
	for (var i = 0; i < arguments.length; i++) {
		var reg = new RegExp("\\{" + i + "\\}", "gm");
		val = val.replace(reg, arguments[i]);
	}
	return val;
};

$(function() {

	var lazyOption = {
		srcAttr: 'data-original'
	};
	$('img.lazy').lazyLoadXT(lazyOption);
	$('iframe.lazy').lazyLoadXT(lazyOption);

	$('#changePC').click(function() {
		$.cookie('mview', 'PC', { path: '/' });
		location.href = $(this).data('url');
	});

});

$(window).load(function() {
	if ($('#new_videos.flexslider').length != 0) {
		$('#new_videos.flexslider').flexslider({
			animation: 'slides',
			animationLoop: false,
			slideshow: false,
			controlNav: false,
			directionNav: true,
			itemWidth: 120,
			start: function() {
			}
		});
	}
});

$.fn.loading = function(isLoading) {
	if (isLoading) {
		$(this).find('.load').hide();
		$(this).find('.loading').show();

	} else {
		$(this).find('.load').show();
		$(this).find('.loading').hide();
	}
};