<div class="container-fluid">
	<h3>Messages</h3>
	<div class="threads">
		<?php foreach($threads->result() as $thread) { ?>
			<div class="thread row-fluid <?php if(!$thread->has_read) { echo 'unread'; } ?>">
				<div class="span4">
					<div class="span1">
						<i data-thread-id="<?=$thread->id?>" class="icon-checkbox-unchecked checkbox"></i>
					</div>
					<div class="members span11 message-third">
						(<?=$thread->total_messages;?>)
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
					<div class="span9 message-third">
						<span class="subject"><?=$thread->subject;?></span>
						<span class="message"> - <?=$thread->most_recent_message->message;?></span>
					</div>
					<div class="date-sent span3 message-third"><?=$thread->most_recent_message->date_sent;?></div>
				</div>
			</div>
		<?php } ?>
	</div>
	<div class="row-fluid">
		<div class="span4">
			<a class="btn btn-success" href="<?=site_url('messages/create_thread_view/');?>">Compose</a>
			<button class="btn btn-danger delete-btn" type="button">Delete</button>
		</div>
		<div class="span8">
			<div class="pagination pull-right">
			  <ul>
			    <?php
			    	if($previous) {
			    		$previous_page = $current_page - 1;
							echo "<li><a href='" . site_url("messages/threads_view/$previous_page") . "'><i class='icon-chevron-left'></i></a></li>";
						}
						for($x = 0; $x < $total_threads / 10; $x++) {
							$link_text = $x + 1;
							if($x == intval($current_page)) {
								echo "<li class='active'><a href='" . site_url("messages/threads_view/$x") . "'>$link_text</a></li>";
							} else {
								echo "<li><a href='" . site_url("messages/threads_view/$x") . "'>$link_text</a></li>";
							}
						}
						if($next) {
			    		$next_page = $current_page + 1;
							echo "<li><a href='" . site_url("messages/threads_view/$next_page") . "'><i class='icon-chevron-right'></i></a></li>";
						}
			    ?>
			  </ul>
			</div>
		</div>
	</div>
</div>
