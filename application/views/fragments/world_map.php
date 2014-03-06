<div id="rsr" 
	data-map-url="<?=base_url('/resources/world_view/img')?>/" 
	data-lmu-url="<?=site_url('lmu/view');?>" 
	data-paths-url="<?=site_url('world/get_paths/');?>"
	data-family-name="<?=$family_name;?>"
/>
</div>

<div class="input-append">
	<select id="map">
		<?php foreach($map_list->result() as $row){ ?>
 			<option value="<?=$row->file_name?>"><?=$row->map_name?></option>
		<?php } ?>
	</select>
	<a id="change_map" class="btn btn-primary">Change Map</a>
</div>

<form class="form-inline" action="<?php echo site_url("lmu/view");?>" method="POST">
	<div class="input-append">
		<select name="lmu_id">
			<?php foreach($lmu_list->result() as $row){ ?>
 				<option value="<?=$row->id?>"><?=$row->family_name?> - <?=$row->id?></option>
			<?php } ?>
		</select>
		<button class="btn btn-primary">Go to LMU</button>
	</div>
</form>
