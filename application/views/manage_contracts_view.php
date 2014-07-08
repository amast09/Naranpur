<div class="container-fluid" data-base-url="<?=site_url()?>">

<!-- ######## Current Contracts ######## -->
	<section id="current-contracts" class="row-fluid">
		<legend>
			<h2>Current Contracts</h2>
		</legend>
		<div class="contract-list-wrapper">
			<div id="labels" class="row-fluid">
				<div class="employer span2 offset1">
					<h4 class="title">Employer</h4>
				</div>
				<div class="employee span2">
					<h4 class="title">Employee</h4>
				</div>
				<div class="length span2">
					<h4 class="title">Length</h4>
				</div>
				<div class="resources span5">
					<h4 class="title">Resources</h4>
				</div>
			</div>
			<ul class="contract-list unstyled row-fluid">
				<li class="empty-contracts">You Have No Contracts Currently in Effect.</li>
				<?php
					if($current_contracts->num_rows() > 0) {
					  foreach($current_contracts->result() as $row) {
					  	$row->duration = ($row->duration == -1) ? "On-Going" : $row->duration;
							echo	"<li class='contract' data-contract-id='$row->id' data-employee-member-id='$row->employee_member_id'>
											<div class='actions span1'>
												<button class='btn btn-danger delete-contract' type='button'><i class='icon-remove'></i></button>
											</div>
											<div class='employer span2'>$row->employer_family_name</div>
											<div class='employee span2'>
												<ul class='unstyled'>
										      <li>Family: $row->family_name</li>
										      <li>Member: $row->employee_member_id</li>
										      <li>Age: $row->age</li>
										      <li>Sex: $row->sex</li>
										      <li>Health: $row->health</li>
										      <li>Labor: TODO</li>
										    </ul>
											</div>
											<div class='length span2'>$row->duration</div>
											<div class='resources span5'>
												<ul class='unstyled'>";

							foreach($row->resources->result() as $resource) {
								$resource->on_going = ($resource->on_going == 1) ? "On-Going" : "Once";
								echo	"<li class='resource'>
												<div class='span4'><i class='icon-leaf'></i>&nbsp;<span>$resource->name</span></div>
					       				<div class='span4'><i class='icon-history'></i>&nbsp;<span>$resource->on_going</span></div>
					      				<div class='span4'><i class='icon-plus-sign'></i>&nbsp;<span>$resource->quantity</span></div>
					      			</li>";
							}

							echo		"</ul>
											</div>
											<div class='contract-delete-confirmation'>
												<h4 class='confirmation-text'>Are You Sure You Want to Delete This Contract?</h4>
												<button class='btn btn-success confirm-delete-contract' type='button'>Delete</button>
												<button class='btn btn-danger deny-delete-contract' type='button'>Cancel</button>
											</div>
										</li>";
					  }
					}
				?>
			</ul>
		</div>
	</section>

