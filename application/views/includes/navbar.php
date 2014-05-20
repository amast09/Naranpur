<div class="navbar">
	<div class="navbar-inner">
		<div class="container">
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			<a class="brand" href="<?=site_url();?>" data-site-url="<?=site_url();?>" name="top">Naranpur</i></a>
			<div class="nav-collapse collapse">
				<ul class="nav">
						<li class="divider-vertical"></li>

      		<li><a href="<?=site_url('/world');?>"><i class="icon-earth"></i> World</a></li>
						<li class="divider-vertical"></li>

     			<li class="dropdown">
						<a class="dropdown-toggle text-error" id="family-updates" data-toggle="dropdown" data-ajax-url="<?=site_url('/family/get_updates')?>"><i class="icon-home3"></i> Family <b class="caret"></b></a>
							<ul class="dropdown-menu span3">
      						<li id="inventoryLink" data-ajax-url="<?=site_url('/family/get_inventory')?>"><a href="#inventoryModal" role="button"  data-toggle="modal"><i class="icon-list-ol"></i> Inventory</a></li>
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

      		<li><a href="<?=site_url('/store');?>"><i class="icon-library"></i> Store</a></li>
						<li class="divider-vertical"></li>

     			<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href=""><i class="icon-leaf"></i> Market <b class="caret"></b></a>
							<ul class="dropdown-menu span3">
								<li>
									<a href="<?=site_url('/listing/view_all_listings');?>">
										<i class="icon-search"></i> View Listings <span id='bid' class="badge badge-info pull-right" style="display:none;">
									</a>
								</li>
									<li class="divider"></li>
								<li>
									<a href="<?=site_url('/transaction/view_all_transactions');?>">
										<i class="icon-stack"></i> View Transactions <span id='win' class="badge badge-info pull-right" style="display:none;">
									</a>
								</li>
							</ul>
					</li>
						<li class="divider-vertical"></li>

     			<li><a href="<?=site_url('/discussion');?>"><i class="icon-bubbles"></i> Forum</a></li>
						<li class="divider-vertical"></li>
     			<li><a href="<?=site_url('/messages');?>"><i class="icon-envelope-alt"></i> Messages <div class="unread-messages"></div></a></li>
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
				     			<a href="<?=site_url('/family/logout');?>"><i class="icon-exit"></i> Logout</a>
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

