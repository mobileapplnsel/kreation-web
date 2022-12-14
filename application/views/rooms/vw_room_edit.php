<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
	<?php $this->load->view('top_css'); ?>
	<!-- Custom CSS -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'common/assets/extra-libs/multicheck/multicheck.css'; ?>">
	<link href="<?php echo base_url() . 'common/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css'; ?>" rel="stylesheet">
	<title><?php echo comp_name; ?> | <?php echo $page_title; ?></title>
</head>

<body>
	<!-- ============================================================== -->
	<!-- Preloader - style you can find in spinners.css -->
	<!-- ============================================================== -->
	<div class="preloader">
		<div class="lds-ripple">
			<div class="lds-pos"></div>
			<div class="lds-pos"></div>
		</div>
	</div>
	<!-- ============================================================== -->
	<!-- Main wrapper - style you can find in pages.scss -->
	<!-- ============================================================== -->
	<div id="main-wrapper">
		<!-- ============================================================== -->
		<!-- Topbar header - style you can find in pages.scss -->
		<?php $this->load->view('header_main'); ?>
		<!-- End Topbar header -->
		<!-- Left Sidebar - style you can find in sidebar.scss  -->
		<?php $this->load->view('sidebar_main'); ?>
		<!-- End Left Sidebar - style you can find in sidebar.scss  -->
		<!-- ============================================================== -->
		<div class="page-wrapper">
			<!-- ============================================================== -->
			<div class="page-breadcrumb">
				<div class="row">
					<div class="col-12 d-flex no-block align-items-center">
						<h4 class="page-title">Edit <?php echo $page_title; ?></h4>
						<div class="ml-auto text-right">
							<nav aria-label="breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="#">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Edit <?php echo $page_title; ?></li>
								</ol>
							</nav>
						</div>
					</div>
				</div>
			</div>
			<!-- ============================================================== -->
			<div class="container-fluid">
				<!-- ============================================================== -->
				<div class="row">
					<div class="col-12">
						<div class="card">
							<?php
							if (isset($update_success) && $update_success != '') {
								echo "<p><i class=\"icofont-tick-boxed\" style=\"color:green\"></i> Status: " . $update_success . "</p>";
							} elseif (isset($update_failure) && $update_failure != '') {
								echo "<p><i class=\"fas fa-exclamation-triangle\" style=\"color:yellow\"></i> Error: " . $update_failure . "</p>";
							} else {
								//echo "<p style='color:#f5f2f0'><i class=\"fas fa-exclamation-triangle\" style=\"color:yellow\"></i> Something went wrong!</p>";
							}
							?>
							<form class="form-horizontal" method="post" action="<?php echo base_admin_url() . 'changeroom'; ?>">

								<div class="card-body">
									<h4 class="card-title"><?php echo $page_title; ?> Info</h4>

									<div class="form-group row">
										<label for="bed_type" class="col-sm-3 text-right control-label col-form-label">Bed type</label>
										<div class="col-sm-9">
											<select class="select2 form-control custom-select" style="width: 100%; height:36px;" id="bed_type" name="bed_type" required>
												<option value="">Select</option>
												<option value="king" <?php echo (isset($edit_data) && $edit_data['bed_type'] == 'king') ? 'selected' : ''; ?>>King</option>
												<option value="queen" <?php echo (isset($edit_data) && $edit_data['bed_type'] == 'queen') ? 'selected' : ''; ?>>Queen</option>
											</select>
										</div>
									</div>

									<div class="form-group row">
										<label for="with_breakfast" class="col-sm-3 text-right control-label col-form-label">With Breakfast</label>
										<div class="col-sm-9">
											<select class="select2 form-control custom-select" style="width: 100%; height:36px;" id="with_breakfast" name="with_breakfast" required>
												<option value="">Select</option>
												<option value="yes" <?php echo (isset($edit_data) && $edit_data['with_breakfast'] == 'yes') ? 'selected' : ''; ?>>Yes</option>
												<option value="no" <?php echo (isset($edit_data) && $edit_data['with_breakfast'] == 'no') ? 'selected' : ''; ?>>No</option>
											</select>
										</div>
									</div>



									<div class="form-group row">
										<label for="name" class="col-sm-3 text-right control-label col-form-label"><?php echo $page_title; ?> Name</label>
										<div class="col-sm-9">
											<input type="hidden" name="rm_id" value="<?php echo ($edit_data) ? $edit_data['roomid'] : ''; ?>">
											<input type="text" class="form-control" name="name" id="name" placeholder="<?php echo $page_title; ?> Name.." value="<?php echo ($edit_data) ? $edit_data['name'] : ''; ?>" required="">
											<label id="chk_name" style="display: none;"></label>
										</div>
									</div>

									
									<div class="form-group row">
										<label for="room_view_type" class="col-sm-3 text-right control-label col-form-label"><?php echo $page_title; ?> View Type</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" id="room_view_type" name="room_view_type" placeholder="<?php echo $page_title; ?> View Type.." autocomplete="off" value="<?php echo ($edit_data) ? $edit_data['room_view_type'] : ''; ?>" required>
										</div>
									</div>

									<div class="form-group row">
										<label for="max_room_capacity" class="col-sm-3 text-right control-label col-form-label">Max <?php echo $page_title; ?> Capacity</label>
										<div class="col-sm-9">
											<input type="number" class="form-control" id="max_room_capacity" name="max_room_capacity" placeholder="Room Capacity.." autocomplete="off"  value="<?php echo ($edit_data) ? $edit_data['max_room_capacity'] : ''; ?>" required>
										</div>
									</div>


									<div class="form-group row">
										<label for="total_adults" class="col-sm-3 text-right control-label col-form-label">Total Adults</label>
										<div class="col-sm-9">
											<input type="number" class="form-control" id="total_adults" name="total_adults" placeholder="Total Adults.." autocomplete="off" value="<?php echo ($edit_data) ? $edit_data['total_adults'] : ''; ?>" required>
										</div>
									</div>


									<div class="form-group row">
										<label for="total_kids" class="col-sm-3 text-right control-label col-form-label">Total Kids</label>
										<div class="col-sm-9">
											<input type="number" class="form-control" id="total_kids" name="total_kids" placeholder="Total Kids.." autocomplete="off" value="<?php echo ($edit_data) ? $edit_data['total_kids'] : ''; ?>" required>
										</div>
									</div>

									<div class="form-group row">
										<label for="room_desc" class="col-sm-3 text-right control-label col-form-label"><?php echo $page_title; ?> <?php echo $page_title; ?> Description</label>
										<div class="col-sm-9">
											<textarea type="text" class="form-control" id="room_desc" name="room_desc" placeholder="Room Description.." autocomplete="off" required><?php echo ($edit_data) ? $edit_data['room_desc'] : ''; ?></textarea>
										</div>
									</div>

									<div class="form-group row">
										<label for="amenities" class="col-sm-3 text-right control-label col-form-label"><?php echo $page_title; ?> <?php echo $page_title; ?> Amenities</label>
										<div class="col-sm-9">
											<textarea type="text" class="form-control" id="amenities" name="amenities" placeholder="Room Amenities.." autocomplete="off" required><?php echo ($edit_data) ? $edit_data['amenities'] : ''; ?></textarea>
										</div>
									</div>

								</div>
								<div class="border-top">
									<div class="card-body">
										<button type="submit" id="submit" class="btn btn-primary customer_btn_submit">Submit</button>
									</div>
								</div>
							</form>

						</div>
					</div>
				</div>
				<!-- ============================================================== -->
			</div>
			<!-- ============================================================== -->
			<!-- End Container fluid  -->
			<!-- ============================================================== -->
			<!-- ============================================================== -->
			<!-- footer -->
			<!-- ============================================================== -->
			<?php $this->load->view('footer'); ?>
			<!-- ============================================================== -->
			<!-- End footer -->
			<!-- ============================================================== -->
		</div>
		<!-- ============================================================== -->
		<!-- End Page wrapper  -->
		<!-- ============================================================== -->
	</div>
	<!-- ============================================================== -->
	<!-- End Wrapper -->
	<?php $this->load->view('bottom_js'); ?>
	<!-- this page js -->
	<script src="<?php echo base_url() . 'common/assets/extra-libs/multicheck/datatable-checkbox-init.js'; ?>"></script>
	<script src="<?php echo base_url() . 'common/assets/extra-libs/multicheck/jquery.multicheck.js'; ?>"></script>
	<script src="<?php echo base_url() . 'common/assets/extra-libs/DataTables/datatables.min.js'; ?>"></script>
	<script src="<?php echo base_url() . 'common/dist/js/app/rooms.js?v=' . random_strings(6); ?>"></script>

	<script>
		$("#bed_type").select2({
			placeholder: "Select Bed Type",
			allowClear: true
		});
		$("#with_breakfast").select2({
			placeholder: "Select Breakfast",
			allowClear: true
		});
	</script>
</body>

</html>