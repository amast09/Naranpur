$(function() {

	$('input').change( function() { $('#error').hide();	});


	$("#change_button").on("click", function(event){
		event.preventDefault();

		$.ajax({
			type: "post",
			url: $("#change-password").attr("data-url"),
			data: $("#change-password").serialize(),
			dataType: "json",
			success: function(data){
				if(data.success){
					$('#success').slideDown();
					$('#success_message').text(data.message);
					$('#pwd0').val('');
					$('#pwd1').val('');
					$('#pwd2').val('');
				}
				else{
					$('#error').show();
					$('#error_message').html(data.message);
				}
			}
		});
	});

});
