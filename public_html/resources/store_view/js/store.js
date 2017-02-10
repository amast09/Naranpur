$(function() {

	function quantityChange(event) {
		updateTotals(event.data.selector);
		processTransaction(event.data);
	}

	function resourceChange(event) {
		$(event.data.selector + " .alert").hide();
		resetTotals(event.data.selector);
		updateTotals(event.data.selector);
		processTransaction(event.data);
	}

	function processTransaction(action){
		var transaction = action.checkValidity();
		if(transaction.valid){
			$(action.selector + " .alert").hide();
			$(action.selector + " .btn").removeAttr("disabled");
		} else {
			$(action.selector + " .btn").attr("disabled", "disabled");
			$(action.selector + " .error_message").text(transaction.error);
			$(action.selector + " .alert").show();
		}
	}

	function updateTotals(action) {
		var currentQuantity = parseFloat($(action + " .quantity").val()),
			currentPrice = parseFloat($(action + ' .resource option:selected').attr("data-price")),
			currentCash = parseFloat($("#player-cash").attr("data-player-cash")),
			costOfTransaction = (currentQuantity * currentPrice);

			if(!isNaN(costOfTransaction) && !isNaN(currentCash)){
				$(action + " .cost").val("Price: $" + costOfTransaction);
				if(action === "#buy"){
					$(action + " .newCash").val("Updated Cash: $" + (currentCash - costOfTransaction));
				}
				else if(action === "#sell"){
					$(action + " .newCash").val("Updated Cash: $" + (currentCash + costOfTransaction));
				}
			}
	}

	function resetTotals(action) {
		$(action + " .quantity").val(1).attr("max", $('option:selected', this).data('quantity'));
	}

	function transactionSubmit(event) {
		return(event.data.checkValidity().valid);
	}

	function validPurchase() {
		var currentQuantity = parseFloat($("#buy .quantity").val()),
			$resourceSelected = $('#buy .resource option:selected'),
			currentPrice = parseFloat($resourceSelected.attr("data-price")),
			currentAvailable = parseFloat($resourceSelected.attr("data-quantity")),
			currentCash = parseFloat($("#player-cash").attr("data-player-cash")),
			validity = true,
			errorMessage = "";

		if(isNaN(currentQuantity) === true || currentQuantity === "" || currentQuantity < 1){
			errorMessage = "Please enter a valid number.";
			validity = false;
		}
		else if(currentQuantity > currentAvailable){
			errorMessage = "The store does not have the Inventory to support this transaction.";
			validity = false;
		}
		else if(currentCash - (currentPrice * currentQuantity) < 0){
			errorMessage = "You do not have the funds to buy this.";
			validity = false;
		}


		return({"valid" : validity, "error" : errorMessage});
	}

	function validSale () {
		var currentQuantity = $('#sell .quantity').val(),
			validity = true,
			errorMessage = "";

		if(isNaN(currentQuantity) === true || currentQuantity === "" || currentQuantity < 1){
			validity = false;
			errorMessage = "You must enter a valid number.";
		}
		else if(currentQuantity > $('#sell .resource option:selected').data('quantity')){
			validity = false;
			errorMessage = "You do not have sufficent inventory for this transaction.";
		}

		return({"valid" : validity, "error" : errorMessage});
	}

	var buyAction = {
		"selector" : "#buy",
		"checkValidity" : validPurchase
	};

	var sellAction = {
		"selector" : "#sell",
		"checkValidity" : validSale
	};

	$("#buy .quantity").on("change", buyAction, quantityChange);
	$("#buy .resource").on("change", buyAction, resourceChange);
	$("#buy").on("submit", buyAction, transactionSubmit);

	$("#sell .quantity").on("change", sellAction, quantityChange);
	$("#sell .resource").on("change", sellAction, resourceChange);
	$("#sell").on("submit", sellAction, transactionSubmit);
});