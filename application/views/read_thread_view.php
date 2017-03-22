<div class="container-fluid">

	<div class="row-fluid">
		<div class="span8 offset2">
			<h3 class="subject-text"><?=$subject;?></h3>
		</div>
	</div>

	<div class="row-fluid">
		<div class="span6 offset2">
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
		<div class="span2">
			<form action="<?=site_url('messages/delete_thread')?>" method="post">
				<input type="hidden" name="thread_id" value="<?=$thread_id;?>"></input>
				<button class="btn btn-danger" type="submit">Delete</button>
			</form>
		</div>
	</div>

	<div class="row-fluid">
		<div class="span8 offset2">
			<form name="reply" action="<?=site_url('messages/add_message_to_thread')?>">
				<input type="hidden" name="thread_id" value="<?=$thread_id?>">

				<div class="control-group">
					<div class="controls">
						<div class="row-fluid">
							<textarea class="reply-box span12" rows="6" name="message" placeholder="Type Your Reply Here..."></textarea>
						</div>
						<div class="row-fluid">
							<a href="javascript:history.back()" class="btn btn-primary span2">Back</a>
							<span class="help-inline span8"></span>
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
				<div class="message span8 offset2">
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
	<div class="row-fluid">
		<div class="pagination">
		  <ul>
		    <?php
		    	if($previous) {
		    		$previous_page = $current_page - 1;
						echo "<li><a href='" . site_url("messages/thread_view/$thread_id/$previous_page") . "'><i class='icon-chevron-left'></i></a></li>";
					}
					for($x = 0; $x < $total_messages / 10; $x++) {
						$link_text = $x + 1;
						if($x == intval($current_page)) {
							echo "<li class='active'><a href='" . site_url("messages/thread_view/$thread_id/$x") . "'>$link_text</a></li>";
						} else {
							echo "<li><a href='" . site_url("messages/thread_view/$thread_id/$x") . "'>$link_text</a></li>";
						}
					}
					if($next) {
		    		$next_page = $current_page + 1;
						echo "<li><a href='" . site_url("messages/thread_view/$thread_id/$next_page") . "'><i class='icon-chevron-right'></i></a></li>";
					}
		    ?>
		  </ul>
		</div>
	</div>

</div>