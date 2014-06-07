<!-- Steps of Contract Creation -->
<div class="wrap step-1">

	<!-- Employee Choosing Step -->
	<div class="container-fluid employee-option">
		<div class="row-fluid">
			<h1>Choose the Employee</h1>
		</div>
		<div class="row-fluid">
			<div class='span4 family-names'>
				<ul class='family-name-list'>
					<li class="header">Family</li>
					<?php
						foreach($families->result() as $family) {
							echo "<li class='family-name' data-family-name='$family->name'>$family->name</li>";
						}
					?>
				</ul>
			</div>

			<div class='span8 family-members'>
				<?php
					$last_family = "";
					$member_index = 0;
					for($i = 0; $i < $members->num_rows(); $i++) {
						$member = $members->row($i);
						$member_index++;
						$start_of_family = $last_family != $member->family_name;
						$end_of_family = ($i == $members->num_rows() - 1 || $member->family_name != $members->row($i + 1)->family_name);

						if($start_of_family){
							echo "<ul class='family-member-list' id='family-$member->family_name'>" .
										"<li class='header'>" .
											"<ul class='family-member-stats inline'>" .
												"<li class='span3'>Member</li>" .
												"<li class='span2'>Age</li>" .
												"<li class='span2'>Sex</li>" .
												"<li class='span2'>Health</li>" .
												"<li class='span3'>Labor</li>" .
											"</ul>" .
										"</li>";
						}

						echo	"<li class='family-member'>" .
										"<ul class='family-member-stats inline'>" .
											"<li class='name span3'>member-$member_index</li>" .
											"<li class='age span2'>$member->age</li>" .
											"<li class='sex span2'>$member->sex</li>" .
											"<li class='health span2'>$member->health</li>" .
											"<li class='labor span3'>120</li>" .
										"</ul>" .
									"</li>";

						if($end_of_family) {
							echo "</ul>";
							$member_index = 0;
						}

						$last_family = $member->family_name;
					}
				?>
			</div>
		</div>
	</div>

	<!-- Resource Choosing Step -->
	<div class="container-fluid resources-option">
		<div class="row-fluid">
			<h1>Choose the Resources</h1>
		</div>
	</div>

	<!-- Contract Review Step -->
	<div class="container-fluid review-option">
		<div class="row-fluid">
			<h1>Review the Contract</h1>
		</div>
	</div>

</div>

<!-- Navigation of Contract Creation Next/Previous Buttons -->
<div class="container-fluid navigation">
	<div class="row-fluid">
		<button class="btn btn-primary pull-left previous" type="button">Previous</button>
		<button class="btn btn-primary pull-right next" type="button">Next</button>
	</div>
</div>

