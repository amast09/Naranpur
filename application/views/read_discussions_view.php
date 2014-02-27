<script src="<?php echo base_url("/resources/base/js/raphael.js");?>"></script>
<div class="container-fluid">
<?php
	$sort_by = ($this->uri->segment(3) == '')? 'timestamp' : $this->uri->segment(3);
	$sort_order = ($this->uri->segment(4) == 'ASC') ? 'ASC' : 'DESC';
	$offset = ($this->uri->segment(5) == '') ? 0 : $this->uri->segment(5);
	$next_sort_order = ($this->uri->segment(4) == 'ASC') ? 'DESC' : 'ASC';
	$next = $offset + 10;
	$prev = $offset - 10;
	$total = $result->num_rows(); 
?>
	<h4>Discussions</h4>

	<div class="row-fluid">
		<ul class="nav nav-pills">
			<li class="disabled"><a>Sort by: </a></li>

			<li class="<?php if($sort_by == 'timestamp') echo 'active';?>">
				<a href='
					<?php
						if($sort_by == 'timestamp') echo site_url('discussion/all/timestamp/'.$next_sort_order.'/'.$offset);
						else echo site_url('discussion/all/timestamp/'.$sort_order.'/'.$offset);
					?>
				'>
					<strong>
						Date
						<i class="<?php if($sort_by == 'timestamp') echo ($sort_order == 'ASC') ? 'icon-chevron-up' : 'icon-chevron-down';?>"></i>
					</strong>
				</a>
			</li>

			<li class="<?php if($sort_by == 'name') echo 'active';?>">
				<a href='
					<?php
						if($sort_by == 'name') echo site_url('discussion/all/name/'.$next_sort_order.'/'.$offset);
						else echo site_url('discussion/all/name/'.$sort_order.'/'.$offset);
					?>
				'>
					<strong>
						Author
						<i class="<?php if($sort_by == 'name') echo ($sort_order == 'ASC') ? 'icon-chevron-up' : 'icon-chevron-down';?>"></i>
					</strong>
				</a>
			</li>

			<li class="<?php if($sort_by == 'comments') echo 'active';?>">
				<a href='
					<?php
						if($sort_by == 'comments') echo site_url('discussion/all/comments/'.$next_sort_order.'/'.$offset);
						else echo site_url('discussion/all/comments/'.$sort_order.'/'.$offset);
					?>
				'>
					<strong>
						Comments
						<i class="<?php if($sort_by == 'comments') echo ($sort_order == 'ASC') ? 'icon-chevron-up' : 'icon-chevron-down';?>"></i>
					</strong>
				</a>
			</li>

			<li class="pull-right">
				<a class="btn" data-toggle="modal" href="#myModal" >Add Discussion</a>
			</li>

		</ul>
 
		<?php $this->load->view('modals/create_discussion'); ?> 
	
	</div>

	<div class="row-fluid">
		<table class="table table-hover table-striped table-bordered table condensed">
			<?php foreach($result->result_array() as $entry):?>
			<tr style="cursor:pointer"; onclick="document.location = '<?=site_url('discussion/see_comments/'.$entry['id']);?>';">
				<td class="span2">
					<div id="user"></div>
					<h5><?=$entry['name'];?></h5>
				</td>
				<td class="span7">
					<h5><i><?=$entry['subject'];?></i></h5>
					<p><?=$entry['content'];?></p>
				</td>
				<td class="span1">
					<div id="comment_icon"></div>
					<div><h4><?=$entry['comments'];?></h4></div>
				</td>
				<td class="span2">
					<div id="clock"></div>
					<div><h5><?=$entry['timestamp'];?></h5></div>
				</td>
			</tr>
			<?php endforeach;?>
		</table>
	</div>

	<ul class="pager">
  	<li class="previous" style="<?php if($prev < 0) echo "display:none;";?>">
    	<a href="<?=site_url('discussion/all/'.$sort_by.'/'.$sort_order.'/'.$prev)?>">
				<i class="icon-chevron-left"></i>
			</a>
  	</li>
  	<li class="next" style="<?php if($total < $next) echo "display:none;";?>">
    	<a href="<?=site_url('discussion/all/'.$sort_by.'/'.$sort_order.'/'.$next)?>">
				<i class="icon-chevron-right"></i>
			</a>
  	</li>
	</ul>

</div>

