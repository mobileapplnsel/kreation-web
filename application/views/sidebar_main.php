<?php
$page =  $this->uri->segment(2);
?>
<aside class="left-sidebar" data-sidebarbg="skin5">
	<!-- Sidebar scroll-->
	<div class="scroll-sidebar">
		<!-- Sidebar navigation-->
		<nav class="sidebar-nav">
			<ul id="sidebarnav" class="p-t-30">
				<li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?php echo base_admin_url(); ?>dashboard" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Dashboard</span></a></li>

				<li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-receipt"></i><span class="hide-menu">Manage </span></a>
					<ul aria-expanded="false" class="collapse  first-level <?php echo ($page == 'add-user' || $page == 'add-room' || $page == 'edit-room' || $page == 'changeroom' || $page == 'upload-room-images' || $page == 'room-availability' || $page == 'add-availability' || $page == 'booking-details') ? 'in' : ''; ?>">

						<li class="sidebar-item <?php echo ($page == 'add-user') ? 'active' : ''; ?>">
							<a href="<?php echo base_admin_url(); ?>users" class="sidebar-link <?php echo ($page == 'add-user') ? 'active' : ''; ?>">
								<i class="mdi mdi-chart-bubble"></i>
								<span class="hide-menu"> User Management</span>
							</a>
						</li>
						<li class="sidebar-item <?php echo ($page == 'add-category') ? 'active' : ''; ?>">
							<a href="<?php echo base_admin_url(); ?>category-management" class="sidebar-link <?php echo ($page == 'add-category') ? 'active' : ''; ?>">
								<i class="mdi mdi-chart-bubble"></i>
								<span class="hide-menu"> Category Management</span>
							</a>
						</li>
						<!-- <li class="sidebar-item <?php echo ($page == 'add-sub-category') ? 'active' : ''; ?>">
							<a href="<?php echo base_admin_url(); ?>sub-category-management" class="sidebar-link <?php echo ($page == 'add-sub-category') ? 'active' : ''; ?>">
								<i class="mdi mdi-chart-bubble"></i>
								<span class="hide-menu">Sub Category Management</span>
							</a>
						</li> -->
						<li class="sidebar-item <?php echo ($page == 'add-disease') ? 'active' : ''; ?>">
							<a href="<?php echo base_admin_url(); ?>disease-management" class="sidebar-link <?php echo ($page == 'add-disease') ? 'active' : ''; ?>">
								<i class="mdi mdi-chart-bubble"></i>
								<span class="hide-menu"> Disease Management</span>
							</a>
						</li>
						<li class="sidebar-item <?php echo ($page == 'add-chart') ? 'active' : ''; ?>">
							<a href="<?php echo base_admin_url(); ?>chart-management" class="sidebar-link <?php echo ($page == 'add-chart') ? 'active' : ''; ?>">
								<i class="mdi mdi-chart-bubble"></i>
								<span class="hide-menu"> Chart Management</span>
							</a>
						</li>
					</ul>
				</li>

				<!-- <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-receipt"></i><span class="hide-menu">Billing </span></a>
					<ul aria-expanded="false" class="collapse  first-level <?php echo ($page == 'checklist2-bills') ? 'in' : ''; ?>">

						<li class="sidebar-item"><a href="<?php echo base_admin_url(); ?>checklist-bills" class="sidebar-link"><i class="mdi mdi-chart-bubble"></i><span class="hide-menu"> Booking Details</span></a></li>
	
					</ul>
				</li> -->

			</ul>
		</nav>
		<!-- End Sidebar navigation -->
	</div>
	<!-- End Sidebar scroll-->
</aside>