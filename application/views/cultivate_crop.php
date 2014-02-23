<div class="container-fluid">
	<?php foreach($planted_crops->result() as $ac){ ?>
		<h5 style="color:green; cursor:pointer;" onclick="$('#<?=$ac->id;?>').toggle()">
			<?=$ac->name;?>
		</h5>

		<div id="<?=$ac->id;?>" style="display:none;">


		<table  class="table table-striped table-condensed">

			<tr data-lmu_id="<?=$ac->lmu_id;?>" data-crop_id="<?=$ac->id;?>">
				<td data-field="irrigation">
				Irrigation
				<i style="cursor:pointer;" class="pull-right <?php echo ($ac->irrigation) ? 'icon-ok' : 'icon-remove';?>"></i></td>
				<td>Requires: <?=round($ac->irr * $ac->land_percentage / 100 * $acres * 7,3);?> L/wk of water</td></tr>
			<tr data-lmu_id="<?=$ac->lmu_id;?>" data-crop_id="<?=$ac->id;?>">
				<td data-field="fertilizer">
				Fertilizer
				<i style="cursor:pointer;" class="pull-right <?php echo ($ac->fertilizer) ? 'icon-ok' : 'icon-remove';?>"></i></td>
				<td>Requires: <?=round($ac->frr * $ac->land_percentage / 100 * $acres,3);?> kg/wk of fertilizer</td></tr>
			<tr data-lmu_id="<?=$ac->lmu_id;?>" data-crop_id="<?=$ac->id;?>">
				<td data-field="pesticide">
				Pesticide
				<i style="cursor:pointer;" class="pull-right <?php echo ($ac->pesticide) ? 'icon-ok' : 'icon-remove';?>"></i></td>
				<td>Requires: <?=round($ac->prr * $ac->land_percentage / 100 * $acres,3);?> kg/wk of pesticide</td></tr>
			<tr data-lmu_id="<?=$ac->lmu_id;?>" data-crop_id="<?=$ac->id;?>">
				<td data-field="collect_seeds">
				Collect Seed
				<i style="cursor:pointer;" class="pull-right <?php echo ($ac->collect_seeds) ? 'icon-ok' : 'icon-remove';?>"></i></td>
				<td>Requires: <?=round($ac->land_percentage * $acres / 100 * .5,3);?> FLUs labor</td></tr>
		</table>


		<dl class="dl-horizontal">
 		 <dt>Health:</dt>
 		 <dd>
				<div class="progress">
					<div class="bar" style="width: <?=$ac->health;?>%;"><?=$ac->health;?></div>
					<div class="bar bar-danger" style="width:<?=100 - $ac->health;?>%;"></div>
				</div>
			</dd>

			<dt>Progress:</dt>
			<dd>
				<div class="progress">
					<div class="bar" style="width: <?=$ac->percent_complete;?>%;"><?=round($ac->percent_complete/100*$ac->nWeeks);?> weeks complete</div>
					<div class="bar bar-danger" style="width: <?=100 - $ac->percent_complete;?>%;"><?=round((100-$ac->percent_complete)/100*$ac->nWeeks);?> weeks remaining</div>
				</div>
			</dd>

			<dt>Land Percentage:</dt>
			<dd>
				<div class="progress">
					<div class="bar" style="width: <?=$ac->land_percentage;?>%;"><?=$ac->land_percentage;?>%</div>
					<div class="bar bar-danger" style="width: <?=100 - $ac->land_percentage;?>%;"></div>
				</div>
			</dd>

			<dt>Acres:</dt>
			<dd><?=round($acres * $ac->land_percentage / 100,3);?></dd>

			<dt>Labor:</dt>
			<dd><?=round($ac->clr * $acres * $ac->land_percentage / 100,3);?></dd>

			<dt>Current Yield:</dt>
			<?php if($ac->crop_id==1 || $ac->crop_id==4){ ?>
			<dd><?=$ac->yield;?> kg maize grain, <?=$ac->yield2?> kg maize straw</dd>
			<? }else{ ?>
			<dd><?=$ac->yield;?> kg cotton</dd> <? } ?>

			<dt>Max Potential Yield:</dt>
			<?php if($ac->crop_id==1){ ?>
			<dd> <?=$acres*$ac->land_percentage/100.0*1560?> kg maize grain, <?=$acres*$ac->land_percentage/100.0*3120?> kg maize straw</dd>
			<? }elseif ($ac->crop_id==2){ ?>
			<dd> <?=$acres*$ac->land_percentage/100.0*600?> kg cotton</dd>
			<? }elseif ($ac->crop_id==3){ ?>
			<dd> <?=$acres*$ac->land_percentage/100.0*1020?> kg cotton</dd>
			<? }else{ ?>
			<dd> <?=$acres*$ac->land_percentage/100.0*2160?> kg maize grain, <?=$acres*$ac->land_percentage/100.0*5400?> kg maize straw</dd>
			<? } ?>

			<span 
				style="cursor:pointer;" 
				class="label label-important"
				id="removeCrop" 
				class="btn btn-info" 
				type="button" 
				data-lmu_id="<?=$ac->lmu_id;?>" 
				data-crop_id="<?=$ac->id;?>"
			>
					Remove Crop
			</span>

		</dl>
		</div>

	<?php } ?>
</div>


<div id="cult_warn" class="alert alert-block span6" style="display:none; position:fixed; bottom:10px;">
	<a class="close" onclick="$('#cult_warn').hide();">X</a>
	<h4 class="alert-heading">Warning!</h4>
	<p id="cult_warn_message"></p>
</div>


<div id="seed_error" class="alert alert-block alert-error span6" style="display:none; position:fixed; bottom:10px;">
	<a class="close" onclick="$('#seed_error').hide();">X</a>
	<h4 class="alert-heading">Error!</h4>
	<p id="seed_error_message"></p>
</div>


<script>

$('i').on('click', function() {
	var data = {lmu_id: $(this).closest('tr').data('lmu_id'), crop_id: $(this).closest('tr').data('crop_id'), field: $(this).closest('td').data('field')};
	var icon = $(this);
	$.ajax({
	type: "POST",
	url: "<?=site_url()?>/lmu/cultivate_crop",
	data: data,
	dataType: "json",
	success: function(data){
		if(!data['water']){
			$('#cult_warn').show("slide", { direction: "down" }, 'fast');
			$('#cult_warn_message').text("You don't have enough water available to irrigate this field, but irrigation will now be applied if water becomes available.");
		}
		else $('#cult_warn').hide();
		if(!data['seed']){
			$('#seed_error').show("slide", { direction: "down" }, 'fast');
			$('#seed_error_message').text("You don't have enough family members to start this task.  Adjust your other management decisions to release a family member's time");
		}
		else $('#seed_error').hide();

		if(data['checked'] == 1){
			icon.removeClass('icon-remove');
			icon.addClass('icon-ok');
		}
		else{
			icon.removeClass('icon-ok');
			icon.addClass('icon-remove');
		}
    	}
  	});
});

$('#removeCrop').click(function() {
	var data = { 'lmu_id': $(this).data('lmu_id'), 'crop_id': $(this).data('crop_id') };
	$.ajax({
		type: "POST",
		url: "<?=site_url()?>/lmu/remove_crop",
		data: data,
		dataType: "json",
		success: function(data){
			location.reload();
		}
	});
});

</script>
