$(function() {

	$(".fixed-contract").click(function() {
		$(".on-going-contract").removeClass('active');
		$(this).addClass('active');
		$('.contract-duration').removeClass('hidden').find(".contract-duration__input").val("");
		$('.wrap').removeClass('length-chosen');
	});

	$(".on-going-contract").click(function() {
		$(".fixed-contract").removeClass('active');
		$(this).addClass('active');
		$('.contract-duration').addClass('hidden').find(".contract-duration__input").val(-1);
		$('.wrap').addClass('length-chosen');
	});

	$("#contract-duration").on("keyup", function() {
		var $this = $(this);
		if(isInteger($this.val())) {
			$this.removeClass('error');
			$('.wrap').addClass('length-chosen');
		} else {
			$this.addClass('error');
			$('.wrap').removeClass('length-chosen');
		}
	});

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

	$('.added-resources-list').on('click', '.remove-resource', function(){
		var $resourceSelect = $("#resource-id"),
			$resourceToPutBack = $(this).closest(".added-resource");
			htmlToInsert = '<option value="' + $resourceToPutBack.attr("data-resource-id") +'">' + $resourceToPutBack.attr("data-resource-name") + '</option>';
		$(this).closest(".added-resource").remove();
		$resourceSelect.append(htmlToInsert);
		if($(".added-resource").length === 0) {
			$(".wrap").removeClass('resources-chosen');
		}
	});

	$(".add-resource").on("click", function(){
		var $quantity = $("#resource-quantity");

		if($quantity.val() !== "" && !$quantity.hasClass('error')) {
			var $addedResource = $("#resource-id").find(":selected"),
			resourceId = $addedResource.val(),
			resourceName = $addedResource.text(),
			quantity = $quantity.val().trim(),
			htmlToInsert =	'<li class="added-resource" ' +
												'data-resource-name="' + resourceName + '" data-resource-id="' + resourceId + '" data-quantity="' + quantity + '">' +
														'<div class="span9">' +
															'<i class="icon-leaf"></i>' +
															'&nbsp;<span>' + resourceName + '</span>' +
														'</div>' +
														'<div class="span2">' +
															'<i class="icon-plus-sign"></i>' +
															'&nbsp;<span>' + quantity +'</span>' +
														'</div>' +
														'<button class="btn btn-danger remove-resource"><i class="icon-minus"></i></button>' +
													'</li>';
			$addedResource.remove();
			$quantity.val("");
			$(".added-resources-list").append(htmlToInsert);
			$(".wrap").addClass('resources-chosen');
		} else {
			$quantity.addClass('error');
		}

	});

	$("#resource-quantity").on("keyup", function() {
		var $this = $(this);
		if(isInteger($this.val())) {
			$this.removeClass('error');
		} else {
			$this.addClass('error');
		}
	});

	$(".step-link").on("click", function(){
		var stepToMoveTo = $(this).attr("data-step");
		$(".wrap").attr("data-step", stepToMoveTo);
	});

  $(".next").on("click", function(){
		var $wrap = $(".wrap");
		$wrap.attr('data-step', parseInt($wrap.attr('data-step'), 10) + 1);
  });

  $(".previous").on("click", function(){
		var $wrap = $(".wrap");
		$wrap.attr('data-step', parseInt($wrap.attr('data-step'), 10) - 1);
  });

  function hideNextButton() {
		$(".wrap").removeClass("employee-chosen");
  }

  function showNextButton() {
		$(".wrap").addClass("employee-chosen");
  }

  function isInteger(input) {
		return(/^\-?[0-9]+$/.exec(input) !== null);
  }

});