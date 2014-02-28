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

<h4 style="text-align:center;">Current Bids</h4>
<div class="row-fluid">
<?php if($bids->num_rows() > 0) { ?>
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Family</th>
				<th>Resource</th>
				<th>Quantity</th>
				<th>Message</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($bids->result() as $row){ ?>
				<tr>
					<td class="span1"><?=$row->family_name;?></td>
					<td class="span2"><?php echo $row->resource_name;?></td>
					<td class="span1"><?php echo $row->quantity;?></td>
					<td class="span8">
						<textarea rows="1" class="span12" placeholder="<?php echo $row->message;?>" disabled></textarea>
					</td>
					<?php if($listing->row()->family_name  == $family_name){ ?>
						<td>
							<form class="form" action="<?php echo site_url();?>/listing/accept_bid" method="POST">							
								<input type="hidden" name="bid_id" value="<?php echo $row->id;?>"/>
								<input type="hidden" name="listing_id" value="<?php echo $listing->row()->id;?>"/>
								<button type="submit" class="btn btn-primary"><i class="icon-ok"></i> Accept Bid</button>
							</form>
						</td>
					<?php } ?>
				</tr>
			<?php } ?>
		</tbody>
	</table>
<?php } else {?>
	<h3>No Bids Yet.</h3>
<?php } ?>

<?php if($listing->row()->family_name  != $family_name){ ?>
		<a href="<?php echo site_url();?>/listing/load_create_bid/<?php echo $listing->row()->id;?>" class="btn btn-primary">Make Bid</a>
<?php } else{ ?>
	<a href="<?php echo site_url();?>/listing/delete_listing/<?=$listing->row()->id;?>" class="btn btn-danger">Delete Listing</a>
<?php } ?>

</div>
</div>
