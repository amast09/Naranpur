$(function(){
	$('#comment_button').click(function() {
		$.ajax({
			type: "post",
			url: $("#comment-form").attr("data-submit-url"),
			data: $("#comment-form").serialize(),
			dataType: "json",
			success: function(data){
				if(data.success) {
					window.location.assign($("#comment-form").attr("data-redirect-url"));
				}
				else {
					$('#comment_error').show("slide", { direction: "down" }, 'fast');
					$('#comment_error_message').html(data.message);
				}
			}
		});
	});
});
