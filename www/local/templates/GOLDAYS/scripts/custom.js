function deleteBasketItem(id, th){
	if(id > 0){		
		th.parents('.owl-item').hide(400, function(){
			$(this).remove();
		});
		$(".not_basket").show();
		$(".in_basket").hide();
		$.ajax({
		  url: '/basket/delete_in_big_basket.php?id='+id,
		  success: function(data){
		  	if(data.SUCCESS){
				$('#small_basket').html(data.BASKET_HTML);
				smallBasket3Count();
                $("input[data-id='"+id+"']").remove();
			}
		  }
		});
	}
}

function smallBasket3Count(){
	var items_in_b = $('.header .basket_region>div').length;
	if(items_in_b<=3){
		$('.header .basket_region>div').each(function(e,i){
			//console.log(e);
			$(this).css({'left':e*80})
		})
	}
}

$(document).ready(function(){
	// Убрать на боевом
	$("html").css({'zoom':($(window).height()-1)/$("body").height()});
	
	
	$('#prostoi .close, #prostoi #cont_sess').on('click',function(){
		$('#prostoi, #overlay').fadeOut();
	})
	$('#tips .tip .name').on('click',function(){
		$(this).toggleClass('op');
		$(this).parent().find('>div').slideToggle('fast',function(){
			$('#tips .scrollable').jScrollPane({
			showArrows: true,
			verticalGutter: 0,
			arrowButtonSpeed: 18,
			trackClickSpeed: 54
		});
		});
	})
	$('#tips .close').on('click',function(){
		$('#tips, #overlay').fadeOut();
	})
	$('#showtips').on('click',function(){
		$('#tips, #overlay').fadeIn();
		$('#tips .scrollable').jScrollPane({
			showArrows: true,
			verticalGutter: 0,
			arrowButtonSpeed: 18,
			trackClickSpeed: 54
		});
	})

	smallBasket3Count();
	
//настройка слайдеров
    $('.slider').each(function(){
	    var next = $(this).siblings('.next');
		var prev = $(this).siblings('.prev');
		$(this).jCarouselLite({
			btnNext: next,
			btnPrev: prev,
			visible: 3,
			speed: 800,
			circular: false
			//auto:5000
		});
	});








//карусель товаров в корзине
    $('.basket_remove_items').on('click', function(){
		//$(this).parents('.owl-item').hide(400, function(){
		//	$(this).remove();
		//});
	});



	$(document).on('click', '.basket_bt', function(){

		if ($(".basket_popup").hasClass("closes")) {
			$('.slogan1').hide();
			$('.back_bt').hide();
			//$('.new_bt').hide();
			//$('.basket_r').css("left", "1354px")
			$('.basket_popup').removeClass("closes");
			$('.basket_popup').addClass("open");
			$('.basket_bt').addClass("rotate");
			var owl = $('.sliders');
			owl.owlCarousel({
			    loop:false,
			    margin:0,
			    items: 3,
			    mouseDrag: false,
			    touchDrag: false,
			    nav: false
			})
			$('.basket_slider_r .next').on('click', function(){
			    owl.trigger('next.owl.carousel');
			})

			$('.basket_slider_r .prev').on('click', function(){
			    owl.trigger('prev.owl.carousel');
			})
		}else{
			$('.slogan1').show();
			$('.back_bt').show();
			$('.new_bt').show();
			$('.basket_r').css("left", "954px")
			$('.basket_popup').removeClass("open");
			$('.basket_popup').addClass("closes");
			$('.basket_bt').removeClass("rotate");
		}
	});



	$('.close_basket').on('click', function(){
			$('.slogan1').show();
			$('.back_bt').show();
			$('.new_bt').show();
			$('.basket_r').css("left", "954px")
			$('.basket_popup').removeClass("open");
			$('.basket_popup').addClass("closes");
			$('.basket_bt').removeClass("rotate");
	});




	$('.slider-wrapper .delete').on('click', function(){
		$(this).parents('li').hide(400, function(){
			$(this).parents('.slider').jCarouselLite = null;
			var next = $(this).parents('.slider').siblings('.next');
			var prev = $(this).parents('.slider').siblings('.prev');
			next.unbind('click');
			prev.unbind('click');
			$(this).remove();
			$('.slider').jCarouselLite({
				btnNext: next,
				btnPrev: prev,
				visible: 3,
				speed: 800,
				circular: false
				//auto:5000
			});
		});
	});


//нестандартный селект (select)
	/*var i =0;
	$('select').each(function(){
		$(this).wrap('<div class="styled-select '+ $(this).attr('class') +'"></div>').after('<div class="select"></div><ul></ul>');
		$('option', this).each(function(){
			$(this).parents('select').siblings('ul').append('<li>'+$(this).text()+'</li>');
			if ($(this).attr('selected')=='selected'){
				$(this).parents('select').siblings('.select').text($(this).text());
			};
		});
		$(this).hide().parents('.wrapper_select').css('z-index', (999-i));
		i++;
	});
	$('.styled-select').on('click', function(){
		$(this).toggleClass('active').children('ul').slideToggle(300);
		var obj = $(this);
		$(document).click(function(event) {
			if ($(event.target).closest(obj).length) return;
			obj.removeClass('active').children('ul').slideUp(300);
			event.stopPropagation();
		});
	});
	$('.styled-select ul li').on('click', function(){
		var index=$(this).index();
		$(this).addClass('active').siblings('li').removeClass('active');
		$('.select', $(this).parents('.styled-select')).text($(this).text());
		$('select option', $(this).parents('.styled-select')).removeAttr('selected').eq(index).attr('selected','selected');
		$('select', $(this).parents('.styled-select')).val($('option:selected', $(this).parents('.styled-select')).val());
	});
*/

//боковое меню
    $('.menu-sidebar>ul>li:last').addClass('last');
	$('.menu-sidebar>ul>li').on('mouseover', function(){
	    $(this).addClass('active');
		var obj=$(this);
		function f_delay(){
			if (obj.hasClass('active')) {
				obj.children('ul').fadeIn(300);
			} else {
				obj.removeClass('active');
				obj.children('ul').fadeOut(300);
			};
		};
		setTimeout(f_delay, 600);
	});
	$('.menu-sidebar>ul>li').on('mouseleave', function(){
	    $(this).removeClass('active');
		var obj=$(this);
		function f_delay(){
			if (obj.hasClass('active')) {
				obj.children('ul').fadeIn(300);
			} else {
				obj.removeClass('active');
				obj.children('ul').fadeOut(300);
			};
		};
		setTimeout(f_delay, 200);
	});
	$('.menu-sidebar>ul>li>a>span, .menu-sidebar>ul>li>span>span').each(function(){
		$(this).text($(this).parents('span, a').siblings('ul').children('li:first').children('a').text());
	});
	$('.menu-sidebar>ul>li>ul>li>a').on('click', function(){
		$(this).parents('ul').siblings('a, span').children('span').text($(this).text());
	});

//нестандартный скроллбар
	$('.scrollable').each(function(){
		$(this).jScrollPane({
			showArrows: true,
			verticalGutter: 0,
			arrowButtonSpeed: 18,
			trackClickSpeed: 54
		});
	});

//переключение размеров колец
    $('.sizes span').on('click', function(){
	    if ($(this).hasClass('active')) {
			return false;
		} else {
		    $(this).addClass('active').siblings('span').removeClass('active');
		};
	});

//слайдер с миниатюрами
	$('.product .photosgallery-std').sliderkit({
		auto:false,
		mousewheel:false,
		shownavitems:3
	});
	$('.product2 .photosgallery-std').sliderkit({
		auto:false,
		mousewheel:false,
		shownavitems:3
	});

	$(document).on('click', '.sliderkit-go-next', function(){
		return false;
	});

//всплывающие окна
	/*$('.pop-up').each(function(){
		var hgt = ($(window).height()-$(this).outerHeight())/2;
		if (hgt<0){hgt=$(window).scrollTop(); $(this).css('position','absolute');} else {hgt=hgt|0; $(this).css('position','fixed');};
		$(this).css('top', hgt+'px');
	});*/ 
	/*$(window).resize(function(){
		$('.pop-up').each(function(){
			var hgt = ($(window).height()-$(this).outerHeight())/2;
			if (hgt<0){hgt=$(window).scrollTop(); $(this).css('position','absolute');} else {hgt=hgt|0; $(this).css('position','fixed');};
			$(this).css('top', hgt+'px');
		});
	});*/
	$('.pop-up .close').on('click', function(){
		$(this).parents('.pop-up').fadeOut(400);
		$('#overlay').fadeOut(400);
	});

	$('.open-sizes').on('click', function(){
		$('#size-select').fadeIn(400).siblings('#overlay').fadeIn(400);
	});
	$('.open-complements').on('click', function(){
		$('#window-complements').fadeIn(400, function(){
			$('.scrollable', this).jScrollPane({
				showArrows: true,
				verticalGutter: 0,
				arrowButtonSpeed: 18,
				trackClickSpeed: 54
			});
		});
		$('#overlay').fadeIn(400);
	});

});