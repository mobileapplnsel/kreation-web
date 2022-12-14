<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
	<?php $this->load->view('top_css'); ?>
	<!-- Custom CSS -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'common/assets/extra-libs/multicheck/multicheck.css'; ?>">
	<link href="<?php echo base_url() . 'common/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css'; ?>" rel="stylesheet">
	<title><?php echo comp_name; ?> | Chart</title>
</head>
<style type="text/css">
	#short-modal .table tr td {   
    text-align: center;
}
</style>

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
						<h4 class="page-title">Chart</h4>
						<div class="ml-auto text-right">
							<nav aria-label="breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="#">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Chart</li>
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
								<h5 class="card-title">Chart <button type="button" class="btn badge badge-pill badge-success" onclick="location.href='<?php echo base_admin_url() . 'add-chart'; ?>'">Add Chart</button></h5>
								<div class="table-responsive">
									<table id="zero_config" class="table table-striped table-bordered">
										<thead>
											<tr class="textcen">
												<th>Sl</th>
												<th>Chart Name</th>
												<th>Status</th>
												<th>Action</th>

											</tr>
										</thead>
										<tbody class="textcen">
											<?php
											if (!empty($all_chart)) {
												//print_obj($broc_list);
												$sl = 1;
												foreach ($all_chart as $key => $val) {
													if($val['status'] == '1')
													{
														$status = "Active";
													}
													else
													{
														$status = "Inactive";
													}
											?>
													<tr>
														<td><?php echo $sl; ?></td>
														<td><?php echo $val['chart']; ?></td>
														<td><?php echo $status; ?></td>
														<td>
															<!-- <button type="button" onclick="location.href='<?php echo base_admin_url() . 'edit-chart/' . encode_url($val['id']); ?>'"><i class="icofont-pencil-alt-2"></i></button> -->
															<button type="button" class="del_chart" data-userid="<?php echo encode_url($val['id']); ?>" data-fullname="<?php echo $val['chart']; ?>" ><i class="fas fa-trash-alt"></i></button>
															<!-- <button type="button" class="del_user" data-toggle="modal" data-target="#short-modal" ><i class="fa fa-eye"></i></button> -->
															<button type="button" class="del_user" data-toggle="modal" data-target="#short-modal" onclick= "openViewProtocolAttechment(<?php echo $val['id'] ; ?>)" ><i class="fa fa-eye"></i></button>
														</td>
													</tr>
												<?php
													$sl++;
												}
											} else {
												?>
												<tr>
													<td colspan="4">No data found</td>
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


	<!-- The Modal -->
			<div class="modal" id="short-modal">
			  <div class="modal-dialog modal-lg">
			    <div class="modal-content">

			      <!-- Modal Header -->
			      <div class="modal-header">
			        <h4 class="modal-title">Chart List</h4>
			        <button type="button" class="close" data-dismiss="modal">&times;</button>
			      </div>

			      <!-- Modal body -->
			      <div class="modal-body">
				       <div class="table-responsive">
							<table id="zero_config" class="table table-striped table-bordered">
								<thead>
									<tr class="textcen">
										<th>Sl</th>
										<th>Protocol Image</th>										
										<th>Download</th>
									</tr>
								</thead>
								<tbody id="prorocol_img_list_tbody">

								</tbody>
							</table>
						</div>
			      </div>
			    </div>
			  </div>
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
	<script src="<?php echo base_url() . 'common/dist/js/app/chartDelete.js?v=' . random_strings(6); ?>"></script>
	<script>
		$(document).ready(function() {
		    $('#zero_config').DataTable({
		        dom: 'Bfrtip',
		        buttons: ['excel','csv']
		    });
		});

		function openViewProtocolAttechment(chart_id)
		{
		    $.ajax({ 
		                  async: false,
		                  url: "get-general-protocol-attechment",
		                  data: {
		                  chart_id: chart_id
		                },
		                  type: "POST",
		                  dataType: 'html',
		                  success:function(data)
		                  {
		                        var obj = JSON.parse(data);
		                        var trHTML = '';
		                        var i = 0;

		                        var base_url = '<?php echo base_url();?>';
		                        //alert(base_admin_url);
		                        if(obj != undefined && obj != null && obj.length != 0)
		                        {
		                            $.each(obj, function (index) {
		                                var file_path = base_url+"uploads/chart_protocol_img/"+obj[index].protocol_img;
		                                i=i+1;
		                                trHTML += '<tr><td>' + i + '</td><td>' + obj[index].protocol_img + '</td><td><a type="button" target = "_blank" href="'+file_path+'" title="Download"><i class="fa fa-eye" aria-hidden="true"></i></a></td></tr>';
		                            });
		                            $('#prorocol_img_list_tbody').html(trHTML);
		                        }
		                  }, 
		            });
		}

		function delete_chart() 
		{
			var user_id = $(this).attr('data-userid');
	        var fullname = $(this).attr('data-fullname');


	        Swal.fire({
	            title: "Are you sure?",
	            text: fullname + " Will Be Deleted Parmanently!",
	            showCancelButton: true,
	            confirmButtonColor: "#DD6B55",
	            confirmButtonText: "Yes",
	            cancelButtonText: "No",
	        }).then((willDelete) => {
	            if (willDelete.isConfirmed == true) {
	                $.ajax({

	                    type: 'POST',

	                    url: BASE_URL + 'delete-chart',

	                    data: { cat_id: user_id },

	                    success: function (d) {

	                        if (d.deleted == 'success') {

	                            Swal.fire({
	                                icon: 'success',
	                                title: 'Chart deleted!',
	                                confirmButtonText: 'Close',
	                                confirmButtonColor: '#d33',
	                                allowOutsideClick: false,
	                            });
	                            window.location.reload();

	                        }
	                        else if (d.deleted == 'not_exists') {

	                            Swal.fire({
	                                icon: 'error',
	                                title: 'Chart not exists!',
	                                confirmButtonText: 'Close',
	                                confirmButtonColor: '#d33',
	                                allowOutsideClick: false,
	                            });

	                        } else {
	                            Swal.fire({
	                                icon: 'error',
	                                title: 'Something went wrong!',
	                                confirmButtonText: 'Close',
	                                confirmButtonColor: '#d33',
	                                allowOutsideClick: false,
	                            });
	                        }

	                    }

	                });
	            } else {
	                //Swal.fire("Okay!");
	            }
	        });
		}
	</script>


</body>

</html>