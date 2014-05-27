$(function() {

  $(".family-name").on("click", function(){
		var	$familyToShow = $("#family-" + $(this).attr("data-family-name"));

		if($familyToShow.is(':visible')) {
			$(this).removeClass("chosen");
			$familyToShow.hide();
		} else {
			$(".family-member-list").hide();
			$(".family-name").removeClass("chosen");
			$(this).addClass("chosen");
			$familyToShow.show();
		}

  });

	$(".family-member").on("click", function(){
		var $memberToShow = $("#member-" + $(this).attr("data-member-id"));

		if($memberToShow.is(':visible')) {
			$(this).removeClass("chosen");
			$memberToShow.hide();
		} else {
			$(".family-member").removeClass("chosen");
			$(this).addClass("chosen");
			$memberToShow.show();
		}

  });

});