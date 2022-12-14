<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
	<?php $this->load->view('top_css'); ?>
	<!-- Custom CSS -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'common/assets/extra-libs/multicheck/multicheck.css'; ?>">
	<link href="<?php echo base_url() . 'common/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css'; ?>" rel="stylesheet">
	<title><?php echo comp_name; ?> | Disease</title>
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
		<div class="page-wrapper disease-list">
			<!-- ============================================================== -->
			<div class="container-fluid">
				<?php if($this->session->flashdata('succ_msg')) { ?>
			        <div class="alert alert-success alert-dismissable" role="alert">
			            <?php echo $this->session->flashdata('succ_msg'); ?>
			        </div>
			    <?php } ?>
			    <?php if($this->session->flashdata('error_msg')) { ?>
			        <div class="alert alert-danger alert-dismissable" role="alert">
			            <?php echo $this->session->flashdata('error_msg'); ?>
			        </div>
			    <?php } ?>
				<div class="row">
					<div class="col-12">
						<div class="card">
							<div class="card-body">
								<h5 class="card-title">Bulk Import For Category & Disease </h5>
								<form class="form-horizontal" id="bulk_import" action="<?php echo base_admin_url();?>bulk-import" method='POST' enctype='multipart/form-data'>
									<div class="form-group row disease-width">
										<label for="full_name" class="col-sm-3 text-left control-label col-form-label">Bulk Upload (Only CSV)</label>
										<input type="file" name="bulk_upload" id="bulk_upload" placeholder="Choose Your File" required>
									</div>	
									<div class="form-group row disease-width">
										<a type="button" href="<?php echo base_url('common/files/category-disease_bulk-uploadd.csv');?>" class='col-sm-3 text-left control-label col-form-label'>Download the Sample File</a>
									</div>
									<div class="border-top row disease-width">
										<div class="card-body">
											<button type="submit" id="user_btn_submit" class="btn btn-primary user_btn_submit" name="submit" value="Submit">Submit</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- <div class="container-fluid">
				<div class="row">
					<div class="col-12">
						<div class="card">
							<div class="card-body">
								<h5 class="card-title">Bulk Import For Disease Solutions</h5>
								<form class="form-horizontal" id="bulk_import" action="<?php echo base_admin_url();?>bulk-import-disease-solutions" method='POST' enctype='multipart/form-data'>
									<div class="form-group row disease-width">
										<label for="full_name" class="col-sm-3 text-left control-label col-form-label">Disease</label>
										<div class="col-sm-9">
											<select class="form-control" id="disease_name" name="disease_name" required>
												<option value="">Select Disease</option>
												<?php
												if (!empty($all_disease)) 
												{
													foreach ($all_disease as $key => $val) 
													{
												?>
														<option value="<?php echo $val['id']?>"><?php echo $val['disease_name']?></option>
												<?php		
													}
												}
												else	
												{
												?>
													<option value="">No Disease Found</option>
												<?php	
												}	
												?>
											</select>
										</div>
									</div>
									<div class="form-group row disease-width">
										<label for="full_name" class="col-sm-3 text-left control-label col-form-label">Bulk Upload (Only CSV)</label>
										<input type="file" name="bulk_upload" id="bulk_upload" placeholder="Choose Your File" required>
									</div>
									<div class="form-group row">
										<a type="button" href="<?php echo base_url('common/files/bulk-upload-for-disease-solutions.csv');?>" class='col-sm-3 text-left control-label col-form-label'>Download the Sample File</a>
									</div>
									<div class="border-top">
										<div class="card-body">
											<button type="submit" id="user_btn_submit" class="btn btn-primary user_btn_submit" name="submit" value="Submit">Submit</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div> -->

			<div class="page-breadcrumb">
				<div class="row">
					<div class="col-12 d-flex no-block align-items-center">
						<h4 class="page-title">Disease</h4>
						<div class="ml-auto text-right">
							<nav aria-label="breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="#">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Disease</li>
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
								<h5 class="card-title">Disease <button type="button" class="btn badge badge-pill badge-success" onclick="location.href='<?php echo base_admin_url() . 'add-disease'; ?>'">Add Disease</button></h5>
								<div class="table-responsive">
									<table id="zero_config" class="table table-striped table-bordered">
										<thead>
											<tr class="textcen">
												<th>Sl</th>
												<th>Category Name</th>
												<th>Disease Name</th>
												<th>Is Regional ?</th>
												<th>Action</th>

											</tr>
										</thead>
										<tbody class="textcen">
											<?php
											if (!empty($all_disease)) {
												//print_obj($broc_list);
												$sl = 1;
												foreach ($all_disease as $key => $val) 
												{
													if($val['status'] == '1')
													{
														$status = "Active";
													}
													else
													{
														$status = "Inactive";
													}

													$cat_id = $val['category_id'];
													$chkdata 	= array('id'  => $cat_id);
													$userdata 	= $this->am->getCategoryData($chkdata, $many = FALSE);

													if($userdata->is_regional == '1')
													{
														$is_regional = "Yes";
													}
													else
													{
														$is_regional = "No";
													}
											?>
													<tr>
														<td><?php echo $sl; ?></td>
														<td><?php echo $userdata->category_name; ?></td>
														<td><?php echo $val['disease_name']; ?></td>
														<td><?php echo $is_regional; ?></td>
														<td>
															<button type="button" onclick="location.href='<?php echo base_admin_url() . 'edit-disease/' . encode_url($val['id']); ?>'" title="Edit"><i class="icofont-pencil-alt-2"></i></button>
															<button type="button" class="del_user" data-userid="<?php echo encode_url($val['id']); ?>" data-fullname="<?php echo $val['disease_name']; ?>" title="Delete"><i class="fas fa-trash-alt"></i></button>
															<button type="button" onclick="location.href='<?php echo base_admin_url() . 'disease-sols-list/' . encode_url($val['id']); ?>'" title="Disease Solutions"><i class="fa fa-list" aria-hidden="true"></i></button>
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
													<td colspan="5">No data found</td>
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
	<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
	<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
	<script src="<?php echo base_url() . 'common/dist/js/app/disease.js?v=' . random_strings(6); ?>"></script>
	<script>
		$(document).ready(function() {
		    $('#zero_config').DataTable({
		        dom: 'Bfrtip',
		        buttons: ['excel','csv']
		    });
		});
	</script>

</body>

</html>