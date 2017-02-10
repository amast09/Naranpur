$(function() {
	$('#resource_select').change(function () {
		$('#quantity_select').val(1).attr("max", $('option:selected', this).data("quantity"));
		$('#bid_error').hide();
		$('#bid_button').removeAttr("disabled");
	});

	$('#quantity_select').change(function () {
		if(isNaN($('#quantity_select').val()) === true || $('#quantity_select').val() === "" || $('#quantity_select').val() < 1){
			$('#bid_button').attr("disabled", "disabled");
			$('#bid_error_message').text("You must enter a valid number.");
			$('#bid_error').show("slide", { direction: "down" }, 'fast');
		}
		else if(parseInt($('#quantity_select').val(), 10) > parseInt($('#quantity_select').attr('max'), 10)){
			$('#bid_button').attr("disabled", "disabled");
			$('#bid_error_message').text("You do not have sufficent inventory for this bid.");
			$('#bid_error').show("slide", { direction: "down" }, 'fast');
		}
		else{
			$('#bid_error').hide();
			$('#bid_button').removeAttr("disabled");
		}
	});

});