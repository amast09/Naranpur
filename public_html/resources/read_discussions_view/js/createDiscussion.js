$(function(){
	$('#discussion_button').click(function() {
		$.ajax({
			type: "post",
			url: $("#discussion").attr("data-submit-url"),
			data: $("#discussion").serialize(),
			dataType: "json",
			success: function(data){
				if(data.success) {
					window.location.assign($("#discussion").attr("data-redirect-url"));
				}
				else {
					$('#discussion_error').show("slide", { direction: "down" }, 'fast');
					$('#discussion_error_message').html(data.message);
				}
			}
		});
	});
});