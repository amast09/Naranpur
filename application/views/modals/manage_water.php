<div id="water" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="waterLabel" aria-hidden="true">
	<div class="modal-header">
		<h4>Collect Water<button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button></br></h4>
	</div>
	
	<div class="modal-body">

		<select id="methodSelect">
			<option value="-1">Choose a Collection Method</option>
			<?php foreach($water_methods->result() as $row){ ?>
	  			<option value="<?=$row->id;?>">
					<?=$row->method;?>
				</option>
			<?php } ?>
		  	<option value="well-method">Well</option>
		</select>

		<div id="body" style="display:none;">
			<dl class="dl-horizontal">
				<dt>Collecting Method:</dt>
					<dd id="method"></dd>
				<dt>Collecting FLUs:</dt>
					<dd id="hours"></dd>
				<dt>Collecting Yield:</dt>
					<dd id="rate"></dd>
			</dl>

			<hr/>

			<div class="input-prepend">
				<div class="input-append">
					<span class="add-on">
						<i class="icon-time"></i>
					</span>
					<input class="span5" id="updatedHours" type="text" placeholder="Collecting FLUs">
					<button id="update-hours" class="btn btn-info" type="button">Update FLUs</button>
				</div>
			</div>

			<div id="update_well" style="display:none;">
				<div class="input-prepend">
					<div class="input-append">
						<span class="add-on">
							<i class="icon-cog"></i>
						</span>
						<select class="span5" id="well_select">
							<?php foreach($well_options->result() as $well){ ?>
	 							<option value="<?=$well->id;?>" data-cost="<?=$well->cost?>">
									Type: <?=$well->type;?> / Rate: <?=$well->pumpingRate;?> / Cost: $<?=$well->cost;?> 
								</option>
							<?php } ?>
						</select>
						<button class="btn btn-info" id="buy_well">Install Well</button>	
					</div>
				</div>
			</div>
		</div>

		<div id="water_error" class="alert alert-block alert-error span6" style="display:none; position:fixed; bottom:10px;">
  			<a class="close" onclick="$('#water_error').hide();">X</a>
  			<h4 class="alert-heading">Error!</h4>
			<p id="water_error_message"></p>
		</div>

	</div>
</div>
