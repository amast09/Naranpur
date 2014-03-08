<div class="navbar">
	<div class="navbar-inner">
		<div class="container-fluid">
			<a class="brand" href="<?=site_url();?>" name="top">Naranpur</i></a>
			<div class="nav-collapse collapse">
				<ul class="nav">
						<li class="divider-vertical"></li>

      		<li><a href="<?=site_url('/world');?>"><i class="icon-globe"></i> World</a></li>
						<li class="divider-vertical"></li>

     			<li class="dropdown">
						<a class="dropdown-toggle text-error" id="family-updates" data-toggle="dropdown" data-ajax-url="<?=site_url('/family/get_updates')?>"><i class="icon-home"></i> Family <b class="caret"></b></a>
							<ul class="dropdown-menu span3">
      						<li id="inventoryLink" data-ajax-url="<?=site_url('/family/get_inventory')?>"><a href="#inventoryModal" role="button"  data-toggle="modal"><i class="icon-tasks"></i> Inventory</a></li>
									<li class="divider"></li>
      						<li id="needsLink" data-ajax-url="<?=site_url('/family/get_status')?>"><a href="#needsModal" role="button"  data-toggle="modal"><i class="icon-tint"></i> Needs</a></li>
									<li class="divider"></li>
      						<li id="notsLink" data-ajax-url="<?=site_url('/family/get_notifications')?>" data-delete-url="<?=site_url('family/delete_notification')?>">
										<a href="#notsModal" role="button"  data-toggle="modal">
											<i class="icon-bullhorn"></i> Alerts <span id='notif' class="badge badge-info pull-right" style="display:none;">
										</a>
									</li>
							</ul>
					</li>
						<li class="divider-vertical"></li>

      		<li><a href="<?=site_url('/store');?>"><i class="icon-leaf"></i> Store</a></li>
						<li class="divider-vertical"></li>

     			<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href=""><i class="icon-th"></i> Market <b class="caret"></b></a>
							<ul class="dropdown-menu span3">
								<li>
									<a href="<?=site_url('/listing/view_all_listings');?>">
										<i class="icon-search"></i> View Listings <span id='bid' class="badge badge-info pull-right" style="display:none;">
									</a>
								</li>
									<li class="divider"></li>
								<li>
									<a href="<?=site_url('/transaction/view_all_transactions');?>">
										<i class="icon-barcode"></i> View Transactions <span id='win' class="badge badge-info pull-right" style="display:none;">
									</a>
								</li>
							</ul>
					</li>
						<li class="divider-vertical"></li>

     			<li><a href="<?=site_url('/discussion');?>"><i class="icon-comment"></i> Forum</a></li>
						<li class="divider-vertical"></li>

     			<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href=""><i class="icon-envelope"></i> Messages <b class="caret"></b></a>
							<ul class="dropdown-menu span3">
								<li><a href="<?=site_url('/messages/compose');?>"><i class="icon-pencil"></i> Compose</a></li>
									<li class="divider"></li>
								<li>
									<a href="<?=site_url('/messages/inbox');?>">
										<i class="icon-inbox"></i> Inbox <span id='mess' class="badge badge-info pull-right" style="display:none;"></span>
									</a>
								</li>
									<li class="divider"></li>
								<li><a href="<?=site_url('/messages/outbox');?>"><i class="icon-share"></i> Outbox</a></li>
							</ul>
					</li>

						<li class="divider-vertical"></li>

     			<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href=""><i class="icon-cog"></i> Admin <b class="caret"></b></a>
							<ul class="dropdown-menu span3">
								<li><a href="<?=site_url('/dashboard/help');?>"><i class="icon-question-sign"></i> Help</a></li>
									<li class="divider"></li>
								<li>
									<a href="<?=site_url('/dashboard/reports');?>">
										<i class="icon-folder-open"></i> Reports</a>
								</li>
								<li class="divider"></li>
								<li>
									<a href="<?=site_url('/family/password_change');?>">
										<i class="icon-edit"></i> Change Password</a>
								</li>
								<li class="divider"></li>
								<li>
				     			<a href="<?=site_url('/family/logout');?>"><i class="icon-share"></i> Logout</a>
								</li>
							</ul>
					</li>

						<li class="divider-vertical"></li>

          <li>
						<a disabled=disabled; style="cursor:default;"><i class="icon-calendar"></i> <strong id="date" data-ajax-url="<?=site_url('/family/get_date');?>"></strong></a>
          </li>

				</ul>


				</div>
			</div>
			<!--/.nav-collapse -->
		</div>
		<!--/.container-fluid -->
	</div>
	<!--/.navbar-inner -->
</div>
<!--/.navbar -->

<span class="label label-info"></span>

