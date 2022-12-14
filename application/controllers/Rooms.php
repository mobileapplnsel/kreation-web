<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rooms extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if (!empty($this->session->userdata('userid')) && $this->session->userdata('usr_logged_in') == 1) {
			$this->data['page_title'] = 'Rooms';
			$getdata = $this->am->getRoomData(array('status' => 1), TRUE);
			if (!empty($getdata)) {
				foreach ($getdata as $key => $value) {
					$this->data['list_data'][] = array(
						'dtime'  => $value->added_dtime,
						'rowid'  => encode_url($value->room_id),
						'name'  => $value->room_name,
						'bedtype'  => $value->bed_type,
						'roomcap'  => $value->max_room_capacity,
						'status'  => $value->status,
						'added_by'  => $value->added_by,
						'edited_dtime'  => ($value->edited_dtime != '') ? $value->edited_dtime : 'NA'
					);
				}

				//print_obj($this->data['list_data']);die;

			} else {
				$this->data['list_data'] = '';
			}
			$this->load->view('rooms/vw_room_list', $this->data, false);
		} else {
			redirect(base_admin_url());
		}
	}

	public function onCheckDuplicate()
	{
		if (!empty($this->session->userdata('userid')) && $this->session->userdata('usr_logged_in') == 1) {
			if ($this->input->is_ajax_request() && $this->input->server('REQUEST_METHOD') == 'POST') {

				$name = xss_clean($this->input->post('name'));

				$if_exists = $this->am->getRoomData(array('room_name' => $name), FALSE);
				if ($if_exists) {
					$return['if_exists'] = 1;
				} else {
					$return['if_exists'] = 0;
				}

				header('Content-Type: application/json');

				echo json_encode($return);
			} else {
				//exit('No direct script access allowed');
				redirect(base_admin_url());
			}
		} else {
			redirect(base_admin_url());
		}
	}

	public function onGetEdit()
	{
		if (!empty($this->session->userdata('userid')) && $this->session->userdata('usr_logged_in') == 1) {

			$this->data['page_title'] = 'Room';
			$room_id = decode_url(xss_clean($this->uri->segment(3)));
			$chkdata = array(
				'room_id'  => $room_id
			);
			$getdata = $this->am->getRoomData($chkdata, FALSE);
			if (!empty($getdata)) {
				$this->data['edit_data'] = array(
					'dtime'  => $getdata->added_dtime,
					'roomid'  => encode_url($getdata->room_id),
					'bed_type'  => $getdata->bed_type,
					'max_room_capacity'  => $getdata->max_room_capacity,
					'with_breakfast'  => $getdata->with_breakfast,
					'room_view_type'  => $getdata->room_view_type,
					'max_room_capacity'  => $getdata->max_room_capacity,
					'total_adults'  => $getdata->total_adults,
					'total_kids'  => $getdata->total_kids,
					'room_desc'  => $getdata->room_desc,
					'amenities'  => $getdata->amenities,
					'name'  => $getdata->room_name,
					'status'  => $getdata->status,
					'added_by'  => $getdata->added_by,
					'edited_dtime'  => ($getdata->edited_dtime != '') ? $getdata->edited_dtime : 'NA'
				);
				//print_obj($this->data['edit_data']);die;

				$this->load->view('rooms/vw_room_edit', $this->data, false);
			} else {
				redirect(base_admin_url());
			}
		} else {
			redirect(base_admin_url());
		}
	}

	public function onChange()
	{
		if (!empty($this->session->userdata('userid')) && $this->session->userdata('usr_logged_in') == 1) {

			$this->data['page_title'] = 'Room';
			$room_id = decode_url(xss_clean($this->input->post('rm_id')));
			$chkdata = array('room_id'  => $room_id);

			$name = xss_clean($this->input->post('name'));
			$bed_type = xss_clean($this->input->post('bed_type'));
			$max_room_capacity = xss_clean($this->input->post('max_room_capacity'));
			$with_breakfast = xss_clean($this->input->post('with_breakfast'));
			$room_view_type = xss_clean($this->input->post('room_view_type'));
			$total_adults = xss_clean($this->input->post('total_adults'));
			$total_kids = xss_clean($this->input->post('total_kids'));
			$room_desc = xss_clean($this->input->post('room_desc'));
			$amenities = xss_clean($this->input->post('amenities'));

			// print_obj($upd_userdata);die;

			$getdata = $this->am->getRoomData($chkdata, FALSE);
			if (!empty($getdata)) {
				//update

				$upd_data = array(
					'room_name'  => $name,
					'bed_type'  => $bed_type,
					'max_room_capacity'  => $max_room_capacity,
					'with_breakfast'  => $with_breakfast,
					'room_view_type'  => $room_view_type,
					'total_adults'  => $total_adults,
					'total_kids'  => $total_kids,
					'room_desc'  => $room_desc,
					'amenities'  => $amenities,
					'edited_dtime'  => dtime,
					'edited_by'  => $this->session->userdata('userid')
				);

				$upduser = $this->am->updateRoom($upd_data, $chkdata);
				if ($upduser) {
					// $this->data['update_success'] = 'Successfully updated.';

				} else {
				}

				$url = base_admin_url('edit-room/' . encode_url($room_id));

				redirect($url);
				// $this->load->view('rooms/vw_room_edit', $this->data, false);
			} else {
				redirect(base_admin_url());
			}
		} else {
			redirect(base_admin_url());
		}
	}

	public function onCreateView()
	{
		if (!empty($this->session->userdata('userid')) && $this->session->userdata('usr_logged_in') == 1) {

			$this->data['page_title'] = 'Room';

			$this->load->view('rooms/vw_room_add', $this->data, false);
		} else {
			redirect(base_admin_url());
		}
	}

	public function onCreate()
	{
		if (!empty($this->session->userdata('userid')) && $this->session->userdata('usr_logged_in') == 1) {
			if ($this->input->is_ajax_request() && $this->input->server('REQUEST_METHOD') == 'POST') {

				$this->form_validation->set_rules('name', 'Cycle Name', 'trim|required|xss_clean|htmlentities');
				$this->form_validation->set_rules('bed_type', 'Bed Type', 'trim|required|xss_clean|htmlentities');
				$this->form_validation->set_rules('max_room_capacity', 'Max Room Capacity', 'trim|required|xss_clean|htmlentities');
				$this->form_validation->set_rules('with_breakfast', 'With Breakfast', 'trim|required|xss_clean|htmlentities');
				$this->form_validation->set_rules('room_view_type', 'Room View Type', 'trim|required|xss_clean|htmlentities');
				$this->form_validation->set_rules('total_adults', 'Total Adults', 'trim|required|xss_clean|htmlentities');
				$this->form_validation->set_rules('total_kids', 'Total Kids', 'trim|required|xss_clean|htmlentities');
				$this->form_validation->set_rules('room_desc', 'Room Description', 'trim|required|xss_clean|htmlentities');
				$this->form_validation->set_rules('amenities', 'Amenities', 'trim|required|xss_clean|htmlentities');

				if ($this->form_validation->run() == FALSE) {
					$this->form_validation->set_error_delimiters('', '');
					$return['errors'] = validation_errors();
					$return['added'] = 'rule_error';
				} else {

					$name = xss_clean($this->input->post('name'));
					$bed_type = xss_clean($this->input->post('bed_type'));
					$max_room_capacity = xss_clean($this->input->post('max_room_capacity'));
					$with_breakfast = xss_clean($this->input->post('with_breakfast'));
					$room_view_type = xss_clean($this->input->post('room_view_type'));
					$total_adults = xss_clean($this->input->post('total_adults'));
					$total_kids = xss_clean($this->input->post('total_kids'));
					$room_desc = xss_clean($this->input->post('room_desc'));
					$amenities = xss_clean($this->input->post('amenities'));

					$chkdata = array('room_name'  => $name);
					$getdata = $this->am->getRoomData($chkdata, FALSE);

					if (!$getdata) {

						//add
						$ins_data = array(
							'room_name'  => $name,
							'bed_type'  => $bed_type,
							'max_room_capacity'  => $max_room_capacity,
							'with_breakfast'  => $with_breakfast,
							'room_view_type'  => $room_view_type,
							'total_adults'  => $total_adults,
							'total_kids'  => $total_kids,
							'room_desc'  => $room_desc,
							'amenities'  => $amenities,
							'added_dtime'  => dtime,
							'added_by'  => $this->session->userdata('userid')
						);
						// print_obj($ins_data);die;
						$addcust = $this->am->addRoom($ins_data);

						if ($addcust) {
							$return['added'] = 'success';
						} else {
							$return['added'] = 'failure';
						}
					} else {
						$return['added'] = 'already_exists';
					}
				}

				header('Content-Type: application/json');
				echo json_encode($return);
			} else {
				redirect(base_admin_url());
			}
		} else {
			redirect(base_admin_url());
		}
	}

	public function onDelete()
	{
		if (!empty($this->session->userdata('userid')) && $this->session->userdata('usr_logged_in') == 1 && $this->session->userdata('usergroup') == 1) {
			if ($this->input->is_ajax_request() && $this->input->server('REQUEST_METHOD') == 'POST') {

				$room_id  = decode_url(xss_clean($this->input->post('delid')));
				$getdata = $this->am->getRoomData(array('room_id'  => $room_id), FALSE);

				if (!empty($getdata)) {
					//del
					$del = $this->am->delRoom(array('room_id' => $room_id));

					if ($del) {
						$return['deleted'] = 'success';
					} else {
						$return['deleted'] = 'failure';
					}
				} else {
					$return['deleted'] = 'not_exists';
				}

				header('Content-Type: application/json');
				echo json_encode($return);
			} else {
				redirect(base_admin_url());
			}
		} else {
			redirect(base_admin_url());
		}
	}

	//upload images

	public function onGetUploadImages()
	{
		if (!empty($this->session->userdata('userid')) && $this->session->userdata('usr_logged_in') == 1) {

			$this->data['page_title'] = 'Upload Room Images';

			$room_id = decode_url(xss_clean($this->uri->segment(3)));
			$chkdata = array(
				'mt_image_uploads.room_id'  => $room_id
			);
			$getdata = $this->am->getImgUploads($chkdata, TRUE);

			if (!empty($getdata)) {
				foreach ($getdata as $key => $value) {
					$this->data['list_data'][] = array(
						'created_dtime'  => $value['created_dtime'],
						'rowid'  => encode_url($value['img_upload_id']),
						// 'roomid'  => encode_url($value['room_id']),
						'name'  => $value['room_name'],
						'file_name'  => $value['file_name'],
						'file_path'  => $value['file_path'],
						'created_by'  => $value['created_by']
					);
				}

				// print_obj($this->data['list_data']);die;
			} else {
				$this->data['list_data'] = [];
				// redirect(base_admin_url('rooms'));
			}
			$this->data['rmid'] = encode_url($room_id);
			$this->load->view('rooms/vw_room_images', $this->data, false);
		} else {
			redirect(base_admin_url('rooms'));
		}
	}


	public function onUploadFile()
	{
		if (!empty($this->session->userdata('userid')) && $this->session->userdata('usr_logged_in') == 1) {

			if ($this->input->post('submit')) {

				$room_id = decode_url(xss_clean($this->input->post('rmid')));

				//$rel_path = base_url() . 'common/uploads/images/';
				$rel_path = base_url() . 'uploads/images/';

				//$path = ABS_PATH . 'uploads/images/';
				//$path = base_url() . 'uploads/images/';
				$path = '././uploads/images/';
				//echo  $path;die;

				$config['upload_path'] = $path;
				$config['allowed_types'] = 'png|jpg|jpeg';
				$config['remove_spaces'] = TRUE;
				$config['max_size'] = 10000;
				//$config['max_width'] = 1500;
				//$config['max_height'] = 1500;

				$this->load->library('upload', $config);
				$this->upload->initialize($config);

				if (!$this->upload->do_upload('uploadFile')) {
					$this->data['file_error'] = $this->upload->display_errors();
				} else {
					$uploadedData = array('upload_data' => $this->upload->data());
					// print_obj($this->data['upload_success']);die;
				}

				if (empty($this->data['file_error'])) {
					$insData = array(
						'room_id' => $room_id,
						'file_name' => $uploadedData['upload_data']['file_name'],
						'file_type' => $uploadedData['upload_data']['file_type'],
						'file_path'  => $rel_path . $uploadedData['upload_data']['file_name'],
						'abs_file_path' => $uploadedData['upload_data']['full_path'],
						'file_org_name' => $uploadedData['upload_data']['client_name'],
						'file_size' => $uploadedData['upload_data']['file_size'],
						'file_ext' => $uploadedData['upload_data']['file_ext'],
						'created_by'  => $this->session->userdata('userid'),
						'created_dtime'  => dtime
					);

					$added = $this->am->addImageUpload($insData);

					if ($added) {
						$this->data['upload_status'] = 'success';
						$this->data['file_path'] = $rel_path . $uploadedData['upload_data']['file_name'];
					} else {
						$this->data['upload_status'] = 'failure';
					}
				} else {
					$this->data['upload_status'] = 'failure';
				}

				//list
				$chkdata = array(
					'mt_image_uploads.room_id'  => $room_id
				);
				$getdata = $this->am->getImgUploads($chkdata, TRUE);

				if (!empty($getdata)) {
					foreach ($getdata as $key => $value) {
						$this->data['list_data'][] = array(
							'created_dtime'  => $value['created_dtime'],
							'rowid'  => encode_url($value['img_upload_id']),
							// 'roomid'  => encode_url($value['room_id']),
							'name'  => $value['room_name'],
							'file_name'  => $value['file_name'],
							'file_path'  => $value['file_path'],
							'created_by'  => $value['created_by']
						);
					}

					// print_obj($this->data['list_data']);die;

				} else {
					$this->data['list_data'] = [];
				}

				$this->data['rmid'] = encode_url($room_id);
				$this->data['page_title'] = 'Upload Room Images';

				$this->load->view('rooms/vw_room_images', $this->data, false);
			} else {
				// redirect(base_admin_url());
			}
		} else {
			redirect(base_admin_url());
		}
	}

	public function onDeleteRoomImage()
	{
		if (!empty($this->session->userdata('userid')) && $this->session->userdata('usr_logged_in') == 1 && $this->session->userdata('usergroup') == 1) {
			if ($this->input->is_ajax_request() && $this->input->server('REQUEST_METHOD') == 'POST') {

				$img_upload_id  = decode_url(xss_clean($this->input->post('delid')));
				$getdata = $this->am->getImageUploads(array('img_upload_id'  => $img_upload_id), FALSE);

				if (!empty($getdata)) {
					//del
					$del = $this->am->delImageUpload(array('img_upload_id' => $img_upload_id));

					if ($del) {
						$return['deleted'] = 'success';
					} else {
						$return['deleted'] = 'failure';
					}
				} else {
					$return['deleted'] = 'not_exists';
				}

				header('Content-Type: application/json');
				echo json_encode($return);
			} else {
				redirect(base_admin_url());
			}
		} else {
			redirect(base_admin_url());
		}
	}

	//room availability
	public function onGetRoomAvailability()
	{
		if (!empty($this->session->userdata('userid')) && $this->session->userdata('usr_logged_in') == 1) {

			$this->data['page_title'] = 'Room Availability';

			$room_id = decode_url(xss_clean($this->uri->segment(3)));
			$chkdata = array(
				'tbl_availability.room_id'  => $room_id
			);
			$getdata = $this->am->getRoomAvailability($chkdata, TRUE);

			if (!empty($getdata)) {
				foreach ($getdata as $key => $value) {
					$this->data['list_data'][] = array(
						'dtime'  => $value['dtime'],
						'rowid'  => encode_url($value['avl_id']),
						// 'roomid'  => encode_url($value['room_id']),
						'name'  => $value['room_name'],
						'from_date'  => $value['from_date'],
						'to_date'  => $value['to_date'],
						'actual_rate'  => $value['actual_rate'],
						'discount_percentage'  => $value['discount_percentage'],
						'discounted_rate'  => $value['discounted_rate'],
						'added_by'  => $value['added_by']
					);
				}

				// print_obj($this->data['list_data']);die;

			} else {
				$this->data['list_data'] = [];
				// redirect(base_admin_url('rooms'));
			}
			$this->data['rmid'] = encode_url($room_id);
			$this->load->view('rooms/vw_room_availability', $this->data, false);
		} else {
			redirect(base_admin_url('rooms'));
		}
	}


	public function onAddRoomAvailability()
	{
		if (!empty($this->session->userdata('userid')) && $this->session->userdata('usr_logged_in') == 1) {

			if ($this->input->post('submit')) {

				$room_id = decode_url(xss_clean($this->input->post('rmid')));
				$date_from = xss_clean($this->input->post('date_from'));
				$date_to = xss_clean($this->input->post('date_to'));
				$actual_rate = xss_clean($this->input->post('actual_rate'));
				$discount_percentage = xss_clean($this->input->post('discount_percentage'));

				if ($room_id != '' && $date_from != '' && $date_from != '' && $actual_rate != '' && $discount_percentage != '') {
					$date_from = date_create($date_from);
					$date_from = date_format($date_from, "Y-m-d");

					$date_to = date_create($date_to);
					$date_to = date_format($date_to, "Y-m-d");

					$discounted_rate = ($actual_rate * $discount_percentage) / 100;
					$final_rate = ($actual_rate - $discounted_rate);

					$insData = array(
						'room_id' => $room_id,
						'from_date' => $date_from,
						'to_date' => $date_to,
						'actual_rate' => $actual_rate,
						'discount_percentage' => $discount_percentage,
						'discounted_rate' => $final_rate,
						'added_by'  => $this->session->userdata('userid'),
						'dtime'  => dtime
					);

					$added = $this->am->addAvailability($insData);

					if ($added) {
						$this->data['status'] = 'success';
						$this->data['msg'] = 'Successfully added!';
					} else {
						$this->data['status'] = 'failure';
						$this->data['msg'] = 'Something went wrong!';
					}
				} else {
					$this->data['status'] = 'failure';
					$this->data['msg'] = 'All the fields are mandatory!';
				}

				//list
				$chkdata = array(
					'tbl_availability.room_id'  => $room_id
				);
				$getdata = $this->am->getRoomAvailability($chkdata, TRUE);

				if (!empty($getdata)) {
					foreach ($getdata as $key => $value) {
						$this->data['list_data'][] = array(
							'dtime'  => $value['dtime'],
							'rowid'  => encode_url($value['avl_id']),
							// 'roomid'  => encode_url($value['room_id']),
							'name'  => $value['room_name'],
							'from_date'  => $value['from_date'],
							'to_date'  => $value['to_date'],
							'actual_rate'  => $value['actual_rate'],
							'discount_percentage'  => $value['discount_percentage'],
							'discounted_rate'  => $value['discounted_rate'],
							'added_by'  => $value['added_by']
						);
					}

					// print_obj($this->data['list_data']);die;

				} else {
					$this->data['list_data'] = [];
				}

				$this->data['rmid'] = encode_url($room_id);
				$this->data['page_title'] = 'Room Availability';

				$this->load->view('rooms/vw_room_availability', $this->data, false);
			} else {
				// redirect(base_admin_url());
			}
		} else {
			redirect(base_admin_url());
		}
	}

	public function onDeleteRoomAvailability()
	{
		if (!empty($this->session->userdata('userid')) && $this->session->userdata('usr_logged_in') == 1 && $this->session->userdata('usergroup') == 1) {
			if ($this->input->is_ajax_request() && $this->input->server('REQUEST_METHOD') == 'POST') {

				$avl_id  = decode_url(xss_clean($this->input->post('delid')));
				$getdata = $this->am->getAvailability(array('avl_id'  => $avl_id), FALSE);

				if (!empty($getdata)) {
					//del
					$del = $this->am->delAvailability(array('avl_id' => $avl_id));

					if ($del) {
						$return['deleted'] = 'success';
					} else {
						$return['deleted'] = 'failure';
					}
				} else {
					$return['deleted'] = 'not_exists';
				}

				header('Content-Type: application/json');
				echo json_encode($return);
			} else {
				redirect(base_admin_url());
			}
		} else {
			redirect(base_admin_url());
		}
	}


	//room bookings
	public function onGetBookingDetails()
	{
		if (!empty($this->session->userdata('userid')) && $this->session->userdata('usr_logged_in') == 1) {

			$this->data['page_title'] = 'Room Bookings';

			$room_id = decode_url(xss_clean($this->uri->segment(3)));
			$chkdata = array(
				'tbl_room_bookings.room_id'  => $room_id
			);
			$getdata = $this->am->getRoomBookings($chkdata, TRUE);

			if (!empty($getdata)) {
				foreach ($getdata as $key => $value) {
					$this->data['list_data'][] = array(
						'dtime'  => $value['dtime'],
						'rowid'  => encode_url($value['booking_id']),
						// 'roomid'  => encode_url($value['room_id']),
						'name'  => $value['room_name'],
						'booking_date'  => $value['booking_date'],
						'amount'  => $value['amount'],
						'payment_id'  => $value['payment_id'],
						'payment_status'  => $value['payment_status'],
						'added_by'  => $value['added_by']
					);
				}

				// print_obj($this->data['list_data']);die;

			} else {
				$this->data['list_data'] = [];
				// redirect(base_admin_url('rooms'));
			}
			$this->data['rmid'] = encode_url($room_id);
			$this->load->view('rooms/vw_room_bookings', $this->data, false);
		} else {
			redirect(base_admin_url('rooms'));
		}
	}
}
