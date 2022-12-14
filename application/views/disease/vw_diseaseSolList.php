<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
	<?php $this->load->view('top_css'); ?>
	<!-- Custom CSS -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'common/assets/extra-libs/multicheck/multicheck.css'; ?>">
	<link href="<?php echo base_url() . 'common/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css'; ?>" rel="stylesheet">
	<title><?php echo comp_name; ?> | Disease Solutions</title>
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
						<h4 class="page-title">Disease Solutions For <?php echo $disease_details->disease_name;?></h4>
						<div class="ml-auto text-right">
							<nav aria-label="breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="#">Home</a></li>
									<li class="breadcrumb-item"><a href="<?php echo base_admin_url().'disease-management';?>">Disease Management</a></li>
									<li class="breadcrumb-item active" aria-current="page">Disease Solutions</li>
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
							<div class="card-body">
								<h5 class="card-title">Disease Solutions <button type="button" class="btn badge badge-pill badge-success" onclick="location.href='<?php echo base_admin_url() . 'add-disease-sols/'.$this->uri->segment(3); ?>'">Add Disease Solutions</button></h5>
								<div class="table-responsive">
									<table id="zero_config" class="table table-striped table-bordered">
										<thead>
											<tr class="textcen">
												<th>Sl</th>
												<th>Solution Name</th>
												<th>Protocol</th>
												<th>Image</th>
												<th>Status</th>
												<th>Action</th>

											</tr>
										</thead>
										<tbody class="textcen">
											<?php
											if (!empty($all_disease_sols)) 
											{
												//print_obj($broc_list);
												$sl = 1;
												foreach ($all_disease_sols as $key => $val) 
												{
													if($val->status == '1')
													{
														$status = "Active";
													}
													else
													{
														$status = "Inactive";
													}
													$dis_id = $val->disease_id;

													$chkdata 	= array('id'  => $dis_id);
													$userdata 	= $this->am->getDiseaseData($chkdata, $many = FALSE);
											?>
													<tr>
														<td><?php echo $sl; ?></td>
														<td><?php echo $val->solutions; ?></td>
														<td><?php echo $val->protocol; ?></td>
														<td>
															<?php if($val->protocol_image != "") {?>
															<img src="<?php echo base_url().'uploads/disease_sol_protocol_img/'.$val->protocol_image; ?>"></td>
															<?php } ?>
														<td><?php echo $status; ?></td>
														<td>
															<button type="button" onclick="location.href='<?php echo base_admin_url() . 'edit-disease-sol/' . encode_url($val->id); ?>'" title="Edit"><i class="icofont-pencil-alt-2"></i></button>
															<button type="button" class="del_disease_sol" data-userid="<?php echo encode_url($val->id); ?>" data-fullname="<?php echo $val->solutions; ?>" title="Delete"><i class="fas fa-trash-alt"></i></button>
														</td>
													</tr>
												<?php
													$sl++;
												}
											} 
											else 
											{
												?>
												<tr>
													<td colspan="7">No data found</td>
												</tr>
											<?php
											}
											?>
										</tbody>
									</table>
								</div>

							</div>
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
	<script>
		$('#zero_config').DataTable();
	</script>

</body>

</html>