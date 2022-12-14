<!DOCTYPE html>

<html dir="ltr" lang="en">



<head>

	<?php $this->load->view('top_css'); ?>

	<!-- Custom CSS -->

	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'common/assets/extra-libs/multicheck/multicheck.css'; ?>">

	<link href="<?php echo base_url() . 'common/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css'; ?>" rel="stylesheet">

	<title><?php echo comp_name; ?> | Users</title>

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

						<h4 class="page-title">Users</h4>

						<div class="ml-auto text-right">

							<nav aria-label="breadcrumb">

								<ol class="breadcrumb">

									<li class="breadcrumb-item"><a href="#">Home</a></li>

									<li class="breadcrumb-item active" aria-current="page">Users</li>

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

								<h5 class="card-title">Users <button type="button" class="btn badge badge-pill badge-success" onclick="location.href='<?php echo base_admin_url() . 'add-user'; ?>'">Add User</button></h5>

								<div class="table-responsive">

									<table id="zero_config" class="table table-striped table-bordered">

										<thead>

											<tr class="textcen">

												<th>Sl</th>

												<th>Name</th>

												<th>Username</th>

												<th>User Type</th>

												<th>Last Login</th>

												<th>Action</th>



											</tr>

										</thead>

										<tbody class="textcen">

											<?php

											if (!empty($user_data)) {

												//print_obj($broc_list);

												$sl = 1;

												foreach ($user_data as $key => $val) 

												{

													//print_obj($val);

													if($val['usergroup'] == '2')

													{

														$user_group = 'Admin';

													}

													elseif ($val['usergroup'] == '3') 

													{

														$user_group = 'User';

													}	

													$current_time = strtotime(date('Y-m-d H:i:s'));
				                                    $login_time = strtotime($val['lastlogin']);

				                                    $precision = 1;
				                                    if( !is_int( $current_time ) ) 
				                                    {
				                                		$current_time = strtotime( $current_time );
				                                	}
				                                	
				                                	if( !is_int( $login_time ) ) 
				                                	{
				                                		$login_time = strtotime( $login_time );
				                                	}
				                                	
				                                	if( $current_time > $login_time ) 
				                                	{
				                                		list( $current_time, $login_time ) = array( $login_time, $current_time );
				                                	}
				                                	
				                                	$intervals = array( 'year', 'month', 'day', 'hour', 'minute', 'second' );
					                                $diffs = array();
					                                
					                                foreach( $intervals as $interval ) 
					                                {
					                                    $ttime = strtotime( '+1 ' . $interval, $current_time );
				                                		// Set initial values
				                                		$add = 1;
				                                		$looped = 0;
				                                		// Loop until temp time is smaller than time2
				                                		while ( $login_time >= $ttime ) 
				                                		{
				                                			// Create new temp time from time1 and interval
				                                			$add++;
				                                			$ttime = strtotime( "+" . $add . " " . $interval, $current_time );
				                                			$looped++;
				                                		}
				                                
				                                		$current_time = strtotime( "+" . $looped . " " . $interval, $current_time );
				                                		$diffs[ $interval ] = $looped; 
					                                }    
					                                
					                                $count = 0;
					                                $times = array();
					                                
					                                foreach( $diffs as $interval => $value ) 
					                                {
					                                    if( $count >= $precision ) 
					                                    {
				                                			break;
				                                		}
				                                		// Add value and interval if value is bigger than 0
				                                		if( $value > 0 ) 
				                                		{
				                                			if( $value != 1 )
				                                			{
				                                				$interval .= "s";
				                                			}
				                                			// Add value and interval to times array
				                                			$times[] = $value . " " . $interval;
				                                			$count++;
				                                		}
					                                }

											?>

													<tr>

														<td><?php echo $sl; ?></td>

														<td><?php echo $val['fullname']; ?></td>

														<td><?php echo $val['username']; ?></td>

														<td><?php echo $user_group; ?></td>

														<td><?php echo ($val['lastlogin'] != '') ? $times[0].' ego' : 'Not logged in'; ?></td>

														<td>

															<button type="button" onclick="location.href='<?php echo base_admin_url() . 'profile/' . encode_url($val['userid']); ?>'"><i class="icofont-pencil-alt-2"></i></button>

															<button type="button" class="del_user" data-userid="<?php echo encode_url($val['userid']); ?>" data-fullname="<?php echo $val['fullname']; ?>"><i class="fas fa-trash-alt"></i></button>

														</td>

													</tr>

												<?php

													$sl++;

												}

											} else {

												?>

												<tr>

													<td colspan="6">No data found</td>

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

	<script src="<?php echo base_url() . 'common/dist/js/app/users.js?v=' . random_strings(6); ?>"></script>

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