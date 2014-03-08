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
