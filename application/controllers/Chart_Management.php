<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Chart_Management extends CI_Controller
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
			$data['all_chart'] = $this->am->getAllChart();
			$this->load->view('chart/vw_chartlist', $data);
		} 
		else 
		{
			redirect(base_admin_url());
		}
	}

	public function onCreateChartView()
	{
		if(!empty($this->session->userdata('userid')) && $this->session->userdata('usr_logged_in') == 1) 
		{
			$this->data['page_title'] = 'Chart';
			$this->load->view('chart/vw_create_chart', $this->data, false);
		}
		else 
		{
			redirect(base_admin_url());
		}
	}

	public function onCheckDuplicateChart()
	{
		if (!empty($this->session->userdata('userid')) && $this->session->userdata('usr_logged_in') == 1) 
		{
			if ($this->input->is_ajax_request() && $this->input->server('REQUEST_METHOD') == 'POST') 
			{
				$chart_name      = xss_clean($this->input->post('chart_name'));
				$category_exists = $this->am->getChartData(array('chart_name' => $chart_name), FALSE);

				if ($category_exists) 
				{

					$return['user_exists'] = 1;
					$return['out_message'] = $chart_name . " already exists!!";

				} 
				else 
				{
					$return['user_exists'] = 0;
					$return['out_message'] = $chart_name . " available";
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

	public function onCreateChart()
	{
		if (!empty($this->session->userdata('userid')) && $this->session->userdata('usr_logged_in') == 1) 
		{
			$this->form_validation->set_rules('chart_name', 'Chart Name', 'trim|required|xss_clean|htmlentities');

			if ($this->form_validation->run() == FALSE) 
			{
				$this->form_validation->set_error_delimiters('', '');
				$return['errors'] 		= validation_errors();
				$return['chart_added'] 	= 'rule_error';
			} 
			else 
			{
				$chart_name = xss_clean($this->input->post('chart_name'));

				$ins_Catdata = array(
										'chart'  		=> $chart_name,
										'created_date'  => date('Y-m-d H:i:s') 
									);

				$addChart = $this->am->addChart($ins_Catdata);

				$protocol_name_arr = $this->input->post('protocal_name[]');
			
				if ($addChart) 
				{
					//foreach ($protocol_name_arr as $key => $protocol_name) 
					foreach ($_FILES['protocal_img']['name'] as $key => $image) 
					{
						if($_FILES['protocal_img']['name'][$key] && $key > 0)
						{
							$file_name = $_FILES['protocal_img']['name'][$key];

							$_FILES['protocal_img[]']['name'] 		= $_FILES['protocal_img']['name'][$key];
							$_FILES['protocal_img[]']['type'] 		= $_FILES['protocal_img']['type'][$key];
							$_FILES['protocal_img[]']['tmp_name'] 	= $_FILES['protocal_img']['tmp_name'][$key];
							$_FILES['protocal_img[]']['error'] 		= $_FILES['protocal_img']['error'][$key];
							$_FILES['protocal_img[]']['size'] 		= $_FILES['protocal_img']['size'][$key];

							$config = array();
			                $config['upload_path']          = '././uploads/chart_protocol_img/';
			                $config['allowed_types']        = 'img|IMG|jpg|JPG|jpeg|JPEG';
	            			$config['file_name']            = "chart_protocol_img_".rand(0,99999)."_".date("d_m_Y_H_i_s");	

	            			$this->load->library('upload', $config);
				            $this->upload->initialize($config);
				            
				            $fileExt 	= pathinfo($file_name, PATHINFO_EXTENSION);
				            $file_name 	= $config['file_name'].".".$fileExt;

				            if($this->upload->do_upload('protocal_img[]'))
				            {
				            	$ins_Catdata2 	= array(
															'chart_id'  		=> $addChart,
															//'protocol_name'  	=> $protocol_name,
															'protocol_img'  	=> $file_name,
															'created_date'  	=> date('Y-m-d H:i:s') 
														);
								$addChart2 = $this->am->addChartProtocol($ins_Catdata2);	
				            }
				            else
				            {
				            	$error = array('error' => $this->upload->display_errors());
				                echo "<pre>";
				                print_r($error);
				            }	
						}
					}
					$return['user_added'] = 'success';
				}	
				else 
				{
					$return['user_added'] = 'failure';
				}
				redirect(base_admin_url('chart-management'));		
			}	
		} 
		else 
		{
			redirect(base_admin_url());
		}
	}

	public function onGetChart()
	{
		if (!empty($this->session->userdata('userid')) && $this->session->userdata('usr_logged_in') == 1) 
		{
			$chart_id = decode_url(xss_clean($this->uri->segment(3)));

			$this->data['page_title'] = 'Edit Chart';

			$chkdata 	= array('id'  => $chart_id);

			$userdata 	= $this->am->getChartData($chkdata, $many = FALSE);

			if ($userdata) {
				$this->data['user_data'] = array(
													'id'  				=> $userdata->id,
													'chart'  			=> $userdata->chart,
													'status'  			=> $userdata->status,
													'created_date'  	=> $userdata->created_date
												);
				$this->load->view('chart/vw_edit_chart', $this->data, false);
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

	public function updateChart()
	{
		if (!empty($this->session->userdata('userid')) && $this->session->userdata('usr_logged_in') == 1) 
		{
			$chart_id 		= trim($this->input->post('chart_id'));
			$page_title 	= trim($this->input->post('page_title'));
			$chart_name 	= trim($this->input->post('chart_name'));

			$chkdata 		= array('id'  		=> $chart_id);
			$upd_userdata 	= array('chart'  	=> $chart_name);

			$upduser = $this->am->updateChart($upd_userdata, $chkdata);

			if($upduser)
			{
				$this->data['update_success'] = 'Successfully Updated.';
			}
			else	
			{
				$this->data['update_failure'] = 'Not Updated!';
			}	

			$this->index();
		} 
		else 
		{
			redirect(base_admin_url());
		}
	}

	public function deleteChart()
	{
		if (!empty($this->session->userdata('userid')) && $this->session->userdata('usr_logged_in') == 1) 
		{
			if ($this->input->is_ajax_request() && $this->input->server('REQUEST_METHOD') == 'POST') 
			{
				$chart_id 	= decode_url(xss_clean($this->input->post('chart_id')));
				$userdata 	= $this->am->getChartData(array('id'  => $chart_id), FALSE);

				if (!empty($userdata)) 
				{
					$deleteChart = $this->am->deleteChart(array('id' => $chart_id));
					$deleteChartProtocol = $this->am->deleteChartProtocol(array('chart_id' => $chart_id));

					if ($deleteChart && $deleteChartProtocol) 
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

	public function get_general_protocol_attechment()
	{
		$chart_id = trim($this->input->post("chart_id"));
        
        $chkdata 	= array('chart_id'  => $chart_id);
        $res = $this->am->getChartProtocoldetails($chkdata, $many = TRUE);
        
        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($res));
	}
}
