<form id="buy" class="horizontal" action="<?php echo site_url("/store/buy");?>" method="POST"> 

	<div class="control-group">
		<select class="resource" name="buyItem">
			<?php foreach($buy_inventory->result() as $buy_item){ ?> 
				<option value="<?php echo $buy_item->id; ?>" data-quantity="<?php echo $buy_item->quantity;?>" data-price="<?php echo $buy_item->buyPrice;?>">
					<?php echo $buy_item->name;?>
					<?php if ($buy_item->id!=2 && $buy_item->id!=13) { echo "[",$buy_item->unit,"]"; } ?>
					<?php echo "&nbsp;$".$buy_item->buyPrice; ?>
				</option>
			<?php } ?>
		</select>
	</div>

	<div class="control-group">
		<input class="quantity" type="number" name="buyQuantity" min="1" max="<?=$buy_inventory->row()->quantity;?>" step='1' value="0"/>
	</div>

	<div class="control-group">
		<button class="btn btn-primary">Buy</button>
	</div>

	<div class="control-group">
		<input type="text" class="cost" value="Price: $0" disabled/>
	</div>

	<div class="control-group">
		<input type="text" class="newCash" value="Updated Cash: $<?php echo $cash; ?>" disabled/>
	</div>

	<div class="alert alert-block alert-error" style="display:none;">  
	  <h4 class="alert-heading">Error!</h4>  
		<p class="error_message"></p>
	</div>

</form>
