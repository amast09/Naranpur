$(function() {

	$('.checkbox').on('click', function() {
		if($(this).hasClass('icon-checkbox-unchecked')) {
			$(this).removeClass('icon-checkbox-unchecked').addClass('icon-checkbox-checked').closest('.thread').addClass('delete-thread');

			var $deleteBtn = $(".delete-btn");
			if($deleteBtn.css("display") === "none"){
				$deleteBtn.show();
			}

		} else {
			$(this).removeClass('icon-checkbox-checked').addClass('icon-checkbox-unchecked').closest('.thread').removeClass('delete-thread');

			if($(".icon-checkbox-checked").length === 0){
				$(".delete-btn").hide();
			}

		}
		return(false);
	});


	$(".delete-btn").on("click", function(){
		var threadIdsToDelete = [];
		var $threads = $(".icon-checkbox-checked");
		$.each($threads, function(index, val) {
			threadIdsToDelete[index] = Number($(val).attr("data-thread-id"));
		});

		$.ajax({
			url: $(".brand").attr("data-site-url") + "/messages/delete_threads",
			type: 'POST',
			dataType: 'json',
			data: {thread_ids : threadIdsToDelete},
		}).done(function() {
			$threads.each(function(index, val) {
				$(val).closest('.thread').hide({duration : 350}, function(){ $(this).remove(); });
			});
			console.log("success");
		});
	});

	$(".thread").on("click", function(){
			var redirectUrl = $(".brand").attr("data-site-url") + "/messages/thread_view/" + $(this).find(".checkbox").attr("data-thread-id");
			window.location.assign(redirectUrl);
	});

});
