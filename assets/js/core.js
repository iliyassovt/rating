$('document').ready(function(){

	
	initStars();

    $('body').on('submit', '.ajax-form', function(e){
		var form = $(this);	
		e.preventDefault();
		e.stopPropagation();
		
		if (!form.hasClass('sending')) {
			form.addClass('sending');
			$(form).ajaxSubmit({
				dataType: 'json',
				success: function(data){


					if (data.error != undefined){
						if (data.message != undefined) {
							if ( data.message == 'without_notice' )
								form.removeClass('sending');
							else if (data.message != '')
								setNotice(data.message, (data.error == 0) ? 'success' : 'warning');


						} else {
							setNotice((data.error == 0) ? 'Отправлено' : 'Ошибка', (data.error == 0) ? 'success' : 'warning');
						}

						if (data.error == 0) {
							if (data.reload != undefined){
								location.reload()
							}	
							if (data.redirect != undefined){
								location.href = data.redirect;
							} if (data.callback != undefined){
								window[data.callback](data);
							} else {
								if (!form.hasClass('notreset')) {
									form[0].reset();
									resetStars();
									$('#rating_select').prop('rating_department', '-');
									$('#rating_select').prop('rating_employee', '-');
								}
							}

						}
					}

				},
				complete: function(response){
					
					setTimeout(function(){
						form.removeClass('sending');
						
					}, 1000);

				},
				error: function(requestObject, error, errorThrown){
					setSystemErrorReport({
						link: form.attr('action'),
						text: requestObject.responseText
					});
					setNotice('Системная ошибка', 'warning');
				}
			})
		}
	})

})

function setNotice(mess, theme, delay, position) {

	if (delay == undefined) {
		delay = 6000;
	}
	if (position == undefined) {
		position = 'top';
	}

	var options = {
		appendTo: "body",
		customClass: 'cstm_notice',
		type: "info",
		offset:
		{
		   from: position,
		   amount: 30
		},
		align: "right",
		minWidth: 250,
		maxWidth: 400,
		delay: delay,
		allowDismiss: true,
		spacing: 10
	}

	if ($.simplyToast != undefined) {
		$.simplyToast(mess, theme, options);
	} else {
		alert(mess);
	}
}

function initStars() {
	var Loadblock = $('body');

	if (window.rating != undefined) {
       Loadblock.find('.c-rating:not(.init)').each(function(){

            var input_rating = $(this).find('input.rating_val');
            var readonly = false;
            if ($(this).attr('data-readonly') != undefined &&  $(this).attr('data-readonly'))
                readonly = true;

            $(this).addClass('init');
            window.rating(this, input_rating.val() , 5, function(rating){
                input_rating.val(rating);
            });

        })
    }
}

function resetStars() {

	$('.c-rating__item').remove();
	$('body').find('.c-rating.init').removeClass('init');
	$('input.rating_val').val('0');
	initStars()

}





