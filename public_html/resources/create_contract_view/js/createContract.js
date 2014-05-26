$(function() {

  $(".family-name").on("click", function(){
		var $familyToShow = $(this).next('.family-list');
		if(!$familyToShow.is(':visible')) {
			$(".family-list").hide();
			$(".member-stats").hide();
			$familyToShow.show();
		} else {
			$(".member-stats").hide();
			$familyToShow.hide();
		}
  });

	$(".family-member-name").on("click", function(){
		var memberId = $(this).attr("data-member-id"),
				$memberToShow = $("#stats-" + memberId);

		if(!$memberToShow.is(':visible')) {
			$(".member-stats").hide();
			$memberToShow.show();
		} else {
			$memberToShow.hide();
		}
  });

});