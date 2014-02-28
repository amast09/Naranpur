$(function() {

$('input').change( function() { $('#error').hide();  });


	$("button").on("click", function(event){
		event.preventDefault();
		var data = $("#new-family").serialize();
		var submitUrl = $("#new-family").attr("data-url");

		$.ajax({
			type: "POST",
			url: submitUrl,
			data: data,
			dataType: "json",
			success: function(data){
				if(data.success) window.location.assign('<?=site_url("dashboard");?>');
				else{
					$('#error').slideDown();
					$('#error-message').html(data.message);
				}
			}
		});
	});
});
