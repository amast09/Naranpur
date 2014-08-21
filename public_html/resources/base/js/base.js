	$(function(){
		var win = 0;
		var bid = 0;
		var notif = 0;
		var mess = 0;

		updates();

		$.ajax({
			url: $("#date").attr("data-ajax-url"),
			dataType: 'json',
			success: function(data) {
				$('#date').text(data[0].month + '/' + data[0].day + '/' + data[0].year);
			}
		});

		function updates(){
			$.ajax({
				url: $("#family-updates").attr("data-ajax-url"),
				dataType: 'json',
				success: function(data) {
					if(data.mess > 0){
						$('#mess').text(data.mess);
						$('#mess').show();
					} else {
						$('#mess').hide();
					}

					if(data.win > 0) {
						$('#win').text(data.win);
						$('#win').show();
					} else {
						$('#win').hide();
					}

					if(data.bid > 0){
						$('#bid').text(data.bid);
						$('#bid').show();
					} else {
						$('#bid').hide();
					}

					if(data.notif > 0){
						$('#notif').text(data.notif);
						$('#notif').show();
					} else {
						$('#notif').hide();
					}

					if(data.contract > 0){
						$('#contract-notification').text(data.contract).show();
					} else {
						$('#contract-notification').hide();
					}

					if(data.unreadMessages > 0) {
						$(".unread-messages").text("(" + data.unreadMessages + ")");
					} else {
						$(".unread-messages").text();
					}
				}
			});
		}

	$('#inventoryLink').click(function (){
    $.ajax({
      url: $(this).attr("data-ajax-url"),
			dataType: 'json',
      success: function(data) {
				var cat = "";
				var color = 0;
				$('#inventory').empty();
				for(var i = 0; i < data.length; i++){
					if(data[i].category != cat){
						$('#inventory').append('<tr><th>' + data[i].category + '<i class="icon-leaf pull-right"></i></th><th></th><th><i class="icon-plus-sign pull-left"></i></th></tr>');
						cat = data[i].category;
					}

					var resource = $('<tr><td style="text-align:right;">' + data[i].name + '</td><td style="text-align:center">-</td><td style="text-align:left;">' + data[i].quantity + ' ' + data[i].unit + '</td></tr>');
					$('#inventory').append(resource);
				}
      }
    });

  });

  $('#needsLink').click(function (){
    $.ajax({
      url: $(this).attr("data-ajax-url"),
			dataType: 'json',
      success: function(data)
      {
				$('#ga').text( data.available_grain+' kg');
				$('#sa').text( data.available_straw+' kg');
				$('#ma').text( data.available_milk+' L');
				$('#wa').text( data.available_water+' L');
				$('#la').text( data.available_labor+' FLUs');
				$('#ba').text( data.available_BPUs+' BPUs');

				$('#gp').text( data.produced_grain+'kg/yr');
				$('#sp').text( data.produced_straw+'kg/yr');
				$('#mp').text( data.produced_milk.toFixed(3)+' L/wk');
				$('#wp').text( data.produced_water.toFixed(3)+' L/wk');
				$('#lp').text( data.produced_labor.toFixed(3)+' FLUs');
				$('#bp').text( data.produced_BPUs.toFixed(3)+' BPUs');

				$('#gu').text( data.consumed_grain.toFixed(3)+' kg/wk');
				$('#su').text( data.consumed_straw.toFixed(3)+' kg/wk');
				$('#mu').text( data.consumed_milk.toFixed(3)+' L/wk');
				$('#wu').text( data.consumed_water.toFixed(3)+' L/wk');
				$('#lu').text( data.consumed_labor.toFixed(3)+' FLUs');
				$('#bu').text( data.consumed_BPUs.toFixed(3)+' BPUs');

				$('#gt').text( data.depleted_grain );
				$('#st').text( data.depleted_straw );

				if(data.depleted_milk >= 0) {
					$('#mt').text(data.depleted_milk);
				}
				else {
					$('#mt').text( "N/A" );
				}
				if(data.depleted_water >= 0) {
					$('#wt').text( data.depleted_water );
				}
				else{
					$('#wt').text( "N/A" );
				}

				$('#lt').text( data.depleted_labor );
				$('#bt').text( data.depleted_BPUs );
      }
    });
  });

  $('#notsLink').click(function (){
    $.ajax({
      url: $(this).attr("data-ajax-url"),
			dataType: 'json',
      success: function(data) {
				$('#nots').empty();
				for(var i = 0; i < data.length; i++){
					var notification = "";

					if(data[i].seen == 1) {
						notification += '<tr>';
					}
					else {
						notification += '<tr class="info">';
					}
					if(data[i].urgent == 1) {
						notification += '<td><i class="icon-warning-sign"></i></td>';
					}
					else {
						notification += '<td></td>';
					}

					notification += '<td>' + data[i].content + '</td>';
					notification += '<td>' + data[i].timestamp + '</td>';
					notification += '<td><i id="' + data[i].id + '" class="icon-trash" style="cursor:pointer" data-id="' + data[i].id + '"></i></td>';
					notification += '</tr>';

					$('#nots').append(notification);
					$('#'+data[i].id).click(function () {
						$(this).closest('tr').remove();
						$.ajax({
							type: "POST",
							url: $("#notsLink").attr("data-delete-url"),
							data: "id=" + $(this).data('id'),
							dataType: 'json',
								success: function(data){}
						});
					});
				}
      }
    });
  });

		setInterval(updates, 10000);
});