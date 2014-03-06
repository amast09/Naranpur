<div class="modal hide" id="myModal">

  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">x</button>
    <h3>Post a Comment</h3>
  </div>

  <div class="modal-body">
    <form id="comment-form" class="form-inline well" data-submit-url="<?=site_url('/discussion/submit_comment');?>" data-redirect-url="<?=site_url('discussion/see_comments/$diss_id');?>">

			<input type="hidden" name="diss_id" id="diss_id" value=<?=$diss_id;?> />

			<div class="control-group">
      	<textarea class="span12" style="resize:none" rows=8 name="content" id="content" placeholder="Leave a comment..."></textarea>
			</div>

			<div class="control-group">
      	<a id="comment_button" class="btn btn-primary">Comment</a>
			</div>

    </form>

		<div id="comment_error" class="alert alert-block alert-error span4" style="display:none; position:fixed; bottom:10px;">  
	  	<a class="close" onclick="$('#comment_error').hide();">X</a>  
			<h4 class="alert-heading">Error!</h4>  
			<p id="comment_error_message"></p>
		</div> 

  </div>


</div>

<script> 
$('#comment_button').click(function() {
 	$.ajax({
		type: "post",
		url: $("#comment-form").attr("data-submit-url"),
		data: $("#comment_form").serialize(),
	  dataType: "json",
    success: function(data){
			if(data.success) window.location.assign($("#comment-form").attr("data-redirect-url"));
			else{
				$('#comment_error').show("slide", { direction: "down" }, 'fast');
				$('#comment_error_message').html(data.message);	
			}
    }
  });
});
</script>
