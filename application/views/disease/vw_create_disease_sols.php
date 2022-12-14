<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
	<?php $this->load->view('top_css'); ?>
	<!-- Custom CSS -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'common/assets/extra-libs/multicheck/multicheck.css'; ?>">
	<link href="<?php echo base_url() . 'common/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css'; ?>" rel="stylesheet">
	<title><?php echo comp_name; ?> | Add Disease Solution</title>
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
						<h4 class="page-title">Add Disease Solution For <?php echo $disease_details->disease_name;?></h4>
						<div class="ml-auto text-right">
							<nav aria-label="breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="#">Home</a></li>
									<li class="breadcrumb-item"><a href="<?php echo base_admin_url().'disease-management';?>">Disease Management</a></li>
									<li class="breadcrumb-item active" aria-current="page">Add Disease Solution</li>
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
							<form class="form-horizontal" id="create_disease_sol" action="<?php echo base_admin_url();?>create-disease-sol" method='POST' enctype='multipart/form-data'>
								<input type="hidden" name="dis_id" value="<?php echo decode_url(xss_clean($this->uri->segment(3)));?>">
								<div class="card-body">
									<h4 class="card-title">Create New Disease Solution<button type="button" class="btn badge badge-pill badge-success" onclick="location.href='<?php echo base_admin_url() . 'disease-sols-list/'.$this->uri->segment(3); ?>'">Disease Solutions List</button></h4>
									<div class="form-group row">
										<label for="full_name" class="col-sm-3 text-right control-label col-form-label">Disease Solution Name <ins style="color: red;text-decoration: none;">*</ins></label>
										<div class="col-sm-9">
											<!-- <input type="text" class="form-control" id="disease_sol_name" name="disease_sol_name" placeholder="Disease Solution Name.."> -->
											<select class="form-control" id="disease_sol_name" name="disease_sol_name">
												<option value="Ayurvedic">Ayurvedic</option>
												<option value="TCM  (Tradition Chinese Medicine)">TCM (Tradition Chinese Medicine)</option>
												<option value="Chakra">Chakra</option>
												<option value="Mega Meridian">Mega Meridian</option>
												<option value="EAV">EAV</option>
												<option value="Dr. Volls">Dr. Volls</option>
												<option value="Colour">Colour</option>
												<option value="CM in AM">CM in AM</option>
												<option value="Single Point">Single Point</option>
												<option value="Tissue Meridian in Ayurvedic Medicine">Tissue Meridian in Ayurvedic Medicine</option>
											</select>
											<label id="chk_disease_sol_name" style="display: none;"></label>
										</div>
									</div>
									<div class="form-group row">
										<label for="full_name" class="col-sm-3 text-right control-label col-form-label">Protocol <ins style="color: red;text-decoration: none;">*</ins></label>
										<div class="col-sm-9">
											<textarea class="form-control" id="disease_sol_protocol" name="disease_sol_protocol" placeholder="Protocol.."></textarea>
											<label id="chk_disease_sol_protocol" style="display: none;"></label>
										</div>
									</div>
									<div class="form-group row">
										<label for="full_name" class="col-sm-3 text-right control-label col-form-label">Protocol Image</label>
										<div class="col-sm-9">
											<input type="file" class="form-control" id="disease_sol_protocol_img" name="disease_sol_protocol_img">
											<label id="chk_disease_sol_protocol_img" style="display: none;"></label>
										</div>
									</div>
								</div>
								<div class="border-top">
									<div class="card-body">
										<button type="submit" id="user_btn_submit" class="btn btn-primary user_btn_submit" disabled>Submit</button>
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
	<script src="<?php echo base_url() . 'common/dist/js/app/disease.js?v=' . random_strings(6); ?>"></script>

</body>

</html>