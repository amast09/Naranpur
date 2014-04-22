<div class="container-fluid">
	<h3>Messages</h3>
	<div class="threads">
		<?php foreach($threads->result() as $thread) { ?>
			<div class="thread row-fluid <?php if(!$thread->has_read) { echo 'unread'; } ?>">
				<div class="span4">
					<div class="span1">
						<i data-thread-id="<?=$thread->id?>" class="icon-checkbox-unchecked checkbox"></i>
					</div>
					<div class="members span11">
						<?php
							for($x = 0; $x < count($thread->thread_members); $x++) {
								echo $thread->thread_members[$x]['family_name'];
								if($x != count($thread->thread_members) - 1) {
									echo ', ';
								}
							} 
						?>
					</div>
				</div>
				<div class="span8">
					<div class="span9">
						<span class="subject"><?=$thread->subject;?></span>
						<span class="message"> - <?=$thread->most_recent_message->message;?></span>
					</div>
					<div class="date-sent span3"><?=$thread->most_recent_message->date_sent;?></div>
				</div>
			</div>
		<?php } ?>
	</div>
	<a class="btn btn-success" href="<?=site_url('messages/create_thread_view/');?>">Compose</a>
	<button class="btn btn-danger delete-btn" type="button">Delete</button>
	<div class="btn-group">
		<button class="btn">
			<i id="left" class="icon-chevron-left"></i>
		</button>
		<button class="btn">
			<i id="right" class="icon-chevron-right"></i>
		</button>
	</div>
</div>