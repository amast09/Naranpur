$(function() {

	$('input').change( function() { $('#error').hide();  });

	$("button").on("click", function(event){
		event.preventDefault();
		var data = $("#new-family").serialize(),
				submitUrl = $("#new-family").attr("data-url"),
				redirectUrl = $("#new-family").attr("data-redirect-url");

		$.ajax({
			type: "POST",
			url: submitUrl,
			data: data,
			dataType: "json",
			success: function(data){
				if(data.success) window.location.assign(redirectUrl);
				else{
					$('#error').slideDown();
					$('#error-message').html(data.message);
				}
			}
		});
	});

});
