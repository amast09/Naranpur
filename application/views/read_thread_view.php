<div class="container-fluid">

	<div class="row-fluid">
		<div class="span6 offset3">
			<h3 class="subject-text"><?=$subject;?></h3>
		</div>
	</div>

	<div class="row-fluid">
		<div class="span4 offset3">
			<ul class="inline">
				<?php
					for($x = 0; $x < count($thread_members); $x++) {
						echo '<li class="thread-member">'.$thread_members[$x]['family_name'];
						if($x != count($thread_members) - 1) {
							echo ',</li>';
						}
					} 
				?>
				</li>
			</ul>
		</div>
	</div>

	<div class="row-fluid">
		<div class="span6 offset3">
			<form name="reply" action="<?=site_url('messages/add_message_to_thread')?>">
				<input type="hidden" name="thread_id" value="<?=$thread_id?>">

				<div class="control-group">
					<div class="controls">
						<div class="row-fluid">
							<textarea class="reply-box span12" rows="6" name="message" placeholder="Type Your Reply Here..."></textarea>
						</div>
						<div class="row-fluid">
							<span class="help-inline span10"></span>
							<button class="reply-btn btn span2" type="submit">Send</button>
						</div>
					</div>
				</div>
		
			</form>
		</div>
	</div>

	<div class="all-messages">
		<?php foreach($messages->result() as $message) { ?>
			<div class="row-fluid">
				<div class="message span6 offset3">
					<div class="message-info row-fluid">
						<div class="sender span6">
							<h4><?=$message->sender;?></h4>
						</div>
						<div class="date-sent span6">
							<h5><?=$message->date_sent;?></h5>
						</div>
					</div>
					<div class="row-fluid">
						<div class="text"><?=$message->message;?></div>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>

</div>