<div id="plant" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="plantLabel" aria-hidden="true">
	<div class="modal-header">
		<h4>Plant Crops<button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button></br></h4>
	</div>
	
	<div class="modal-body">
		<?php if($available_crops->num_rows() > 0){ ?>
			<form id="plant_form" class="form-horizontal" action='<?=site_url('lmu/plant_crop');?>' method="POST">
				<div class="control-group">
					<select id="crop_id" name="crop_id">
						<?php foreach($available_crops->result_array() as $ac){ ?>
							<option value="<?=$ac['id'];?>"
								data-req="<?=$ac['seed_req']; ?>"
								data-resource_id="<?=$ac['resource_id']; ?>"
								data-crop_name="<?=$ac['name']; ?>">
								<?=$ac['name']; ?>
							</option>
						<?php } ?>
					</select>
				</div>

				<div class="control-group">
					<h5 id="plant_info">Plant Percent: 0%, Seed: 0.000 kg, Labor: 0.000 FLUs, 0.000 BPUs</h5>
					<div id="crop_slider"></div>
				</div>

				<input type="hidden" name="lmu_id" value="<?=$lmu_id;?>"/>
				<input type="hidden" id="resource_id" name="resource_id" value="<?=$available_crops->row()->resource_id?>"/>
				<input type="hidden" id="seed_req" name="seed_req" value=""/>
				<input type="hidden" id="land_percentage" name="land_percentage" value="0"/>

				<div class="control-group">
					<a class="btn btn-success" href="javascript: plant()">Plant</a>
				</div>
			</form>
		<?php } ?>

		<div id="error" class="alert alert-blocki alert-error span6" style="display:none; position:fixed; bottom:10px;">
  			<a class="close" onclick="$('#error').hide()">X</a>
  			<h4 class="alert-heading">Error!</h4>
			<p id="error_message"></p>
		</div>
	</div>
</div>

<script>
var crop = 0;
var seed = 0;
var labor = 0;
var req = $("option:selected", "#crop_id").data('req');
var planted = <?php echo $percent_planted; ?>;
var acres = <?php echo $acres; ?>;

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
			bpus   = labor*3;
			$("#plant_info").text("Plant Percent: " + crop + "%, Seed: " + seed.toFixed(3) + " kg, Labor: " + labor.toFixed(3) + " FLUs, " + bpus.toFixed(3) + " BPUs");
			$("#land_percentage").val(crop);
			$("#seed_req").val(seed);
			setTimeout("$('#crop_slider').slider('value', crop);", 500);
			$('#error').hide();
    }
});

$("#crop_id").change(function () {
	req = $('option:selected', this).data('req');
	crop = 0;
	seed = req * acres * crop / 100;
	labor = acres * crop / 100;
        bpus  = labor*3;
	$("#resource_id").val($('option:selected', this).data('resource_id'));
	$("#land_percentage").val(0);
	$('#crop_slider').slider('value', 0);
	$("#plant_info").text("Plant Percent: " + crop + "%, Seed: " + seed.toFixed(3) + " kg, Labor: " + labor.toFixed(3) + " FLUs, " + bpus.toFixed(3) + " BPUs" );
	$('#error').hide();
});

function plant(){
	$.ajax({
    type: 'POST',
    url: '<?=site_url()?>/lmu/validate_planting',
    data: $('#plant_form').serialize(),
    dataType: 'json',
    success: function(data){
			if($('#land_percentage').val() != 0){
				if(data.success){
					$('#plant_form').submit();
				}
				else{
					if(data.fail == 'seed')
						$('#error_message').text("You do not have sufficent seed to plant this much crop.");
					else
						$('#error_message').text("You don't have enough family members to start this task.  Adjust your other management decisions to release a family member's time");
					$('#error').show("slide", { direction: "down" }, 'fast');
				}
			}
			else{
				$('#error_message').text("You must choose a percentage of your field to plant.");
				$('#error').show("slide", { direction: "down" }, 'fast');
			}
    }
  });
}

</script>