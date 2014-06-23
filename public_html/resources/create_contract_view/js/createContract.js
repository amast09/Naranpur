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
		if(isInteger($this.val()) && $this.val() > 0) {
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
			htmlToInsert = '<option value="' + $resourceToPutBack.attr("data-id") +'">' + $resourceToPutBack.attr("data-name") + '</option>';
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
												'data-name="' + resourceName + '" data-id="' + resourceId + '" data-quantity="' + quantity + '" data-ongoing="true">' +
														'<div class="span7">' +
															'<i class="icon-leaf"></i>' +
															'&nbsp;<span>' + resourceName + '</span>' +
														'</div>' +
														'<div class="span2">' +
															'<i class="icon-checkbox-checked on-going"></i>' +
															'&nbsp;<span>On Going</span>' +
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

	$('.added-resources-list').on('click', '.on-going', function(){
		var $this = $(this),
				$containerResource = $this.closest('.added-resource');
		if($containerResource.attr("data-ongoing") === "true") {
			$containerResource.attr("data-ongoing", false);
			$this.removeClass('icon-checkbox-checked').addClass('icon-checkbox-unchecked');
		} else {
			$containerResource.attr("data-ongoing", true);
			$this.removeClass('icon-checkbox-unchecked').addClass('icon-checkbox-checked');
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
		var $wrap = $(".wrap"),
				nextStep = parseInt($wrap.attr('data-step'), 10) + 1;
		$wrap.attr('data-step', nextStep);

		if(nextStep === 4) {
			renderReviewView();
		}
  });

  $(".previous").on("click", function(){
		var $wrap = $(".wrap");
		$wrap.attr('data-step', parseInt($wrap.attr('data-step'), 10) - 1);
  });

	var validator = new FormValidator('contract-form', [{
		name: 'length',
		display: 'contract length',
		rules: 'required|integer'
	}, {
		name: 'employee-id',
		display: 'employee',
		rules: 'required|integer'
	}, {
		name: 'resources',
		display: 'payment',
		rules: 'required'
	}], function(errors) {
			var errorHtml = '';
			$(".contract-errors").html('');

			if (errors.length > 0) {
				for (var x = 0; x < errors.length; x++) {
					errorHtml += "<div>" + errors[x].message + "</div>";
				}

				$(".contract-errors").html(errorHtml);
			}
	});

  $(".create").on("click", function() {
  	$("#contract-form").submit();
  });

  function renderReviewView() {
  	var length = parseInt($("#contract-duration").val(), 10),
  			lengthText = (length === -1) ? "On Going" : length + " Turns";
  			$employee = $(".family-member.chosen"),
  			$resources = $(".added-resource"),
  			resourcesObject = {},
  			newHtml = '';

		newHtml = '<ul class="review-contract-details review-list">' +
								'<li class="review-length">' + 
									'<h4>Length</h4>' +
									'<div class="review-length-text">' + lengthText + '</div>' +
								'</li>' +
								'<li class="review-employee">' +
									'<h4>Employee</h4>' +
									'<ul class="review-list">' +
										'<li>Family: ' + $employee.attr("data-family") + '</li>' +
										'<li>Member: ' + $employee.attr("data-id") + '</li>' +
										'<li>Age: ' + $employee.attr("data-age") + '</li>' +
										'<li>Sex: ' + $employee.attr('data-sex') + '</li>' +
										'<li>Health: ' + $employee.attr("data-health") + '</li>' +
										'<li>Labor: ' + 120 + '</li>' +
									'</ul>' +
								'</li>' +
								'<li class="review-resources">' +
									'<h4>Resources</h4>' +
									'<ul class="review-list">';

		$.each($resources, function(index, obj) {
			var $obj = $(obj),
					onGoingResourceHtml = ($obj.attr('data-ongoing') === "true") ? "Every Turn" : "Once";

			newHtml += '<li class="review-added-resource">' +
			 							'<div class="span4">' + 
			 								'<i class="icon-leaf"></i>&nbsp;' +
			 								'<span>' + $obj.attr('data-name') + '</span>' +
			 							'</div>' +
			 							'<div class="span4">' +
			 								'<i class="icon-history"></i>&nbsp;' +
			 								'<span>' + onGoingResourceHtml + '</span>' +
			 							'</div>' +
			 							'<div class="span4">' +
			 								'<i class="icon-plus-sign"></i>&nbsp;' +
			 								'<span>' + $obj.attr('data-quantity') + '</span>' +
			 							'</div>' +
			 						'</li>';
			resourcesObject[$obj.attr('data-id')] = $obj.attr('data-quantity');
		});
				
		newHtml += '</ul>' +
							'</li>' +
						'</ul>';

		$("#length-input").val(length);
		$("#employee-id-input").val($employee.attr("data-id"));
		$("#resources-input").val(JSON.stringify(resourcesObject));
		$(".review-template").html(newHtml);
  }

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