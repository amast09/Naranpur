<!DOCTYPE html>
<html>
<head>
	<title>Naranpur!</title>
	<link rel="stylesheet" type="text/css" href="<?=base_url("/resources/base/css/bootstrap.min.css");?>">
	<link rel="stylesheet" type="text/css" href="<?=base_url("/resources/base/css/icon-font.css");?>">
	<link rel="stylesheet" type="text/css" href="<?=base_url("/resources/base/css/base.css");?>">
	<?php
		if(isset($css_files)){
			foreach($css_files as $css_file_path){
				?> <link rel="stylesheet" type="text/css" href="<?=$css_file_path;?>"> <?php
			}
		}
	?>
</head>
<body>
