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
                        <h4 class="page-title"><?php echo $page_title; ?></h4>
                        <div class="ml-auto text-right">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page"><?php echo $page_title; ?></li>
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
                                <div style="border: 2px solid gray; border-radius: 8px; width: auto;">
                                    <h5 class="card-title">Add <?php echo $page_title; ?>:</h5>
                                    <?php
                                    //  if (!isset($status)) {
                                    ?>
                                    <form action="<?php echo base_admin_url(); ?>add-availability" method="post" enctype="multipart/form-data">

                                        <div class="form-group row">
                                            <label for="date_from" class="col-sm-2 text-left control-label col-form-label"> Date From:</label>
                                            <div class="col-sm-3">
                                                <input type="hidden" name="rmid" value="<?php echo (isset($rmid)) ? $rmid : 0; ?>" />
                                                <input type="text" class="form-control date_from" id="date_from" name="date_from" placeholder="mm/dd/yyyy" autocomplete="off">
                                            </div>
                                            <label for="date_to" class="col-sm-2 text-left control-label col-form-label"> Date To:</label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control date_to" id="date_to" name="date_to" placeholder="mm/dd/yyyy" autocomplete="off">
                                            </div>
                                            <div class="col-sm-2">

                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="actual_rate" class="col-sm-2 text-left control-label col-form-label"> Actual Price:</label>
                                            <div class="col-sm-3">
                                                <input type="number" class="form-control" id="actual_rate" name="actual_rate" placeholder="Actual Price" autocomplete="off">
                                            </div>
                                            <label for="discount_percentage" class="col-sm-2 text-left control-label col-form-label"> Discount %:</label>
                                            <div class="col-sm-3">
                                                <input type="number" class="form-control" id="discount_percentage" name="discount_percentage" placeholder="Discounted %" autocomplete="off">
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="submit" name="submit" class="btn btn-success" value="Upload" />
                                            </div>
                                        </div>

                                    </form>
                                    <?php
                                    // }
                                    ?>

                                    <?php if (isset($status) && $status == 'success') {
                                        echo '<br><i class="icofont-tick-mark" style="color:green;"></i> ' . $msg;
                                    } else if (isset($status) && $status == 'failure') {
                                        echo '<br><i class="icofont-close-circled" style="color:red;"></i> ' . $msg;
                                    } ?>

                                </div>
                                <div class="table-responsive">     
                                    <table id="<?php (!empty($list_data))?'zero_config':'';?>" class="table table-striped table-bordered">
                                        <thead>
                                            <tr class="textcen">
                                                <th>Sl</th>
                                                <th>CreatedOn</th>
                                                <th>RoomName</th>
                                                <th>FromDate</th>
                                                <th>ToDate</th>
                                                <th>ActualRate</th>
                                                <th>DiscountedRate</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="textcen">
                                            <?php
                                            if (!empty($list_data)) {
                                                // print_obj($list_data);
                                                $sl = 1;
                                                foreach ($list_data as $key => $val) {
                                            ?>
                                                    <tr>
                                                        <td><?php echo $sl; ?></td>
                                                        <td><?php echo $val['dtime']; ?></td>
                                                        <td><?php echo $val['name']; ?></td>
                                                        <td><?php echo $val['from_date']; ?></td>
                                                        <td><?php echo $val['to_date']; ?></td>
                                                        <td><?php echo $val['actual_rate']; ?></td>
                                                        <td><?php echo $val['discounted_rate']; ?></td>
                                                        <td>
                                                            <?php if (!empty($this->session->userdata('userid')) && $this->session->userdata('usr_logged_in') == 1 && $this->session->userdata('usergroup') == 1) {  ?>
                                                                <button type="button" class="del_avl" data-delid="<?php echo $val['rowid']; ?>" data-rowname="<?php echo $val['name']; ?>"><i class="fas fa-trash-alt"></i></button>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                <?php
                                                    $sl++;
                                                }
                                            } else {
                                                ?>
                                                <tr>
                                                    <td colspan="8">No data found</td>
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
    <script src="<?php echo base_url() . 'common/dist/js/app/rooms.js?v=' . random_strings(6); ?>"></script>
    <script>
        $(document).ready(function() {
            $('#zero_config').DataTable();

            jQuery('#date_from').datepicker({
                autoclose: true,
                todayHighlight: true,
                // endDate: "today",
                orientation: "bottom"
            });

            jQuery('#date_to').datepicker({
                autoclose: true,
                todayHighlight: true,
                // endDate: "today",
                orientation: "bottom"
            });
        });
    </script>

</body>

</html>