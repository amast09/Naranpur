<div class="row-fluid" style="text-align:right;">
	<div class="span9">
		<div id='world' data-url="<?=site_url('charts/get_world_data')?>"></div>
		<div id="worldBtns" class="btn-group" data-toggle="buttons-radio">
			<button type="button" data-lookup="P" class="btn btn-primary active">Rainfall</button>
			<button type="button" data-lookup="pop" class="btn btn-primary">Population</button>
			<button type="button" data-lookup="delH" class="btn btn-primary">Depth to Water</button>
			<button type="button" data-lookup="percentCropped" class="btn btn-primary">Percent Crop</button>
			<button type="button" data-lookup="avgHealth" class="btn btn-primary">Health</button>
		</div>
	</div>

	<div class="span3" style="text-align:center;">
		<div style="color:#F00;"> Entire World </div>
	</div>
</div>

<div class="row-fluid" style="text-align:right;">
	<div class="span9">
	<div id='user' data-url="<?=site_url('charts/get_user_data')?>"></div>

	<div id="userBtns" class="btn-group" data-toggle="buttons-radio">
		<button type="button" data-lookup="money" class="btn btn-primary active">Money</button>
		<button type="button" data-lookup="grain" class="btn btn-primary">Grain</button>
		<button type="button" data-lookup="straw" class="btn btn-primary">Straw</button>
		<button type="button" data-lookup="milk"  class="btn btn-primary">Milk</button>
		<button type="button" data-lookup="water" class="btn btn-primary">Water</button>
		<button type="button" data-lookup="avgHealth" class="btn btn-primary">Health</button>
		<button type="button" data-lookup="conc" class="btn btn-primary">Contaminants</button>
	</div>
	</div>
	<div class="span3" style="text-align:center;">
		<div style="color:#00FFFF;">Average Family</div>
		<div style="color:#00FF00;">Your Family</div>
	</div>
</div>
