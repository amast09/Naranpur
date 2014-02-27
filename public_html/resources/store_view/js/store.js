$(function() {

	var buy = function(){
		var quantity = "#buyQuantitySelectBox";
		var item = "#buyItemSelect";
		var cash = "#player-cash";

		function quantityChange(){
			updateTotals();
			var transaction = validPurchase();
			if(transaction.valid){
				$('#error').hide();
				$('#buyButton').removeAttr("disabled");
			} else {
				$('#buyButton').attr("disabled", "disabled");
				$('#error_message').text(transaction.error);
				$('#error').show();
			}
		}

		function resourceChange(){
			$('#error').hide();
			resetTotals();
			var transaction = validPurchase();
			if(transaction.valid){
				$('#error').hide();
				$('#buyButton').removeAttr("disabled");
			} else {
				$('#buyButton').attr("disabled", "disabled");
				$('#error_message').text(transaction.error);
				$('#error').show();
			}
		}

		function purchaseSubmit(){
			return(validPurchase().valid);
		}

		function validPurchase(){
			var currentQuantity = parseFloat($(quantity).val()),
				currentPrice = parseFloat($(item + ' option:selected').attr("data-price")),
				currentAvailable = parseFloat($(item + ' option:selected').attr("data-quantity")),
				currentCash = parseFloat($(cash).attr("data-player-cash")),
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

		function updateTotals(){
			var currentQuantity = parseFloat($(quantity).val()),
				currentPrice = parseFloat($(item + ' option:selected').attr("data-price")),
				currentCash = parseFloat($(cash).attr("data-player-cash")),
				costOfTransaction = (currentQuantity * currentPrice);

			$("#buyCost").val("Price: " + costOfTransaction);
			$("#buyAvailable").val("Updated Cash: " + (currentCash - costOfTransaction));
		}

		function resetTotals(){
			$(quantity).val(1);
			$(quantity).attr("max", $('option:selected', this).data('quantity'));
		}

		return({
			"quantityChange" : quantityChange,
			"resourceChange" : resourceChange,
			"purchaseSubmit" : purchaseSubmit
		});
	};

	$("#buyQuantitySelectBox").on("change", buy().quantityChange);
	$("#buyItemSelect").on("change", buy().resourceChange);
	$("#buy_form").on("submit", buy().purchaseSubmit);
});