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
	// a fade
	$('a.link, a.btn').fadeHover();

	var lazyOption = {
		srcAttr: 'data-original'
	};
	$('img.lazy').lazyLoadXT(lazyOption);
	$('iframe.lazy').lazyLoadXT(lazyOption);

	$('#changePC').click(function() {
		$.cookie('mview', 'off', { path: '/' });
		location.href = $(this).data('url');
	});

	if (json.APP_SETTING.DEBUG == 1) return;

	// 広告
//	if ($('#ad_bottom').length != 0) {
//		$('#ad_bottom').meerkat({
//			background: 'rgba(0,0,0,0.5)',
//			height: '100px',
//			width: '100%',
//			position: 'bottom',
//			close: '.close-meerkat',
//			animationIn: 'slide',
//			animationSpeed: 500,
//			removeCookie: '.reset'
//		});
//
//		$('.close-meerkat').on('click', function() {
//			if ($.cookie('mview') == 'PC') {
//				$('.FooteriPhoneLink').css({'margin-bottom':'0'});
//			} else {
//				$('.bottom_tagline').css({'margin-bottom':'0'});
//			}
//		});
//
//		if ($.cookie('mview') == 'PC') {
//			$('.FooteriPhoneLink').css({'margin-bottom':'120px'});
//		} else {
//			$('.bottom_tagline').css({'margin-bottom':'120px'});
//		}
//	}

});

$.fn.fadeHover = function() {
	$(this).hover(
		function() {
			$(this).stop().animate({'opacity': '0.6'}, 100);
		},
		function() {
			$(this).stop().animate({'opacity': '1'}, 300);
		}
	);
};