<div class="container-fluid">
<?php
	$sort_by = ($this->uri->segment(4) == '')? 'timestamp' : $this->uri->segment(4);
	$sort_order = ($this->uri->segment(5) == 'ASC') ? 'ASC' : 'DESC';
	$offset = ($this->uri->segment(6) == '') ? 0 : $this->uri->segment(6);
	$next_sort_order = ($this->uri->segment(5) == 'ASC') ? 'DESC' : 'ASC';
	$next = $offset + 10;
	$prev = $offset - 10;
	$total = $comments->num_rows(); 
	$dis = $discussion->row();
?>

	<h4 style="text-align:center;">Discussion Topic</h4>
	<div class="row-fluid" style="text-align:center;">
		<div class="span4">
			<div id="fam"></div>
			<p><?=$dis->name;?></p>
		</div>
		<div class="span4">
			<div id="dat"></div>
			<p><?=$dis->timestamp;?></p>
		</div>
		<div class="span4">
			<div id="sub"></div>
			<p><?=$dis->subject;?></p>
		</div>
	</div>

	<p class="well"><?=$dis->content;?><p>
<hr></hr>


	<div class="row-fluid">
		<ul class="nav nav-pills">
			<li class="disabled"><a><strong>Comments</strong></a></li>
			<li class="disabled"><a>Sort by: </a></li>

			<li class="<?php if($sort_by == 'timestamp') echo 'active';?>">
				<a href='
					<?php
						if($sort_by == 'timestamp') echo site_url("discussion/see_comments/$diss_id/timestamp/$next_sort_order/$offset");
						else echo site_url("discussion/see_comments/$diss_id/timestamp/$sort_order/$offset");
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
						if($sort_by == 'name') echo site_url("discussion/see_comments/$diss_id/name/$next_sort_order/$offset");
						else echo site_url("discussion/see_comments/$diss_id/name/$sort_order/$offset");
					?>
				'>
					<strong>
						Author
						<i class="<?php if($sort_by == 'name') echo ($sort_order == 'ASC') ? 'icon-chevron-up' : 'icon-chevron-down';?>"></i>
					</strong>
				</a>
			</li>

			<li class="pull-right">
				<a class="btn" data-toggle="modal" href="#myModal" >Add Comment</a>
			</li>

		</ul>

		<?php $this->load->view('modals/create_comment'); ?> 
 
	</div>

	<div class="row-fluid">
		<table class="table table-striped table-bordered table condensed">
			<?php foreach($comments->result_array() as $entry):?>
			<tr>
				<td class="span2">
					<div id="user"></div>
					<div><h5><?=$entry['name'];?></h5></div>
				</td>
				<td class="span8">
					<div id="comment_icon"></div>
					<p><?=$entry['comment'];?></p>
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
    	<a href="<?=site_url("discussion/see_comments/$diss_id/$sort_by/$sort_order/$prev")?>">
				<i class="icon-chevron-left"></i>
			</a>
  	</li>
  	<li class="next" style="<?php if($total < $next) echo "display:none;";?>">
    	<a href="<?=site_url("discussion/see_comments/$diss_id/$sort_by/$sort_order/$next")?>">
				<i class="icon-chevron-right"></i>
			</a>
  	</li>
	</ul>

</div>

<script src="<?=base_url("/resources/read_discussion_view/js/createComment.js");?>"></script>