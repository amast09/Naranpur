<div id="needsModal" class="modal hide fade">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Family Needs</h3>
  </div>

  <div class="modal-body">
		<table class="table table-condensed table-striped">
			<thead>
				<tr>
					<th></th>
					<th>Stored</th>
					<th>Produced</th>
					<th>Consumed</th>
					<th>Time to Depletion</th>
				</tr>
			</thead>
			<tbody>

				<tr>
					<th>Human Labor</th>
					<td>-</td>
					<td id="lp" class="text-success"></td>
					<td id="lu" class="text-error"></td>
					<td>-</td>
				</tr>

				<tr>
					<th>Animal Labor</th>
					<td>-</td>
					<td id="bp" class="text-success"></td>
					<td id="bu" class="text-error"></td>
					<td>-</td>
				</tr>

				<tr>
					<th>Water</th>
					<td id="wa"></td>
					<td id="wp" class="text-success"></td>
					<td id="wu" class="text-error"></td>
					<td id="wt" class="text-error"></td>
				</tr>
				<tr>
					<th>Grain</th>
					<td id="ga"></td>
					<td class="text-success">See Farm</td>
					<td id="gu" class="text-error"></td>
					<td id="gt" class="text-error"></td>
				</tr>
				<tr>
					<th>Straw</th>
					<td id="sa"></td>
					<td class="text-success">See Farm</td>
					<td id="su" class="text-error"></td>
					<td id="st" class="text-error"></td>
				</tr>
				<tr>
					<th>Milk</th>
					<td id="ma"></td>
					<td id="mp" class="text-success"></td>
					<td id="mu" class="text-error"></td>
					<td id="mt" class="text-error"></td>
				</tr>
			</tbody>
		</table>

  </div>
</div>


<script>

  $('#needsLink').click(function ()
  {
    $.ajax({
      url: "<?=site_url()?>/family/get_status",
      data: "",
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

				if (data.depleted_milk>=0){	$('#mt').text( data.depleted_milk );	}
				else{				$('#mt').text( "N/A" );			}

				if (data.depleted_water>=0){	$('#wt').text( data.depleted_water );	}
				else{				$('#wt').text( "N/A" );			}

				$('#lt').text( data.depleted_labor );
				$('#bt').text( data.depleted_BPUs );

      }
    });
  });

</script>
