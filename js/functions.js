( function( $ ) {
	$('.toggle-menu').click(function(){
		$('body').toggleClass('on');
		var _toggle_menu = $(this).children('span');
		if(_toggle_menu.hasClass('genericon-menu')){
			_toggle_menu.removeClass('genericon-menu').addClass('genericon-close-alt');
		}else{
			_toggle_menu.removeClass('genericon-close-alt').addClass('genericon-menu');
		}
	});
	$('.toggle-search').click(function(){
		$('.head-search').toggle();
		var _toggle_menu = $(this).children('span');
		if(_toggle_menu.hasClass('genericon-search')){
			_toggle_menu.removeClass('genericon-search').addClass('genericon-close');
		}else{
			_toggle_menu.removeClass('genericon-close').addClass('genericon-search');
		}
	});
	$(window).scroll(function() {
		var st = $(this).scrollTop(),
		backToTop = $('.go-top');
		if (st > 200) {
			backToTop.css('bottom','130px');
		} else {
			backToTop.css('bottom','-50px');
		}
	});
	$('.go-top').on('click',function(){
		$("html,body").animate({
			scrollTop: 0
		},
		800);
	});
	$('.dianp').on('click',function(){
		alert('点个 p 点！');
	});
} )( jQuery );
