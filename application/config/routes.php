<?php

defined('BASEPATH') OR exit('No direct script access allowed');



$route['default_controller'] 					= 'Main/index';

$route['404_override'] 							= 'Auth/get404';

$route['translate_uri_dashes'] 					= FALSE;

$route['privacy'] 								= 'Auth/privacy';
$route['about'] 								= 'Auth/about';

//admin panel>>



//login

$route['admin'] 								= 'Auth/index';

$route['admin/login'] 							= 'Auth/onSetLogin';

$route['admin/chk_login'] 						= 'Auth/onCheckLogin';

$route['admin/chklogin2fa'] 					= 'Auth/onCheck2FAuth';

$route['admin/logout'] 							= 'Auth/onSetLogout';

$route['admin/dashboard'] 						= 'Auth/onGetDashboard';

$route['admin/send-password-recovery'] 			= 'Auth/onSendPasswordRecovery';

	

//user management	

$route['admin/users'] 							= 'Users/index';

$route['admin/duplicate_check_un'] 				= 'Users/onCheckDuplicateUser';

$route['admin/add-user'] 						= 'Users/onCreateUserView';

$route['admin/createuser'] 						= 'Users/onCreateUser';

$route['admin/profile'] 						= 'Users/onGetUserProfile/';

$route['admin/profile/(:any)'] 					= 'Users/onGetUserProfile/$1';

$route['admin/changeprofile'] 					= 'Users/onChangeUserProfile';

$route['admin/deluser'] 						= 'Users/onDeleteUser';

$route['admin/enable2fa'] 						= 'Users/onGetTwoFACode';

$route['admin/set2fa'] 							= 'Users/onSet2FAuth';

	

//category management	

$route['admin/category-management'] 			= 'Category_Management/index';

$route['admin/add-category'] 					= 'Category_Management/onCreateCategoryView';

$route['admin/duplicate_category_check_un'] 	= 'Category_Management/onCheckDuplicateCategory';

$route['admin/create-category'] 				= 'Category_Management/onCreateCategory';

$route['admin/edit-category'] 					= 'Category_Management/onGetCategory/';

$route['admin/edit-category/(:any)'] 			= 'Category_Management/onGetCategory/$1';

$route['admin/update-category'] 				= 'Category_Management/updateCategory';

$route['admin/delete-category'] 				= 'Category_Management/deleteCategory';

$route['admin/update-category-status-ajax'] 	= 'Category_Management/updateCategoryStatusAjax';

$route['admin/update-category-regional-ajax'] 	= 'Category_Management/updateSubCategoryRegionalAjax';



//category management	

/*$route['admin/sub-category-management'] 			= 'Sub_Category_Management/index';

$route['admin/add-sub-category'] 					= 'Sub_Category_Management/onCreateSubCategoryView';

$route['admin/duplicate_sub_category_check_un'] 	= 'Sub_Category_Management/onCheckDuplicateSubCategory';

$route['admin/create-sub-category'] 				= 'Sub_Category_Management/onCreateSubCategory';

$route['admin/edit-sub-category'] 					= 'Sub_Category_Management/onGetSubCategory/';

$route['admin/edit-sub-category/(:any)'] 			= 'Sub_Category_Management/onGetSubCategory/$1';

$route['admin/update-sub-category'] 				= 'Sub_Category_Management/updateSubCategory';

$route['admin/delete-sub-category'] 				= 'Sub_Category_Management/deleteSubCategory';

$route['admin/update-sub-category-status-ajax'] 	= 'Sub_Category_Management/updateSubCategoryStatusAjax';*/



	

//disease management	

$route['admin/disease-management'] 				= 'Disease_Management/index';

$route['admin/add-disease'] 					= 'Disease_Management/onCreateDiseaseView';

$route['admin/duplicate_disease_check_un'] 		= 'Disease_Management/onCheckDuplicateDisease';

$route['admin/create-disease'] 					= 'Disease_Management/onCreateDisease';

$route['admin/edit-disease'] 					= 'Disease_Management/onGetDisease/';

$route['admin/edit-disease/(:any)'] 			= 'Disease_Management/onGetDisease/$1';

$route['admin/update-disease'] 					= 'Disease_Management/updateDisease';

$route['admin/delete-disease'] 					= 'Disease_Management/deleteDisease';

$route['admin/disease-sols-list/(:any)'] 		= 'Disease_Management/diseaseSolsList/$1';

$route['admin/add-disease-sols/(:any)'] 		= 'Disease_Management/addDiseaseSols/$1';

$route['admin/create-disease-sol'] 				= 'Disease_Management/createDiseaseSol';

$route['admin/edit-disease-sol/(:any)'] 		= 'Disease_Management/onGetDiseaseSol/$1';

$route['admin/update-disease-sol'] 				= 'Disease_Management/updateDiseaseSol';

$route['admin/delete-disease-sol'] 				= 'Disease_Management/deleteDiseaseSol';



$route['admin/bulk-import'] 					= 'Disease_Management/bulkImport';

$route['admin/bulk-import-disease-solutions'] 	= 'Disease_Management/bulk_import_disease_solutions';



//chart management

$route['admin/chart-management'] 				= 'Chart_Management/index';

$route['admin/add-chart'] 						= 'Chart_Management/onCreateChartView';

$route['admin/duplicate_chart_check_un'] 		= 'Chart_Management/onCheckDuplicateChart';

$route['admin/create-chart'] 					= 'Chart_Management/onCreateChart';

$route['admin/edit-chart'] 						= 'Chart_Management/onGetChart/';

$route['admin/edit-chart/(:any)'] 				= 'Chart_Management/onGetChart/$1';

$route['admin/update-chart'] 					= 'Chart_Management/updateChart';

$route['admin/delete-chart'] 					= 'Chart_Management/deleteChart';



$route['admin/get-general-protocol-attechment'] = 'Chart_Management/get_general_protocol_attechment';





/* API Routes */

$route['admin/login-api'] 						= 'API/Native_API_Controller/login_api';

	

//category management	

$route['admin/category-list'] 					= 'API/Native_API_Controller/category_list_api';

$route['admin/search-category'] 				= 'API/Native_API_Controller/search_category_api';



$route['admin/regional-category-list'] 			= 'API/Native_API_Controller/regional_category_list_api';

$route['admin/search-regional-category'] 		= 'API/Native_API_Controller/search_regional_category_api';

	

	

//disease management	

$route['admin/disease-list'] 					= 'API/Native_API_Controller/disease_list_api';

$route['admin/search-disease'] 					= 'API/Native_API_Controller/search_disease_api';

$route['admin/disease-sol-list'] 				= 'API/Native_API_Controller/disease_sol_list_api';

$route['admin/search-disease-sol'] 				= 'API/Native_API_Controller/search_disease_sol_api';

	

//chart management	

$route['admin/chart-list'] 						= 'API/Native_API_Controller/chart_list_api';

$route['admin/search-chart'] 					= 'API/Native_API_Controller/search_chart_api';

$route['admin/chart-protocol-list'] 			= 'API/Native_API_Controller/chart_protocol_list_api';

$route['admin/search-chart-protocol'] 			= 'API/Native_API_Controller/search_chart_protocol_api';
$route['admin/account-delete'] 					= 'API/Native_API_Controller/account_delete';
$route['admin/forget-password'] 				= 'API/Native_API_Controller/forget_password';
$route['admin/check-duplicate-user'] 		    = 'API/Native_API_Controller/check_duplicate_user';
$route['admin/user-registration'] 		    	= 'API/Native_API_Controller/user_registration';