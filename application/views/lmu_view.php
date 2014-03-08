<div class="container-fluid">
	<div class="row-fluid">
		<div 
			style="text-align:center;" 
			id="rsr"
			data-background-image="<?=base_url("/resources/lmu_view/img/bg$lmu_type.jpg")?>"
			data-hut-image="<?=base_url('/resources/lmu_view/img/hut.png')?>"
			data-barn-image="<?=base_url('/resources/lmu_view/img/barn.png')?>"
			data-well-image="<?=base_url('/resources/lmu_view/img/well.png')?>"
			data-farmer-image="<?=base_url('/resources/lmu_view/img/farmer.png')?>"
			data-crop-base-image="<?=base_url('/resources/lmu_view/img')?>"
			data-planted-crops='<?=json_encode($planted_crops->result_array());?>'
		>
		</div>
	</div>

	<div class="row-fluid">
		<div style="text-align:center;">
			<a href="#family" role="button" class="btn btn-success" data-toggle="modal">View Family</a>
			<a href="#cultivate" role="button" class="btn btn-success" data-toggle="modal">Manage Crops</a>
			<a href="#plant" role="button" class="btn btn-success" data-toggle="modal">Plant Crops</a>
			<a href="#water" role="button" class="btn btn-success" data-toggle="modal">Collect Water</a>
			<a href="#feed" role="button" class="btn btn-success" data-toggle="modal">Feed Animals</a>
		</div>
	</div>

	<a class="pull-left" href="<?=site_url('world')?>" id="back"></a>
</div>
 
<?php $this->load->view('modals/manage_crop'); ?>
<?php $this->load->view('modals/manage_seed'); ?>
<?php $this->load->view('modals/manage_water'); ?>
<?php $this->load->view('modals/manage_animal'); ?>
<?php $this->load->view('modals/manage_family'); ?>

<script src="<?=base_url('/resources/base/js/raphael.js');?>"></script>
<script src="<?=base_url("/resources/lmu_view/js/lmu.js");?>"></script>
<script src="<?=base_url("/resources/lmu_view/js/manageAnimal.js");?>"></script>
<script src="<?=base_url("/resources/lmu_view/js/manageCrop.js");?>"></script>
<script src="<?=base_url("/resources/lmu_view/js/manageSeed.js");?>"></script>
<script src="<?=base_url("/resources/lmu_view/js/manageWater.js");?>"></script>
