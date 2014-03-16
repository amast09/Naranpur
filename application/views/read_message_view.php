	<?php
		$m = $message->row();
		$url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : site_url('message/inbox');
	?>

		<div class="container-fluid">
			<div class="row-fluid" style="text-align:center;">
				<div class="span3">
					<h5>Sender</h5>
					<div class="icon icon-upload"></div>
					<strong><?=$m->sender_name;?></strong>
				</div>
				<div class="span3">
					<h5>Receiver</h5>
					<div class="icon icon-download"></div>
					<strong><?=$m->reciever_name;?></strong>
				</div>
				<div class="span3">
					<h5>Date Sent</h5>
					<div class="icon icon-time"></div>
					<strong><?=$m->sent_date;?></strong>
				</div>
				<div class="span3">
					<h5>Subject</h5>
					<div class="icon icon-bubble"></div>
					<strong><?=$m->subject;?></strong>
				</div> 
			</div>

			<hr></hr>

			<div class="row-fluid">
				<p id="bod" class="well"></br><?php echo $m->body; ?> </p>
			</div>
			<div class="row-fluid">
				<a href="<?=$url?>" id="back"></a>
			</div>
		</div>

