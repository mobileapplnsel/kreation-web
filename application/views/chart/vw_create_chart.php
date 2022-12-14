<!DOCTYPE html>
<html dir="ltr" lang="en">
<style type="text/css">
	
.add-box {
    padding-right: 80px;
    position: relative;
    border-top: solid 1px #ddd;
    margin-bottom: 15px;
    padding-top: 15px;
}

.action-part {
    position: absolute;
    top: 10px;
    right: 10px;
}

.add-box input.form-control {
    margin-bottom: 15px;
}

.add-box .action-part .action-icn a {
    color: #a1a1a1;
    font-weight: bold;
    font-size: 18px;
}

.add-box .action-part .action-icn {
    padding: 3px;
}

.add-box:first-child {
    border-top: 0;
    padding-top: 0;
}

</style>

<head>
	<?php $this->load->view('top_css'); ?>
	<!-- Custom CSS -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'common/assets/extra-libs/multicheck/multicheck.css'; ?>">
	<link href="<?php echo base_url() . 'common/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css'; ?>" rel="stylesheet">
	<title><?php echo comp_name; ?> | Add Chart</title>
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
						<h4 class="page-title">Add Chart</h4>
						<div class="ml-auto text-right">
							<nav aria-label="breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="#">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Add Chart</li>
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
							<form class="form-horizontal" id="create_user_form" action="<?php echo base_admin_url();?>create-chart" method='POST' enctype='multipart/form-data' novalidate>
								<div class="card-body">
									<h4 class="card-title">Create New Chart <button type="button" class="btn badge badge-pill badge-success" onclick="location.href='<?php echo base_admin_url() . 'chart-management'; ?>'">Chart List</button></h4>
									<div class="form-group row">
										<label for="full_name" class="col-sm-3 text-right control-label col-form-label">Chart Name</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" id="chart_name" name="chart_name" placeholder="Chart Name.." required>
											<label id="chk_chart_name" style="display: none;"></label>
										</div>
									</div>

									<div class="form-group row">
										<div class="col-sm-12 text-right">
											<button type="button" counter="0" id="add_more_files" onclick="addMoreBrowseArea();" class="btn btn-primary user_btn_submit addrow-btn">Add More</button>
										</div>
									</div>

									<input type="hidden" name="total_counter_attachment" id="total_counter_attachment" value=""/>
									<div class="form-group" id="mainAttachmentDiv" >
										<div id="loopDiv" style="display:none;">
											<div class="add-box" id="mainBorwseDiv#rowCounter" pos="#rowCounter">
												<div class="action-part">
													<span class="action-icn"><a href="javascript:void(0)" id="remove_field" onclick="functionRemove(#rowCounter);" title="Remove Row"><i class="mdi mdi-close"></i></a></span>
													<span class="action-icn"><a href="javascript:void(0)" onclick="functionReset(#rowCounter);" id="reset_field" title="Reset Row"><i class="mdi mdi-refresh"></i></a></span>
												</div>
												<!-- <div class="row">
													<label for="full_name" class="col-sm-3 text-right control-label col-form-label">Protocol Name</label>
													<div class="col-sm-9">											
															<span class="cross-icn"><i class="mdi mdi-close"></i></span>
															<input type="text" class="form-control" id="protocal_name#rowCounter" name="protocal_name[]" placeholder="Protocol Name.." required>
													</div>
												</div> -->

												<div class="row">
													<label for="full_name" class="col-sm-3 text-right control-label col-form-label">Chart Image</label>
													<div class="col-sm-9">
														<input type="file" class="form-control" id="protocal_img#rowCounter" name="protocal_img[]" required>
													</div>
												</div>
										    </div>	
									    </div>							
								</div>
								<div class="border-top">
									<div class="card-body">
										<button type="submit" id="user_btn_submit" class="btn btn-primary user_btn_submit">Submit</button>
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
	<script src="<?php echo base_url() . 'common/dist/js/app/chart.js?v=' . random_strings(6); ?>"></script>

</body>

</html>