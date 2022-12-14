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
                                    <li class="breadcrumb-item"><a href="<?php echo base_admin_url();?>">Home</a></li>
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
                            <form class="form-horizontal" method="post" action="<?php echo base_admin_url() . 'update-disease'; ?>">
                                <div class="card-body">
                                    <h4 class="card-title">Edit Disease</h4>
                                    <div class="form-group row">
                                        <label for="full_name" class="col-sm-3 text-right control-label col-form-label">Category</label>
                                        <div class="col-sm-9">
                                            <input type="hidden" name="cat_id" value="<?php echo $user_data['id'];?>">
                                            <select class="form-control" id="category_name" name="category_name">
                                                <option value="">Select Category</option>
                                                <?php
                                                if (!empty($all_category)) 
                                                {
                                                    foreach ($all_category as $key => $val) 
                                                    {
                                                ?>
                                                        <option value="<?php echo $val['id']?>" <?php if($user_data['category_id'] == $val['id']){ echo 'selected'; }?>><?php echo $val['category_name']?></option>
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
                                            <input type="text" class="form-control" id="disease_name" name="disease_name" placeholder="Disease Name.." value="<?php echo $user_data['disease_name'];?>">
                                            <label id="chk_disease_name" style="display: none;"></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="border-top">
                                    <div class="card-body">
                                        <button type="submit" id="submit" class="btn btn-primary user_btn_submit">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php $this->load->view('footer'); ?>
        </div>
    </div>
    <?php $this->load->view('bottom_js'); ?>
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