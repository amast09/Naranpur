<div class="container-fluid">
	<div class="row-fluid">
		<div class="span6 offset3 well text-center">
		<form id="message_form" class="form-horizontal" data-submit-url='<?=site_url("messages/create_message");?>' data-redirect-url='<?=site_url("messages/inbox");?>'>

			<div class="control-group">
			<div class="input-prepend">
				<span class="add-on">
					<i class="icon-user"></i>
				</span>
				<input data-current-families='<?=json_encode($families->result_array());?>' class="input-xxlarge" type="text" id="families" name="reciever_name" placeholder="Family Name">
			</div>
			</div>

			<div class="control-group">
			<div class="input-prepend">
				<span class="add-on">
					<i class="icon-comment"></i>
				</span>
				<input class="input-xxlarge" type="text" id="subject" name="subject" placeholder="Subject">
			</div>
			</div>

			<div class="control-group">
			<div class="input-prepend">
				<span class="add-on">
					<i class="icon-pencil"></i>
				</span>
 	     <textarea id="body" class="input-xxlarge" name="body" placeholder="Type message here" rows="5"></textarea>
			</div>
			</div>

			<div class="control-group text-left">
				<a id="send_button" class="btn btn-info">Send Message</a>
			</div>

		</form>
		</div>
	</div>

	<div class="row-fluid">
		<div id="message_error" class="alert alert-block alert-error" style="display:none;">
			<a class="close" onclick="$('#message_error').hide();">X</a> 
			<h4 class="alert-heading">Error!</h4>  
			<p id="message_error_message"></p>
		</div> 
	</div> 
</div>

<script src="<?=base_url("/resources/create_message_view/js/createMessage.js");?>"></script>
