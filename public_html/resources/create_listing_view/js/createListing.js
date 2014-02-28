$(function() {

	$('#resource_select').change(function () {
		$('#quantity_select').val(1).attr("max", $('option:selected', this).data("quantity"));
		$('#list_error').hide();
		$('#list_button').removeAttr("disabled");
	});

	$('#quantity_select').change(function () {
		if(isNaN($('#quantity_select').val()) === true || $('#quantity_select').val() === "" || $('#quantity_select').val() < 1){
			$('#list_button').attr("disabled", "disabled");
			$('#list_error_message').text("You must enter a valid number.");
			$('#list_error').show("slide", { direction: "down" }, 'fast');
		}
		else if(parseInt($('#quantity_select').val(), 10) > parseInt($('#quantity_select').attr('max'), 10)){
			$('#list_button').attr("disabled", "disabled");
			$('#list_error_message').text("You do not have sufficent inventory for this listing.");
			$('#list_error').show("slide", { direction: "down" }, 'fast');
		}
		else{
			$('#list_error').hide();
			$('#list_button').removeAttr("disabled");
		}
	});

});

