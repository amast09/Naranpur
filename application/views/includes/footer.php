</body>
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script src="<?=base_url("/resources/base/js/bootstrap.min.js");?>"></script>
	<script src="<?=base_url("/resources/base/js/base.js");?>"></script>
	<?php
		if(isset($js_files)){
			foreach($js_files as $js_file_path){
				?> <script src="<?=$js_file_path?>"></script> <?php
			}
		}
	?>
</html>
