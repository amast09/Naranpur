$(function() {
	$('input').change( function() { $('#error').hide();  });

	$("#login_button").on("click", function(event){
		$.ajax({
			type: "post",
			url: $("#login").attr("data-url"),
			data: $("#login").serialize(),
			dataType: "json",
			success: function(data){
				if(data.success) window.location.assign($("#login").attr("data-redirect-url"));
				else{
					$('#error').slideDown();
					$('#error_message').text("Invalid Name or Password");
				}
			}
		});
	});
});

