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
					<a class="btn btn-success" id="plant-crop">Plant</a>
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
