$(function() {
	$(".deny-delete-contract").on("click", function() {
		$(this).closest('.contract').removeClass("confirm");
	});

	$(".delete-contract").on("click", function() {
		$(this).closest('.contract').addClass("confirm");
	});

	$(".confirm-delete-contract").on("click", function() {
		var $this = $(this),
				ajaxUrl = $(".container-fluid").attr("data-base-url") + "/labor/delete_contract/",
				$contractClicked = $this.closest(".contract"),
				contractId = $contractClicked.attr("data-contract-id");

			$.ajax({
				url: ajaxUrl,
				type: 'POST',
				dataType: 'JSON',
				data: { "contract-id" : contractId },
				success: function(data) {
					if(data.success) {
						$contractClicked.fadeOut(1000, function(){
							$contractClicked.remove();
						});
					} else {
						alert("Server Error.  Please try again later.");
					}
				},
				fail: function() {
					alert("Server Error.  Please try again later.");
				}
			});
				
	});

	$(".accept-contract").on("click", function() {
		var $this = $(this),
				ajaxUrl = $(".container-fluid").attr("data-base-url") + "/labor/update_contract/",
				$contractClicked = $this.closest(".contract"),
				contractId = $contractClicked.attr("data-contract-id");

			$.ajax({
				url: ajaxUrl,
				type: 'POST',
				dataType: 'JSON',
				data: { "contract-id" : contractId },
				success: function(data) {
					if(data.success) {
						$contractClicked.fadeOut(1000, function(){
							$contractClicked = $contractClicked.detach();
							$contractClicked.find(".accept-contract").remove();
							$contractClicked.find(".icon-close").remove(".icon-close").addClass(".icon-remove");
							$("#current-contracts").find(".contract-list").append($contractClicked);
						});
					} else {
						alert("Server Error.  Please try again later.");
					}
				},
				fail: function() {
					alert("Server Error.  Please try again later.");
				}
			});
	});
});