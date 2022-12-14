<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
	<?php $this->load->view('top_css'); ?>
	<!-- Custom CSS -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'common/assets/extra-libs/multicheck/multicheck.css'; ?>">
	<link href="<?php echo base_url() . 'common/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css'; ?>" rel="stylesheet">
	<title><?php echo comp_name; ?> | Add Disease</title>
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
						<h4 class="page-title">Add disease</h4>
						<div class="ml-auto text-right">
							<nav aria-label="breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="#">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Add Disease</li>
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
							<form class="form-horizontal" id="create_user_form" action="<?php echo base_admin_url();?>create-disease" method='POST'>
								<div class="card-body">
									<h4 class="card-title">Create New Disease <button type="button" class="btn badge badge-pill badge-success" onclick="location.href='<?php echo base_admin_url() . 'disease-management'; ?>'">Disease List</button></h4>
									<div class="form-group row">
										<label for="full_name" class="col-sm-3 text-right control-label col-form-label">Category</label>
										<div class="col-sm-9">
											<select class="form-control" id="category_name" name="category_name">
												<option value="">Select Category</option>
												<?php
												if (!empty($all_category)) 
												{
													foreach ($all_category as $key => $val) 
													{
												?>
														<option value="<?php echo $val['id']?>"><?php echo $val['category_name']?></option>
												<?php		
													}
												}
												else	
												{
												?>
													<option value="">No Category Found</option>
												<?php	
												}	
												?>
											</select>
											<label id="chk_category_name" style="display: none;"></label>
										</div>
									</div>
									<div class="form-group row">
										<label for="full_name" class="col-sm-3 text-right control-label col-form-label">Disease Name</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" id="disease_name" name="disease_name" placeholder="Disease Name..">
											<label id="chk_disease_name" style="display: none;"></label>
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
	<script type="text/javascript">
		$(document).ready(function() {
		    $('#category_name').select2();
		});
	</script>
</body>

</html>