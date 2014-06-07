$(function() {

	// If you click a family
  $(".family-name").on("click", function(){
		// Grab the DOM node with the associated family members
		var	$familyToShow = $("#family-" + $(this).attr("data-family-name"));
		// Make sure the next button is hidden
		hideNextButton();
		// Make sure to unselect any family member previously selected
		$(".family-member").removeClass("chosen");
		// If the family was already selected
		if($familyToShow.is(':visible')) {
			// Hide the family members
			$familyToShow.hide();
			// Unselect the family
			$(this).removeClass("chosen");
		} else {
			// Unselect any other family selection
			$(".family-name").removeClass('chosen');
			// Hide any previous family members
			$(".family-member-list").hide();
			// Select that family
			$(this).addClass("chosen");
			// Show the family members of that associated family
			$familyToShow.show();
		}

  });

// If you click a family member
	$(".family-member").on("click", function(){
		// If the family member was already selected
		if($(this).hasClass('chosen')) {
			// Remove the hightlight as well as the next button
			$(this).removeClass("chosen");
			hideNextButton();
		} else {
			// Remove any previous family member selection
			$(".family-member").removeClass("chosen");
			// Select that family member
			$(this).addClass("chosen");
			// Make sure the next button is showing
			showNextButton();
		}

  });

  $(".next").on("click", function(){
		var $wrap = $(".wrap");
		if($wrap.hasClass('step-1')) {
			$wrap.removeClass('step-1').addClass('step-2');
		} else if($wrap.hasClass('step-2')) {
			$wrap.removeClass('step-2').addClass('step-3');
		}
  });

  $(".previous").on("click", function(){
		var $wrap = $(".wrap");
		if($wrap.hasClass('step-2')) {
			$wrap.removeClass('step-2').addClass('step-1');
		} else if($wrap.hasClass('step-3')) {
			$wrap.removeClass('step-3').addClass('step-2');
		}
  });

  function hideNextButton() {
		$(".wrap").removeClass("employee-chosen");
  }

  function showNextButton() {
		$(".wrap").addClass("employee-chosen");
  }

});