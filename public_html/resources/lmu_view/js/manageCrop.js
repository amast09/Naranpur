$(function(){
	var siteUrl = $("#site").attr("data-site-url");

	$('i').on('click', function() {
		var $lmu = $(this).closest('tr'),
				data = {
					lmu_id: $lmu.data('lmu_id'),
					crop_id: $lmu.data('crop_id'),
					field: $lmu.data('field')
				},
				$icon = $(this);

		$.ajax({
			type: "POST",
			url: siteUrl + "/lmu/cultivate_crop",
			data: data,
			dataType: "json",
			success: function(data){
				if(!data['water']){
					$('#cult_warn').show("slide", { direction: "down" }, 'fast');
					$('#cult_warn_message').text("You don't have enough water available to irrigate this field, but irrigation will now be applied if water becomes available.");
				}
				else{
					$('#cult_warn').hide();
				}
				if(!data['seed']){
					$('#seed_error').show("slide", { direction: "down" }, 'fast');
					$('#seed_error_message').text("You don't have enough family members to start this task.  Adjust your other management decisions to release a family member's time");
				}
				else{
					$('#seed_error').hide();
				}

				if(data['checked'] === "1"){
					$icon.removeClass('icon-remove');
					$icon.addClass('icon-ok');
				}
				else{
					$icon.removeClass('icon-ok');
					$icon.addClass('icon-remove');
				}
			}
		});
	});

	$('#removeCrop').click(function() {
		var $lmu = $(this),
				data = {
					'lmu_id': $lmu.data('lmu_id'),
					'crop_id': $lmu.data('crop_id')
				};

		$.ajax({
			type: "POST",
			url: siteUrl + "/lmu/remove_crop",
			data: data,
			dataType: "json",
			success: function(data){
				location.reload();
			}
		});
	});

});