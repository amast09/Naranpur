$(function(){
	var siteUrl = $("#site").attr("data-site-url");

	$('#animalSelect').change(function () {
		if($('#animalSelect option:selected').val() == -1){
			$('#animalBody').hide();
		}
		else{
			populateMethods();
			updatePolicy();
			$('#updateFeedMethod').hide();
			$('#animalBody').show();
		}
	});

	$('#feedMethodSelect').change(function () {
		if($('#feedMethodSelect option:selected').text() === ''){
			$('#updateFeedMethod').hide();
		}
		else{
			$('#updateFeedMethod').show();
		}
	});

	$('#updateFeedMethod').click(function () {
		var data = $("#feed_policy").serialize();
		$.ajax({
			type: "POST",
			url: siteUrl + "/animal/update_animal_policy",
			data: data,
			dataType: "json",
			success: function(data){
				$('#updateFeedMethod').hide();
				updatePolicy();
			}
		});
	});

	$('#manure_icon').click(function() {
		var data = $("#feed_policy").serialize();
		$.ajax({
			type: 'POST',
			url: siteUrl + "/animal/toggle_manure",
			data: data,
			dataType: 'json',
			success: function(data){
				if(!data.success){
					$('#manure_error_message').text("You don't have enough family members to start this task.  Adjust your other management decisions to release a family member's time");
					$('#manure_error').show("slide", { direction: "down" }, 'fast');
				}
				if(data.manure){
					$('#manure_icon').removeClass('icon-checkbox-unchecked').addClass('icon-checkbox-checked');
				}
				else{
					$('#manure_icon').removeClass('icon-checkbox-checked').addClass('icon-checkbox-unchecked');
				}
			}
		});
	});

	function populateMethods(){
		$.ajax({
			type: "POST",
			url: siteUrl + "/animal/get_feed_methods",
			dataType: "json",
			success: function(data){
				var html = '<option value="-1"></option>';
				for(var i = 0; i < data.length; i++){
					html += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
				}
				$('#feedMethodSelect').empty().append(html);
			}
		});
	}

	function updatePolicy(){
		$.ajax({
			type: 'POST',
			url: siteUrl + "/animal/get_animal_policy",
			data: 'animal_id=' + $('#animalSelect option:selected').val(),
			dataType: 'json',
			success: function(data){
				$('#feed_method').text('Feeding Method: ' + data[0].method);
				$('#animal').text('Size of herd: ' + data[0].quantity);
				if(Number(data[0].manure) === 0) {
					$('#manure_icon').removeClass('icon-checkbox-checked').addClass('icon-checkbox-unchecked');
				}
				else {
					$('#manure_icon').removeClass('icon-checkbox-unchecked').addClass('icon-checkbox-checked');
				}

				$nAnimals = data[0].quantity;
				$collect = data[0].manure;

				$.ajax({
					type: 'POST',
					url: siteUrl + "/animal/get_feed_method",
					data: 'id=' + data[0].id,
					dataType: 'json',
					success: function(data){
						var html = '<li class="nav-header">Food Consumed</li>';
						
						for(var i = 0; i < data.length; i++) {
							html += '<li><strong>Resource:</strong>&nbsp;' + data[i].resource + '&nbsp;<strong>Quantity:</strong>&nbsp;' + (data[i].quantity/52.0).toFixed(3) + ' kg/wk' + '</li>';
						}

						html += '<li class="nav-header">Produced</li>';

						if($('#animalSelect option:selected').val() == 2) {
							html += ('<li><strong>Milk Produced</strong>&nbsp;' + (data[0].milkProduced/52.0).toFixed(3) + ' L/wk/animal x ' + $nAnimals + ' animals' + ' = ' + (data[0].milkProduced*$nAnimals/52.0).toFixed(3) + ' L/wk'+'</li>');
							html += ('<li><strong>Labor Produced</strong>&nbsp;' + 0 + '</li>');
							html += ('<li><strong>Fertilizer Produced</strong>&nbsp;' + $collect*data[0].fertilizerProduced + ' kg/wk/animal' + ' x ' + $nAnimals + ' animals = ' + $collect*data[0].fertilizerProduced*$nAnimals + ' kg/wk' + '</li>');
						} else {
							html += ('<li><strong>Milk Produced</strong>&nbsp;' + 0 + '</li>');
							html += ('<li><strong>Labor Produced</strong>&nbsp;' + '10 BPUs/animal x ' + $nAnimals + ' animals = ' + 10*$nAnimals + ' BPUs' + '</li>');
							html += ('<li><strong>Fertilizer Produced</strong>&nbsp;' + $collect*data[0].fertilizerProduced + ' kg/wk/animal' + ' x ' + $nAnimals + ' animals = ' + $collect*data[0].fertilizerProduced*$nAnimals + ' kg/wk' + '</li>');
						}
					
						$('#reqs').empty().append(html);

					}
				});
			}
		});
	}
});