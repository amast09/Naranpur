$(function() {
	var validator = new FormValidator('reply', [{
		name: 'message',
		rules: 'required|alpha_dash'
	}], function(errors, event) {
			if (errors.length > 0) {
				$(".control-group").addClass('error');
				$(".help-inline").text(errors[0].message);
			}
	});

	$(".reply-box").on("keydown", function() {
			$(".control-group").removeClass("error");
			$(".help-inline").text("");
	});
	
});
