$(function() {
	var validator = new FormValidator('reply', [{
		name: 'message',
		rules: 'required'
	}], function(errors, event) {

			if(errors.length > 0) {
				$(".control-group").addClass('error');
				$(".help-inline").text(errors[0].message);
			} else {
				$.ajax({
					type:	'POST',
					url:	$(this.form).attr("action"),
					data:	$(this.form).serializeArray(),
					dataType:	'json'
				}).done(function(data) {
					if(data.success === true) {
						$(".reply-box").val("");
						var messageHtml = '' +
							'<div class="row-fluid">' +
								'<div class="message span8 offset2">' +
									'<div class="message-info row-fluid">' +
										'<div class="sender span6">' +
											'<h4>' + data.sender + '</h4>' +
										'</div>' +
										'<div class="date-sent span6">' +
											'<h5>' + data.date_sent + '</h5>' +
										'</div>' +
									'</div>' +
									'<div class="row-fluid">' +
										'<div class="text">' + data.message + '</div>' +
									'</div>' +
								'</div>' +
							'</div>';
						$(messageHtml).prependTo(".all-messages").hide().fadeIn('3000');
					}
					else {
						$(".control-group").addClass('error');
						$(".help-inline").text("There was an error processing your message. Please try again later. Thanks!");
					}
				});
				event.preventDefault();
			}
	});

	$(".reply-box").on("keydown", function() {
			$(".control-group").removeClass("error");
			$(".help-inline").text("");
	});
	
});
