$(function(){

	var well = "";
	var siteUrl = $("#site").attr("data-site-url");
	var lmuId = $("#rsr").attr("data-lmu-id");

	// Show the right view depending on the water collection type
	$('#methodSelect').change(function () {
		if($('#methodSelect option:selected').val() == -1){
			$('#body').hide();
			$('#error').hide();
		}
		else if($('#methodSelect option:selected').val() === "well-method"){
			$('#water-error').hide();
			update_well();
		}
		else{
			update();
			$('#water-error').hide();
			$('#body').show();
		}
	});

	// When a user clicks to update their collection hours
	$('#update-hours').on('click', function () {
		// First check if it is valid by checking how many spare labor hours they have
		$.ajax({
			type: "POST",
			url: siteUrl + "/water/check_hours",
			data: {
				'hours': $('#updatedHours').val(),
				'method_id': $('#methodSelect option:selected').val(),
				'lmu_id': lmuId
			},
			dataType: "json",
			success: function(data){
				// If they have enough labor hours for this update
				if(data.success == 1){
					// If the collection method isn't the well collection
					if($('#methodSelect option:selected').val() !== "well-method"){
						// Update the non-well collection method hours
						$.ajax({
							type: "POST",
							url: siteUrl + "/water/update_method",
							data: {
								'hours': $('#updatedHours').val(),
								'method_id': $('#methodSelect option:selected').val(),
								'lmu_id': lmuId
							},
							dataType: "json",
							success: update()
						});
					}
					else{
						// Update well collection hours
						$.ajax({
						type: "POST",
							url: siteUrl + "/water/update_well_hours",
							data: {
								'hours': $('#updatedHours').val(),
								'lmu_id': lmuId
							},
							dataType: "json",
							success: update_well
						});
					}
				}
				else{
					// They didn't have enough labor hours for this update, show error message
					if(data.fail == 'form')
						$('#water_error_message').text("Please enter a numerical value.");
					else
						$('#water_error_message').text("You don't have enough family members to start this task.  Adjust your other management decisions to release a family member's time");
						$('#water_error').show("slide", { direction: "down" }, 'fast');
				}
			}
		});
	});

	// Buy well button clicked, then run backend to buy well
	$('#buy_well').on('click', function () {
		$('#water-error').hide();
		if(well == $('#well_select option:selected').val()){
			$('#water_error_message').text("The well is already of this type.");
			$('#water_error').show("slide", { direction: "down" }, 'fast');
		}
		else{
			$.ajax({
				type: "POST",
				url: siteUrl + "/water/buy_well",
				data: {
					'well_type_id': $('#well_select option:selected').val(),
					'lmu_id': lmuId,
					'cost': $('#well_select option:selected').data('cost')
				},
				dataType: "json",
				success: function(data){
					if(data.success == 1){
						update_well();
					}
					else{
						$('#water_error_message').text("You do not have the funds to upgrade to this well");
						$('#water_error').show("slide", { direction: "down" }, 'fast');
					}
				}
			});
		}
	});

	// Updates non-well collection view
	function update(){
		$.ajax({
			type: 'POST',
			url: siteUrl + '/water/get_method',
			data: 'method_id=' + $('#methodSelect option:selected').val(),
			dataType: 'json',
			success: function(data){
				$('#update_well').hide();
				$('#method').text(data[0].method);
				$('#hours').text(data[0].hours);
				var rate = data[0].hours * data[0].rate * 7;
				$('#rate').text(rate+' L/wk');
			}
		});
	}

	// Updates the well view
	function update_well(){
		$.ajax({
			type: 'POST',
			url: siteUrl + '/water/get_well',
			data: 'lmu_id=' + lmuId,
			dataType: 'json',
			success: function(data){
				$('#update_well').show();
				$('#body').show();
				$('#method').text(data[0].type + ' well');
				$('#hours').text(data[0].hours);
				var rate = data[0].hours * data[0].pumpingRate * 7;
				$('#rate').text(rate+' L/wk');
				well = data[0].well_type_id;
			}
		});
	}

});