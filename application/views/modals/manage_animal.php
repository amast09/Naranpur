<div id="feed" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="feedLabel" aria-hidden="true">
	<div class="modal-header">
		<h4>Manage Livestock<button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button></br></h4>
	</div>

	<div class="modal-body" id="animal-management">
		<form id="feed_policy">
			
			<select id="animalSelect" name="animal_id">
				<option value="-1">Choose an Animal</option>
				<?php foreach($animals->result() as $row){ ?>
					<option value="<?=$row->id;?>" data-quantity="<?=$row->quantity;?>">
						<?=$row->resource;?>
					</option>
				<?php } ?>
			</select>

			<div id="animalBody" style="display:none;">
				<ul class="nav nav-list">
					<li class="nav-header">Animal Policy</li>
					<li>Collecting Manure: <i id="manure_icon" style="cursor:pointer;"></i></li>
		 	 		<li id="feed_method"></li>
					<li id="animal"></li>
				</ul>
		
				<ul id="reqs" class="nav nav-list">
				</ul>

				<ul class="nav nav-list">
					<li class="nav-header">Update Feeding Method</li>
					<li>
						<select id="feedMethodSelect" name="feed_method_id"></select>
						<a style="display:none;" id="updateFeedMethod" class="btn pull-right">Update</a>
					</li>
				</ul>
			</div>
		</form>

		<div id="manure_error" class="alert alert-block alert-error span6" style="display:none; position:fixed; bottom:10px;">
			<a class="close" onclick="$('#manure_error').hide();">X</a>
			<h4 class="alert-heading">Error!</h4>
			<p id="manure_error_message"></p>
		</div>
	</div>
</div>
