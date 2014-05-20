<div class="row-fluid">
	<form name="send-message" action="<?=site_url('messages/create_thread')?>" class="span8 offset2" method="post">

		<div class="control-group">
			<div class="controls">
				<div class="input-prepend span12">
					<span class="add-on">
						<i class="icon-group"></i>
					</span>
					<input type="text" name="families" id="families" class="span6" placeholder="Families" data-current-families='<?=json_encode($families->result_array());?>'>
					<span class="help-inline"></span>
				</div>
			</div>
		</div>

		<div class="control-group">
			<div class="controls">
				<div class="input-prepend span12">
					<span class="add-on">
						<i class="icon-bullhorn"></i>
					</span>
					<input type="text" name="subject" id="subject" class="span6" placeholder="Subject">
					<span class="help-inline"></span>
				</div>
			</div>
		</div>

		<div class="control-group">
			<div class="controls">
				<textarea name="message" id="message" rows="10" class="span12" placeholder="Message"></textarea>
				<span class="help-inline"></span>
			</div>
		</div>

		<button class="btn btn-primary" type="submit">Send</button>

	</form>
</div>

