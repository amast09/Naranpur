<div class="container-fluid">
	<div class="row-fluid">
		<form class="span4 offset4 text-center" id="login">

    	<div id="legend">
     		<legend>Naranpur Login</legend>
	    </div>

			<div class="control-group">
				<div class="controls">
					<input type="text" id="family_name" name="family_name" placeholder="Family Name" class="input-xlarge">
				</div>
			</div>
 
			<div class="control-group">
				<div class="controls">
					<input type="password" id="password" name="password" placeholder="Password" class="input-xlarge">
				</div>
			</div>
 
			<div class="control-group">
 	    	<div class="controls">
 	      	<a id="login_button" class="btn btn-success pull-left">Login</a>
<?php /*
					<a href="<?php echo site_url();?>/family/signup" class="btn btn-primary pull-right">Create a Family</a>
*/ ?>
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
		</div>
	</div>

<table>
<tr>
<td width="15%">

<img src="<?=base_url("/resources/login_form/img/field_and_stream.jpg")?>" width="100%">

</td>
<td width="2%"></td>
<td width="40%">
<font size="4">

You have reached the login page for <strong>Naranpur Online</strong>.

<br><br>

This is a multi-person simulation game where players become the head of a family 
in a rural Indian village to manage lands within a watershed.  Players can work 
together to solve resource problems or try to beat the market to rise from 
poverty to become rich.

<br><br>

If you are interested in learning more about <strong>Naranpur Online</strong> or 
using it in a classroom, please contact <a href=http://www.clemson.edu/~smoysey> 
Dr. Stephen Moysey</a>.

<br><br>

This site should be viewed using Chrome or Firefox. Please note that some features 
do not work properly in Internet Explorer.
</font>

</td>
</tr>
</table>

</div>


<script> 

$('input').change( function() { $('#error').hide();  });


$("#login_button").on("click", function(event){
  var data = $("#login").serialize();
  
	$.ajax({
		type: "post",
		url: "<?=site_url("/family/validate_credentials");?>",
		data: data,
	  dataType: "json",
    success: function(data){
			if(data.success) window.location.assign('<?=site_url("dashboard");?>');
			else{
				$('#error').slideDown();
				$('#error_message').text("Invalid Name or Password");	
			}
    }
  });
});

</script>