<script>
$(document).ready(function() {
	var bubble = "M16,5.333c-7.732,0-14,4.701-14,10.5c0,1.982,0.741,3.833,2.016,5.414L2,25.667l5.613-1.441c2.339,1.317,5.237,2.107,8.387,2.107c7.732,0,14-4.701,14-10.5C30,10.034,23.732,5.333,16,5.333z";
	var clock = "M15.5,2.374C8.251,2.375,2.376,8.251,2.374,15.5C2.376,22.748,8.251,28.623,15.5,28.627c7.249-0.004,13.124-5.879,13.125-13.127C28.624,8.251,22.749,2.375,15.5,2.374zM15.5,25.623C9.909,25.615,5.385,21.09,5.375,15.5C5.385,9.909,9.909,5.384,15.5,5.374c5.59,0.01,10.115,4.535,10.124,10.125C25.615,21.09,21.091,25.615,15.5,25.623zM8.625,15.5c-0.001-0.552-0.448-0.999-1.001-1c-0.553,0-1,0.448-1,1c0,0.553,0.449,1,1,1C8.176,16.5,8.624,16.053,8.625,15.5zM8.179,18.572c-0.478,0.277-0.642,0.889-0.365,1.367c0.275,0.479,0.889,0.641,1.365,0.365c0.479-0.275,0.643-0.887,0.367-1.367C9.27,18.461,8.658,18.297,8.179,18.572zM9.18,10.696c-0.479-0.276-1.09-0.112-1.366,0.366s-0.111,1.09,0.365,1.366c0.479,0.276,1.09,0.113,1.367-0.366C9.821,11.584,9.657,10.973,9.18,10.696zM22.822,12.428c0.478-0.275,0.643-0.888,0.366-1.366c-0.275-0.478-0.89-0.642-1.366-0.366c-0.479,0.278-0.642,0.89-0.366,1.367C21.732,12.54,22.344,12.705,22.822,12.428zM12.062,21.455c-0.478-0.275-1.089-0.111-1.366,0.367c-0.275,0.479-0.111,1.09,0.366,1.365c0.478,0.277,1.091,0.111,1.365-0.365C12.704,22.344,12.54,21.732,12.062,21.455zM12.062,9.545c0.479-0.276,0.642-0.888,0.366-1.366c-0.276-0.478-0.888-0.642-1.366-0.366s-0.642,0.888-0.366,1.366C10.973,9.658,11.584,9.822,12.062,9.545zM22.823,18.572c-0.48-0.275-1.092-0.111-1.367,0.365c-0.275,0.479-0.112,1.092,0.367,1.367c0.477,0.275,1.089,0.113,1.365-0.365C23.464,19.461,23.3,18.848,22.823,18.572zM19.938,7.813c-0.477-0.276-1.091-0.111-1.365,0.366c-0.275,0.48-0.111,1.091,0.366,1.367s1.089,0.112,1.366-0.366C20.581,8.702,20.418,8.089,19.938,7.813zM23.378,14.5c-0.554,0.002-1.001,0.45-1.001,1c0.001,0.552,0.448,1,1.001,1c0.551,0,1-0.447,1-1C24.378,14.949,23.929,14.5,23.378,14.5zM15.501,6.624c-0.552,0-1,0.448-1,1l-0.466,7.343l-3.004,1.96c-0.478,0.277-0.642,0.889-0.365,1.365c0.275,0.479,0.889,0.643,1.365,0.367l3.305-1.676C15.39,16.99,15.444,17,15.501,17c0.828,0,1.5-0.671,1.5-1.5l-0.5-7.876C16.501,7.072,16.053,6.624,15.501,6.624zM15.501,22.377c-0.552,0-1,0.447-1,1s0.448,1,1,1s1-0.447,1-1S16.053,22.377,15.501,22.377zM18.939,21.455c-0.479,0.277-0.643,0.889-0.366,1.367c0.275,0.477,0.888,0.643,1.366,0.365c0.478-0.275,0.642-0.889,0.366-1.365C20.028,21.344,19.417,21.18,18.939,21.455z";
	var user = "M20.771,12.364c0,0,0.849-3.51,0-4.699c-0.85-1.189-1.189-1.981-3.058-2.548s-1.188-0.454-2.547-0.396c-1.359,0.057-2.492,0.792-2.492,1.188c0,0-0.849,0.057-1.188,0.397c-0.34,0.34-0.906,1.924-0.906,2.321s0.283,3.058,0.566,3.624l-0.337,0.113c-0.283,3.283,1.132,3.68,1.132,3.68c0.509,3.058,1.019,1.756,1.019,2.548s-0.51,0.51-0.51,0.51s-0.452,1.245-1.584,1.698c-1.132,0.452-7.416,2.886-7.927,3.396c-0.511,0.511-0.453,2.888-0.453,2.888h26.947c0,0,0.059-2.377-0.452-2.888c-0.512-0.511-6.796-2.944-7.928-3.396c-1.132-0.453-1.584-1.698-1.584-1.698s-0.51,0.282-0.51-0.51s0.51,0.51,1.02-2.548c0,0,1.414-0.397,1.132-3.68H20.771z";

	var elements = document.querySelectorAll('#comment_icon');
	for (i = 0; i < elements.length; i++) {
	    paper = Raphael(elements[i], 30, 30)
	    paper.path(bubble).attr({"fill": "#333", transform: "s.75"})
	}

	elements = document.querySelectorAll('#clock');
	for (i = 0; i < elements.length; i++) {
	    paper = Raphael(elements[i], 30, 30)
	    paper.path(clock).attr({"fill": "#333", transform: "s.75"})
	}

	elements = document.querySelectorAll('#user');
	for (i = 0; i < elements.length; i++) {
	    paper = Raphael(elements[i], 30, 30)
	    paper.path(user).attr({"fill": "#333", transform: "s.75"})
	}

});
</script>

