<div id="family" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="familyLabel" aria-hidden="true">
	<div class="modal-header">
		<h4>Family Members<button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button></br></h4>
	</div>
	<div class="modal-body">
		<table class="table table-striped">
			<thead>
	    		<tr>
	    			<th>Member</th>
	      			<th>Age</th>
	      			<th>Sex</th>
	      			<th>Health</th>
				</tr>
			</thead>
			<tbody>
				<?php $i = 1;?>
				<?php foreach($family->result() as $member){ ?>
					<tr>
						<td><?=$i;?></td>
						<td><?=$member->age;?></td>
						<td><?=$member->sex;?></td>
						<td><?=$member->health;?></td>
					</tr>
				<?php $i++;  } ?>
			</tbody>
		</table>
	</div>
</div>

