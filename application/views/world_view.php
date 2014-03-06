<div class="container-fluid">
	<div class="row-fluid">
		<div class="span6">
			<?php $this->load->view("fragments/world_map"); ?>
		</div>

		<div class="span6">
			<?php $this->load->view("fragments/world_chart"); ?>
		</div>

	</div>
</div>
<script src="<?=base_url("/resources/base/js/raphael.js");?>"></script>
<script src="<?=base_url("/resources/world_view/js/g.raphael-min.js");?>"></script>
<script src="<?=base_url("/resources/world_view/js/g.line.js");?>"></script>

<script src="<?=base_url("/resources/world_view/js/map.js");?>"></script>
<script src="<?=base_url("/resources/world_view/js/chart.js");?>"></script>
