<div class="container-fluid">
	<div class="row-fluid">
		<h1>Contract Options</h1>
	</div>
	<div class="row-fluid">
		<div class='span4 family-names'>
			<ul class='family-name-list'>
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
									"<li>" .
										"<div class='span3'>Member</div>" .
										"<div class='span3'>Age</div>" .
										"<div class='span3'>Sex</div>" .
										"<div class='span3'>Health</div>" .
									"</li>";
					}

					echo	"<li class='family-member'>" .
									"<ul class='family-member-stats inline'>" .
										"<li class='name span3'>member-$member_index</li>" .
										"<li class='age span3'>$member->age</li>" .
										"<li class='sex span3'>$member->sex</li>" .
										"<li class='health span3'>$member->health</li>" .
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