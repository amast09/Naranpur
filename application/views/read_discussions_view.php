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

