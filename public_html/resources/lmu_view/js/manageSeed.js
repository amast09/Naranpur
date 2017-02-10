$(function(){
	var crop = 0,
			seed = 0,
			labor = 0,
			bpus = 0,
			req = parseFloat($("option:selected", "#crop_id").data('req')),
			$lmu = $("#rsr"),
			planted = parseFloat($lmu.attr("data-percent-planted")),
			acres = parseFloat($lmu.attr("data-acres")),
			siteUrl = $("#site").attr("data-site-url");

	$("#crop_slider").slider({
			min: 0,
			max: 100,
			value: 0,
			step: 1,

			slide: function(event, ui) {
				crop = ui.value;
				if((crop + planted) > 100){
					crop = 100 - planted;
				}
				seed  = req * acres * crop / 100;
				labor = acres * crop / 100;
				bpus   = labor * 3;
				$("#plant_info").text("Plant Percent: " + crop + "%, Seed: " + seed.toFixed(3) + " kg, Labor: " + labor.toFixed(3) + " FLUs, " + bpus.toFixed(3) + " BPUs");
				$("#land_percentage").val(crop);
				$("#seed_req").val(seed);
				setTimeout(function(){
					$('#crop_slider').slider('value', crop);
				}, 500);
				$('#error').hide();
			}
	});

	$("#crop_id").change(function () {
		req = parseFloat($('option:selected', this).data('req'));
		crop = 0;
		seed = req * acres * crop / 100;
		labor = acres * crop / 100;
		bpus  = labor * 3;
		$("#resource_id").val($('option:selected', this).data('resource_id'));
		$("#land_percentage").val(0);
		$('#crop_slider').slider('value', 0);
		$("#plant_info").text("Plant Percent: " + crop + "%, Seed: " + seed.toFixed(3) + " kg, Labor: " + labor.toFixed(3) + " FLUs, " + bpus.toFixed(3) + " BPUs" );
		$('#error').hide();
	});

	function plant(){
		$.ajax({
			type: 'POST',
			url: siteUrl + '/lmu/validate_planting',
			data: $('#plant_form').serialize(),
			dataType: 'json',
			success: function(data){
				if($('#land_percentage').val() !== 0) {

					if(data.success) {
						$('#plant_form').submit();
					} else {

						if(data.fail == 'seed') {
							$('#error_message').text("You do not have sufficent seed to plant this much crop.");
						} else {
							$('#error_message').text("You don't have enough family members to start this task.  Adjust your other management decisions to release a family member's time");
						}

						$('#error').show("slide", { direction: "down" }, 'fast');
					}

				} else {
					$('#error_message').text("You must choose a percentage of your field to plant.");
					$('#error').show("slide", { direction: "down" }, 'fast');
				}
			}
		});
	}

	$("#plant-crop").on("click", plant);
});