<!-- ######## Pending Contracts ######## -->
	<section id="pending-contracts">
		<legend>
			<h2>Pending Contracts</h2>
		</legend>
		<div class="contract-list-wrapper">
			<div id="labels" class="row-fluid">
				<div class="employer span2 offset1">
					<h4 class="title">Employer</h4>
				</div>
				<div class="employee span2">
					<h4 class="title">Employee</h4>
				</div>
				<div class="length span2">
					<h4 class="title">Length</h4>
				</div>
				<div class="resources span5">
					<h4 class="title">Resources</h4>
				</div>
			</div>
			<ul class="contract-list unstyled row-fluid">
				<li class="empty-contracts">You Have No Pending Contracts</li>
				<?php
					if($pending_contracts->num_rows() > 0) {
					  foreach($pending_contracts->result() as $row) {
					  	$row->duration = ($row->duration == -1) ? "On-Going" : $row->duration;
							echo	"<li class='contract' data-contract-id='$row->id' data-employee-member-id='$row->employee_member_id'>
											<div class='actions span1'>
												<button class='btn btn-danger delete-contract' type='button'><i class='icon-remove'></i></button>
											</div>
											<div class='employer span2'>$row->employer_family_name</div>
											<div class='employee span2'>
												<ul class='unstyled'>
										      <li>Family: $row->family_name</li>
										      <li>Member: $row->employee_member_id</li>
										      <li>Age: $row->age</li>
										      <li>Sex: $row->sex</li>
										      <li>Health: $row->health</li>
										      <li>Labor: TODO</li>
										    </ul>
											</div>
											<div class='length span2'>$row->duration</div>
											<div class='resources span5'>
												<ul class='unstyled'>";

							foreach($row->resources->result() as $resource) {
								$resource->on_going = ($resource->on_going == 1) ? "On-Going" : "Once";
								echo	"<li class='resource'>
												<div class='span4'><i class='icon-leaf'></i>&nbsp;<span>$resource->name</span></div>
					       				<div class='span4'><i class='icon-history'></i>&nbsp;<span>$resource->on_going</span></div>
					      				<div class='span4'><i class='icon-plus-sign'></i>&nbsp;<span>$resource->quantity</span></div>
					      			</li>";
							}

							echo			"</ul>
											</div>
											<div class='contract-delete-confirmation'>
												<h4 class='confirmation-text'>Are You Sure You Want to Delete This Contract?</h4>
												<button class='btn btn-success confirm-delete-contract' type='button'>Delete</button>
												<button class='btn btn-danger deny-delete-contract' type='button'>Cancel</button>
											</div>
										</li>";
					  }
					}
				?>
			</ul>
		</div>
	</section>

<!-- ######## Proposed Contracts ######## -->
	<section id="proposed-contracts">
		<legend>
			<h2>Proposed Contracts</h2>
		</legend>
		<div class="contract-list-wrapper">
			<div id="labels" class="row-fluid">
				<div class="employer span2 offset1">
					<h4 class="title">Employer</h4>
				</div>
				<div class="employee span2">
					<h4 class="title">Employee</h4>
				</div>
				<div class="length span2">
					<h4 class="title">Length</h4>
				</div>
				<div class="resources span5">
					<h4 class="title">Resources</h4>
				</div>
			</div>
			<ul class="contract-list unstyled row-fluid">
				<li class="empty-contracts">You Have No Proposed Contracts</li>
				<?php
					if($proposed_contracts->num_rows() > 0) {
					  foreach($proposed_contracts->result() as $row) {
					  	$row->duration = ($row->duration == -1) ? "On-Going" : $row->duration;
							echo	"<li class='contract' data-contract-id='$row->id' data-employee-member-id='$row->employee_member_id'>
											<div class='actions span1'>
												<button class='btn btn-success accept-contract' type='button'><i class='icon-checkmark'></i></button>
												<button class='btn btn-danger delete-contract' type='button'><i class='icon-close'></i></button>
											</div>
											<div class='employer span2'>$row->employer_family_name</div>
											<div class='employee span2'>
												<ul class='unstyled'>
										      <li>Family: $row->family_name</li>
										      <li>Member: $row->employee_member_id</li>
										      <li>Age: $row->age</li>
										      <li>Sex: $row->sex</li>
										      <li>Health: $row->health</li>
										      <li>Labor: TODO</li>
										    </ul>
											</div>
											<div class='length span2'>$row->duration</div>
											<div class='resources span5'>
												<ul class='unstyled'>";

							foreach($row->resources->result() as $resource) {
								$resource->on_going = ($resource->on_going == 1) ? "On-Going" : "Once";
								echo	"<li class='resource'>
												<div class='span4'><i class='icon-leaf'></i>&nbsp;<span>$resource->name</span></div>
					       				<div class='span4'><i class='icon-history'></i>&nbsp;<span>$resource->on_going</span></div>
					      				<div class='span4'><i class='icon-plus-sign'></i>&nbsp;<span>$resource->quantity</span></div>
					      			</li>";
							}

							echo		"</ul>
											</div>
											<div class='contract-delete-confirmation'>
												<h4 class='confirmation-text'>Are You Sure You Want to Delete This Contract?</h4>
												<button class='btn btn-success confirm-delete-contract' type='button'>Delete</button>
												<button class='btn btn-danger deny-delete-contract' type='button'>Cancel</button>
											</div>
										</li>";
					  }
					}
				?>
			</ul>
		</div>
	</section>

</div>