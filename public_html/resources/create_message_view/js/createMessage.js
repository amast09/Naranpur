$(function() {
	var familyObject = $.parseJSON($("#families").attr("data-current-families"));
	var families = $.map(familyObject, function(element, index){
		return(element.name);
	});

	$( "#families" ).autocomplete({ source : families });

	$('#send_button').click(function() {
		$.ajax({
			type: "post",
			url: $("#message_form").attr("data-submit-url"),
			data: $("#message_form").serialize(),
			dataType: "json",
			success: function(data){
				if(data.success){
					window.location.assign($("#message_form").attr("data-redirect-url"));
				}
				else{
					$('#message_error').show();
					$('#message_error_message').html(data.message);
				}
			}
		});
	});

});
