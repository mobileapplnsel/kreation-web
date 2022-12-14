<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Disease_Management extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('GoogleAuthenticator');
		date_default_timezone_set('Asia/Kolkata');
	}

	public function index()
	{
		if (!empty($this->session->userdata('userid')) && $this->session->userdata('usr_logged_in') == 1) 
		{
			$data['all_disease'] = $this->am->getAllDisease();
			$this->load->view('disease/vw_diseaselist', $data);
		} 
		else 
		{
			redirect(base_admin_url());
		}
	}

	public function onCreateDiseaseView()
	{
		if (!empty($this->session->userdata('userid')) && $this->session->userdata('usr_logged_in') == 1) 
		{
			$this->data['page_title'] 	= 'Disease';
			$this->data['all_category'] 	= $this->am->getAllCategory();

			$this->load->view('disease/vw_create_disease', $this->data, false);
		} 
		else 
		{
			redirect(base_admin_url());
		}
	}

	public function onCheckDuplicateDisease()
	{
		if (!empty($this->session->userdata('userid')) && $this->session->userdata('usr_logged_in') == 1) 
		{
			if ($this->input->is_ajax_request() && $this->input->server('REQUEST_METHOD') == 'POST') 
			{

				$disease_name = xss_clean($this->input->post('disease_name'));

				$disease_exists = $this->am->getDiseaseData(array('disease_name' => $disease_name), FALSE);
				if ($disease_exists) 
				{

					$return['user_exists'] = 1;
					$return['out_message'] = $disease_name . " already exists!!";

				} 
				else 
				{
					$return['user_exists'] = 0;
					$return['out_message'] = $disease_name . " available";
				}

				header('Content-Type: application/json');

				echo json_encode($return);
			} 
			else 
			{
				//exit('No direct script access allowed');
				redirect(base_admin_url());
			}
		} 
		else 
		{
			redirect(base_admin_url());
		}
	}

	public function onCreateDisease()
	{
		if (!empty($this->session->userdata('userid')) && $this->session->userdata('usr_logged_in') == 1) 
		{
			$this->form_validation->set_rules('category_name', 'Category Name', 'trim|required|xss_clean|htmlentities');
			$this->form_validation->set_rules('disease_name', 'Disease Name', 'trim|required|xss_clean|htmlentities');

			if ($this->form_validation->run() == FALSE) 
			{
				$this->form_validation->set_error_delimiters('', '');
				$return['errors'] = validation_errors();
				$return['disease_added'] = 'rule_error';
			} 
			else 
			{
				$category_id = xss_clean($this->input->post('category_name'));
				$disease_name = xss_clean($this->input->post('disease_name'));

				$ins_Catdata = array(
										'category_id'  		=> $category_id,
										'disease_name'  	=> $disease_name,
										'created_date'  	=> date('Y-m-d H:i:s') 
									);

				$adddisease = $this->am->addDisease($ins_Catdata);

				if ($adddisease) 
				{
					$return['user_added'] = 'success';
				}	
				else 
				{
					$return['user_added'] = 'failure';
				}

				redirect(base_admin_url('disease-management'));		
			}	
		} 
		else 
		{
			redirect(base_admin_url());
		}
	}

	public function onGetDisease()
	{
		if (!empty($this->session->userdata('userid')) && $this->session->userdata('usr_logged_in') == 1) 
		{
			$cat_id = decode_url(xss_clean($this->uri->segment(3)));

			$this->data['page_title'] = 'Edit Disease';

			$chkdata 	= array('id'  => $cat_id);

			$userdata 	= $this->am->getDiseaseData($chkdata, $many = FALSE);

			if ($userdata) 
			{
				$this->data['user_data'] = array(
													'id'  				=> $userdata->id,
													'category_id'  		=> $userdata->category_id,
													'disease_name'  	=> $userdata->disease_name,
													'status'  			=> $userdata->status,
													'created_date'  	=> $userdata->created_date
												);

				$this->data['all_category'] 	= $this->am->getAllCategory();

				$this->load->view('disease/vw_edit_disease', $this->data, false);
			} 
			else 
			{
				redirect(base_admin_url());
			}
		} 
		else 
		{
			redirect(base_admin_url());
		}
	}

	public function updateDisease()
	{
		if (!empty($this->session->userdata('userid')) && $this->session->userdata('usr_logged_in') == 1) 
		{
			$cat_id 		= trim($this->input->post('cat_id'));
			$page_title 	= trim($this->input->post('page_title'));
			$category_name 	= trim($this->input->post('category_name'));
			$disease_name 	= trim($this->input->post('disease_name'));

			$chkdata 		= array('id'  => $cat_id);
			$upd_userdata 	= array('disease_name'  => $disease_name,'category_id'  => $category_name);

			$upduser = $this->am->updateDisease($upd_userdata, $chkdata);

			if($upduser)
			{
				$this->data['update_success'] = 'Successfully Updated.';
			}
			else	
			{
				$this->data['update_failure'] = 'Not Updated!';
			}	

			redirect(base_admin_url('disease-management'));	
		} 
		else 
		{
			redirect(base_admin_url());
		}
	}

	public function deleteDisease()
	{
		if (!empty($this->session->userdata('userid')) && $this->session->userdata('usr_logged_in') == 1) 
		{
			if ($this->input->is_ajax_request() && $this->input->server('REQUEST_METHOD') == 'POST') 
			{
				$dis_id 	= decode_url(xss_clean($this->input->post('dis_id')));
				$userdata 	= $this->am->getDiseaseData(array('id'  => $dis_id), FALSE);

				if (!empty($userdata)) 
				{
					$deluser = $this->am->deleteDisease(array('id' => $dis_id));

					if ($deluser) 
					{
						$return['deleted'] = 'success';
					} 
					else 
					{
						$return['deleted'] = 'failure';
					}
				} 
				else 
				{
					$return['deleted'] = 'not_exists';
				}

				header('Content-Type: application/json');
				echo json_encode($return);
			} 
			else 
			{
				redirect(base_admin_url());
			}
		} 
		else 
		{
			redirect(base_admin_url());
		}
	}

	public function diseaseSolsList()
	{
		if (!empty($this->session->userdata('userid')) && $this->session->userdata('usr_logged_in') == 1) 
		{
			$dis_id = decode_url(xss_clean($this->uri->segment(3)));

			$chkdata 	= array('id'  => $dis_id);
			$data['disease_details'] = $this->am->getDiseaseData($chkdata, $many = FALSE);
			$data['all_disease_sols'] = $this->am->getDiseaseSolData(array('disease_id'  => $dis_id), $many = TRUE);
			/*echo "<pre>";
			print_r($data['disease_details']);die;*/
			$this->load->view('disease/vw_diseaseSolList', $data);
		} 
		else 
		{
			redirect(base_admin_url());
		}
	}

	public function addDiseaseSols()
	{
		$dis_id = decode_url(xss_clean($this->uri->segment(3)));

		$chkdata 	= array('id'  => $dis_id);
		$data['disease_details'] = $this->am->getDiseaseData($chkdata, $many = FALSE);
		$data['page_title'] 	= 'Add Disease Solution';

		$this->load->view('disease/vw_create_disease_sols', $data);
	}

	public function createDiseaseSol()
	{
		$dis_id 				= trim($this->input->post('dis_id'));
		$disease_sol_name 		= trim($this->input->post('disease_sol_name'));
		$disease_sol_protocol 	= trim($this->input->post('disease_sol_protocol'));

		$attached_file   		= $_FILES["disease_sol_protocol_img"];
		$file_name 				= $attached_file['name'];

		if($file_name !="")
        {
            $config = array();
            $config['upload_path']          = '././uploads/disease_sol_protocol_img/';
            $config['allowed_types']        = 'img|IMG|jpg|JPG|jpeg|JPEG';
            $config['file_name']            = "disease_sol_protocol_img_".date("d_m_Y_H_i_s");

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            
            $fileExt = pathinfo($file_name, PATHINFO_EXTENSION);
            $file_name = $config['file_name'].".".$fileExt;
            
            if($this->upload->do_upload('disease_sol_protocol_img'))
            {
                $ins_Catdata = array(
										'disease_id'  		=> $dis_id,
										'solutions'  		=> $disease_sol_name,
										'protocol'  		=> $disease_sol_protocol,
										'protocol_image'  	=> $file_name,
										'created_date'  	=> date('Y-m-d H:i:s') 
									);

				$adddisease = $this->am->addDiseaseSol($ins_Catdata);

				if($adddisease)
				{
					redirect(base_admin_url().'disease-sols-list/'.encode_url($dis_id));
				}	
            }
            else
            {
                $error = array('error' => $this->upload->display_errors());
                echo "<pre>";
                print_r($error);
            }
        }
        else
        {
        	$ins_Catdata = array(
									'disease_id'  		=> $dis_id,
									'solutions'  		=> $disease_sol_name,
									'protocol'  		=> $disease_sol_protocol,
									'created_date'  	=> date('Y-m-d H:i:s') 
								);

			$adddisease = $this->am->addDiseaseSol($ins_Catdata);

			if($adddisease)
			{
				redirect(base_admin_url().'disease-sols-list/'.encode_url($dis_id));
			}
        }	
	}

	public function onGetDiseaseSol()
	{
		if (!empty($this->session->userdata('userid')) && $this->session->userdata('usr_logged_in') == 1) 
		{
			$dis_sol_id = decode_url(xss_clean($this->uri->segment(3)));

			$this->data['page_title'] = 'Edit Disease Solution';

			$chkdata 	= array('id'  => $dis_sol_id);

			$userdata 	= $this->am->getDiseaseSolData($chkdata, $many = FALSE);



			if ($userdata) 
			{
				$this->data['user_data'] = array(
													'id'  				=> $userdata->id,
													'disease_id'  		=> $userdata->disease_id,
													'solutions'  		=> $userdata->solutions,
													'protocol'  		=> $userdata->protocol,
													'protocol_image'  	=> $userdata->protocol_image
												);

				$chkdata 	= array('id'  => $userdata->disease_id);
				$this->data['disease_details'] = $this->am->getDiseaseData($chkdata, $many = FALSE);
				/*echo "<pre>";
				print_r($this->data['disease_details']);die;*/
				$this->load->view('disease/vw_edit_disease_sol', $this->data, false);
			} 
			else 
			{
				redirect(base_admin_url());
			}
		} 
		else 
		{
			redirect(base_admin_url());
		}
	}

	public function updateDiseaseSol()
	{
		$dis_sol_id				= trim($this->input->post('dis_sol_id'));
		$dis_id 				= trim($this->input->post('dis_id'));
		$disease_sol_name 		= trim($this->input->post('disease_sol_name'));
		$disease_sol_protocol 	= trim($this->input->post('disease_sol_protocol'));

		$attached_file   		= $_FILES["disease_sol_protocol_img"];
		$file_name 				= $attached_file['name'];

		if($file_name !="")
        {
            $config = array();
            $config['upload_path']          = '././uploads/disease_sol_protocol_img/';
            $config['allowed_types']        = 'img|IMG|jpg|JPG|jpeg|JPEG';
            $config['file_name']            = "disease_sol_protocol_img_".date("d_m_Y_H_i_s");

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            
            $fileExt = pathinfo($file_name, PATHINFO_EXTENSION);
            $file_name = $config['file_name'].".".$fileExt;
            
            if($this->upload->do_upload('disease_sol_protocol_img'))
            {
            	$chkdata 		= array('id'  => $dis_sol_id);
				$upd_userdata 	= array(
											'solutions'  		=> $disease_sol_name,
											'protocol'  		=> $disease_sol_protocol,
											'protocol_image'  	=> $file_name
										);

				$upduser = $this->am->updateDiseaseSol($upd_userdata, $chkdata);

				if($upduser)
				{
					redirect(base_admin_url().'disease-sols-list/'.encode_url($dis_id));
				}	
            }
            else
            {
                $error = array('error' => $this->upload->display_errors());
                echo "<pre>";
                print_r($error);
            }
        }
        else
        {
        	$chkdata 		= array('id'  => $dis_sol_id);
			$upd_userdata 	= array(
										'solutions'  		=> $disease_sol_name,
										'protocol'  		=> $disease_sol_protocol
									);

			$upduser = $this->am->updateDiseaseSol($upd_userdata, $chkdata);

			if($upduser)
			{
				redirect(base_admin_url().'disease-sols-list/'.encode_url($dis_id));
			}
        }
	}

	public function deleteDiseaseSol()
	{
		if (!empty($this->session->userdata('userid')) && $this->session->userdata('usr_logged_in') == 1) 
		{
			if ($this->input->is_ajax_request() && $this->input->server('REQUEST_METHOD') == 'POST') 
			{
				$dis_sol_id 	= decode_url(xss_clean($this->input->post('dis_sol_id')));
				$userdata 	= $this->am->getDiseaseSolData(array('id'  => $dis_sol_id), FALSE);

				if (!empty($userdata)) 
				{
					$deluser = $this->am->deleteDiseaseSol(array('id' => $dis_sol_id));

					if ($deluser) 
					{
						$return['deleted'] = 'success';
					} 
					else 
					{
						$return['deleted'] = 'failure';
					}
				} 
				else 
				{
					$return['deleted'] = 'not_exists';
				}

				header('Content-Type: application/json');
				echo json_encode($return);
			} 
			else 
			{
				redirect(base_admin_url());
			}
		} 
		else 
		{
			redirect(base_admin_url());
		}
	}

	public function bulkImport()
	{
		if(isset($_POST["submit"]))
		{
	   		$filename 	=	$_FILES["bulk_upload"]["tmp_name"]; 

			if($_FILES["bulk_upload"]["size"] > 0)
			{
				$file 	= fopen($filename, "r") OR die('Can not access your file');
				$index 	= 0;
			  	while (($Data = fgetcsv($file, 10000, ",")) !== FALSE)
			   	{
			   		if($index > 0) 
            		{
				   		if(count(array_filter($Data)) == 0) 
		                {
		                    break;
		                } 
		                else 
		                {
		                	$category_name 	= xss_clean($Data[0]);
		                	$disease_name 	= ucfirst(xss_clean($Data[1]));
		                	$is_regional 	= ucfirst(xss_clean($Data[2]));

		                	if($is_regional == 'Yes')
							{
								$regional = "1";
							}
							else
							{
								$regional = "0";
							}

      						$chkdata 		= array('category_name'  => strtoupper($category_name));
							$userdata 		= $this->am->getCategoryData($chkdata, $many = FALSE);

							if(!empty($userdata))
							{
								$category_id = $userdata->id;
							}
							else
							{
								$ins_Catdata = array(
														'category_name'  	=> ucfirst($category_name),
														'is_regional'  		=> $regional,
														'created_date'  	=> date('Y-m-d H:i:s') 
													);

								$category_id = $this->am->addCategory($ins_Catdata);
							}

							$ins_Catdata = array(
													'category_id'  		=> $category_id,
													'disease_name'  	=> $disease_name,
													'created_date'  	=> date('Y-m-d H:i:s') 
												);

							$adddisease = $this->am->addDisease($ins_Catdata);
		                }
		            }    
	                $index++;	
			   	}
			   	fclose($file);

			    $this->session->set_flashdata('succ_msg', 'Your Data is successfully updated !!!!');
				redirect(base_admin_url('disease-management'));
				exit();
			}   		
	 	}
	}

	public function bulk_import_disease_solutions()
	{
		if(isset($_POST["submit"]))
		{
	   		$filename 	=	$_FILES["bulk_upload"]["tmp_name"]; 

			if($_FILES["bulk_upload"]["size"] > 0)
			{
				$file 	= fopen($filename, "r") OR die('Can not access your file');
				$index 	= 0;
			  	while (($Data = fgetcsv($file, 10000, ",")) !== FALSE)
			   	{
			   		if($index > 0) 
            		{
				   		if(count(array_filter($Data)) == 0) 
		                {
		                    break;
		                } 
		                else 
		                {
		                	$dis_id 				= $this->input->post('disease_name');
		                	$disease_sol_name 		= ucfirst(xss_clean($Data[0]));
		                	$disease_sol_protocol 	= xss_clean($Data[1]);

		                	$ins_Catdata = array(
													'disease_id'  		=> $dis_id,
													'solutions'  		=> $disease_sol_name,
													'protocol'  		=> $disease_sol_protocol,
													'created_date'  	=> date('Y-m-d H:i:s') 
												);

							$adddisease = $this->am->addDiseaseSol($ins_Catdata);
		                }
		            }    
	                $index++;	
			   	}
			   	fclose($file);

			    $this->session->set_flashdata('succ_msg', 'Your Data is successfully updated !!!!');
				redirect(base_admin_url('disease-management'));
				exit();
			}   		
	 	}
	}
}
