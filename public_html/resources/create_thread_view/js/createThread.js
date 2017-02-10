$(function() {
	var familyObject = $.parseJSON($("#families").attr("data-current-families")),
			families = $.map(familyObject, function(element, index){
		return(element.name);
	});

	function split(val){
		return val.split( /,\s*/ );
	}
	function extractLast(term) {
		return split(term).pop();
	}

	$("#families").bind( "keydown", function( event ) {
		// don't navigate away from the field on tab when selecting an item
		if(event.keyCode === $.ui.keyCode.TAB && $(this).data( "ui-autocomplete" ).menu.active ) {
			event.preventDefault();
		}
	}).autocomplete({
			minLength: 0,
			source: function(request, response) {
				// delegate back to autocomplete, but extract the last term
				response($.ui.autocomplete.filter(families, extractLast(request.term)));
			},
			focus: function() {	// prevent value inserted on focus
				return false;
			},
			select: function(event, ui) {
				var terms = split(this.value);
				// remove the current input
				terms.pop();
				// add the selected item
				terms.push(ui.item.value);
				// add placeholder to get the comma-and-space at the end
				terms.push( "" );
				this.value = terms.join( ", " );
				return false;
			}
		});

	var validator = new FormValidator('send-message', [{
		name: 'families',
		display: 'family',
		rules: 'required|callback_checkFamilyList'
	}, {
		name: 'subject',
		rules: 'required'
	}, {
		name: 'message',
		rules: 'required'
	}], function(errors, event) {
			$(".control-group").removeClass("error");
			$(".help-inline").text("");

			if (errors.length > 0) {
				for (var x = 0; x < errors.length; x++) {
					$("#" + errors[x].id).closest(".control-group").addClass('error');
					$("#" + errors[x].id + " ~ .help-inline").text(errors[x].message);
				}
			}
	});

	validator.registerCallback('checkFamilyList', function(value) {
		var recipients = $('#families').val().replace(/,(\s*)$/g, "").split(",");

		for(var z = 0; z < recipients.length; z++){
			if(families.indexOf(recipients[z].trim()) === -1) {
				return(false);
			}
		}
		
		return(true);
	}).setMessage('checkFamilyList', 'Please choose families that exist and seperate the list of families using comas');

});
