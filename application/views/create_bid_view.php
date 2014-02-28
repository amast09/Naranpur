<div class="container-fluid">
	<h4 style="text-align:center;">Listing</h4>
	<div class="row-fluid" style="text-align:center;">
		<?php $lis = $listing->row(); ?>
					<div class="span3">
						<div id="fam"></div>
						<p><?=$lis->family_name;?></p>
					</div>
					<div class="span3">
						<div id="res"></div>
						<p><?=$lis->resource_name;?></p>
					</div>
					<div class="span3">
						<div id="qua"></div>
						<p><?=$lis->quantity;?></p>
					</div>
					<div class="span3">
						<div id="mes"></div>
						<p><?=$lis->message;?></p>
					</div>
	</div>

<hr></hr>

<h3>Create a Bid</h3>

	<div class="row-fluid">


		<form class="form form-horizontal" action="<?php echo site_url("/listing/create_bid");?>" onsubmit="return(validation());" method="POST">
			<div class="control-group">
				<label class="control-label" for="resource_select">Resource:</label>
				<div class="controls">
					<select id="resource_select" name="resource_id">
						<?php foreach($bid_inventory->result() as $row){ ?>
							<option value="<?=$row->id?>" data-quantity="<?=$row->quantity?>"><?=$row->name?></option>	
						<?php } ?>
					</select>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="quantity_select">Quantity:</label>
				<div class="controls">
					<input id="quantity_select" type="number" name="quantity" min="1" max="<?=$bid_inventory->row()->quantity;?>" step='1' value="1"/>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="message">Message:</label>
				<div class="controls">
					<textarea id="message" rows="1" class="span6" name="message" placeholder="What are you looking for in return..."></textarea>
				</div>
			</div>
			<div class="control-group">
				<div class="controls">
					<button id="bid_button" type="submit" class="btn btn-primary"><i class="icon-list"></i> Create Bid</button>
				</div>
			</div>

			<input type="hidden" name="listing_id" value="<?php echo $listing_id;?>"/>
		</form>

		<div id="bid_error" class="alert alert-block alert-error" style="display:none;">  
		 	<a class="close" onclick="$('#bid_error').hide()">X</a>  
			<h4 class="alert-heading">Error!</h4>  
			<p id="bid_error_message"></p>
		</div> 

	</div>
</div>

<script src="<?=base_url("/resources/create_bid_view/js/createBid.js");?>"></script>
