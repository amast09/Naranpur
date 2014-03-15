<div class="container-fluid">
	<div class="row-fluid">
		<form class="span4 offset4 text-center" id="change-password" data-submit-url="<?=site_url("/family/process_password_change");?>">

    	<div id="legend">
     		<legend>Change Your Naranpur Password</legend>
	    </div>

			<div class="control-group">
				<div class="controls">
					<input type="password" id="pwd0" name="pwd0" placeholder="Current Password" autocomplete="off" class="input-xlarge">
				</div>
			</div>

			<div class="control-group">
				<div class="controls">
					<input type="password" id="pwd1" name="pwd1" placeholder="New Password" autocomplete="off" class="input-xlarge">
				</div>
			</div>

			<div class="control-group">
				<div class="controls">
					<input type="password" id="pwd2" name="pwd2" placeholder="Confirm New Password" autocomplete="off" class="input-xlarge">
				</div>
				<div class="alert alert-block">
					Please do not use your Clemson credentials!
				</div>
			</div>
 
			<div class="control-group text-center">
 	    	<div class="controls">
 	      	<a id="change_button" class="btn btn-success">Change Password</a>
				</div>
	   	</div>
		</form>
	</div>
	
	<div class="row-fluid">
		<div class="span8 offset2">
			<div id="error" class="alert alert-block alert-error " style="display:none; bottom:10px;">  
  			<a class="close" onclick="$('#error').hide();">X</a>  
  			<h4 class="alert-heading">Error!</h4>  
				<p id="error_message"></p>
			</div> 
			<div id="success" class="alert alert-block alert-success" style="display:none; bottom:10px;">  
  			<a class="close" onclick="$('#success').hide();">X</a>  
  			<h4 class="alert-heading">Success!</h4>  
				<p id="success_message"></p>
			</div> 
		</div>
	</div>
</div>

