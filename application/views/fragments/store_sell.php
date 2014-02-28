<form id="sell" class="horizontal" action="<?php echo site_url();?>/store/sell" method="POST"> 

	<div class="control-group">
		<select class="resource" name="sellItem">
			<?php foreach($sell_inventory->result() as $sell_item){ ?> 
				<option value="<?php echo $sell_item->id; ?>" data-quantity="<?php echo $sell_item->quantity?>" data-price="<?php echo $sell_item->sellPrice?>">
					<?php echo $sell_item->name;?>
					<?php if ($sell_item->id!=2 && $sell_item->id!=13) { echo "[",$sell_item->unit,"]"; } ?>
					<?php echo "$".$sell_item->sellPrice; ?>
				</option>
			<?php } ?>
		</select>
	</div>

	<div class="control-group">
		<input class="quantity" name="sellQuantity" type="number" min="1" max="<?=$sell_inventory->row()->quantity;?>" step="1" value="0"/>
	</div>

	<div class="control-group">
		<button class="btn btn-primary" type="submit">Sell</button>
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