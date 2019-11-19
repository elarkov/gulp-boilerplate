//Mobile button sandwich
let sandwich = function () {
	$(document).on('click', '.sandwich', function () {
		$(this).toggleClass('sandwich--open');
		$('.header__nav').toggleClass('header__nav--open');
		$('body').toggleClass('hidden');
	});
};
sandwich();

$(document).ready(function() {
  function checkWidth() {
    let windowWidth = $('body').innerWidth(),
        elem = $(".menu__link");
    if(windowWidth < 576){
			elem.addClass('js-menu-link');
			$('.js-menu-link').click(function () {
				$('body').removeClass('hidden');
				$('.header__nav').removeClass('header__nav--open').slideUp(300);
				$('.sandwich').removeClass('sandwich--open');
			});
    }
    else{
      elem.removeClass('js-menu-link');
    }
	}

  checkWidth();

  $(window).resize(function(){
    checkWidth();
  });
});

//E-mail Ajax Send
$(".forma-order").submit(function () { 
	const form = $(this);
	$.ajax({
		type: "POST",
		url: "mail.php", 
		data: form.serialize()
	});
	return false;
});

//validate form script
$(function(){
	
	let modifiers = {
		formOrderOne: '.forma-order__one',
		formOrderSecond: '.forma-order__second',
	};
	
	let valid = {
		rules: {
				name: {
						required: true
				},
				phone: {
						required: true,
				}
		},
		focusCleanup: true,
		focusInvalid: false,

		submitHandler: function (form) {
			let form = $('.forma-order');
			$('.fancybox-container').fadeOut();
			$('body.compensate-for-scrollbar').css({overflow: 'auto', 'margin-right': '0'});
			$.fancybox.open({
				src: '#form-modal',
				type: 'inline',
				showCloseButton: 'hide',
				afterClose: function () {
					form.trigger("reset");
				}
			});
			
		},

		errorPlacement: function(error, element) {
				return true;
		}
	};
	
	$(modifiers.formOrderOne).validate(valid);
	$(modifiers.formOrderSecond).validate(valid);
});

$('.bottom-elems__btn').on('click', function(e) {
	e.preventDefault();
	$.fancybox.open( $('#popup-1'));
});

//Scrolling to page
$('.following-scroll').on( 'click', function(e){ 
	e.preventDefault();
	const el = $(this);
	const dest = el.attr('href');
	if(dest !== undefined && dest !== '') {
			$('html').animate({ 
				scrollTop: $(dest).offset().top
			}, 500
			);
	}
	return false;
});

/*customs scripts*/