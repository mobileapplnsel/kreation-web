<?php

require APPPATH . 'libraries/REST_Controller.php';     



class Native_API_Controller extends REST_Controller {    



   public function __construct() 

   {

      header('Access-Control-Allow-Origin: *');

      header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

      parent::__construct();

   }



   public function login_api_post()

   {



      $username   = xss_clean($this->input->post('username'));

      $password   = md5(xss_clean($this->input->post('password')));  



      $chkdata    = array(

                           'user_name'    => $username,

                           'pass'         => $password,

                           'user_blocked' => '0'

                        );

      $userdata = $this->am->getUserData($chkdata, $many = FALSE);



      if (!empty($userdata)) 

      {

         if($userdata->user_group == '2')

         {

            $user_group = 'ADMIN';

         }  

         else 

         {

            $user_group = 'USER';

         }   

         $setdata = array(

                           'userid'          => $userdata->user_id,

                           'usergroup'       => $user_group,

                           'username'        => $userdata->user_name,

                           'fullname'        => $userdata->full_name,

                           'usr_logged_in'   => 1

                        );



         return $this->response(array(

                                           'status'     => TRUE,

                                           'message'    => 'Success',

                                           'data'       => $setdata

                                       ), REST_Controller::HTTP_OK);





      }   

      else

      {

         return  $this->response(['status' => FALSE, 'message' => 'No user found.'], REST_Controller::HTTP_OK);

      }   

   }



   public function category_list_api_post()

   {

      $category_list = $this->am->getCategoryData(array('status' => '1','is_regional' => '0'), TRUE);



      if(!empty($category_list))

      {

         return $this->response(array(

                                           'status'     => TRUE,

                                           'message'    => 'Success',

                                           'data'       => $category_list

                                       ), REST_Controller::HTTP_OK);

      }   

      else

      {

         return  $this->response(['status' => FALSE, 'message' => 'No Category found.'], REST_Controller::HTTP_OK);

      }   

   }



   public function regional_category_list_api_post()

   {

      $category_list = $this->am->getCategoryData(array('status' => '1','is_regional' => '1'), TRUE);



      if(!empty($category_list))

      {

         return $this->response(array(

                                           'status'     => TRUE,

                                           'message'    => 'Success',

                                           'data'       => $category_list

                                       ), REST_Controller::HTTP_OK);

      }   

      else

      {

         return  $this->response(['status' => FALSE, 'message' => 'No Regional Category found.'], REST_Controller::HTTP_OK);

      }   

   }



   public function search_category_api_post()

   {

      $search_param  = xss_clean($this->input->post('category_name'));

      $category_list = $this->am->search_category(array('status' => '1','is_regional' => '0'), $search_param,TRUE);



      if(!empty($category_list))

      {

         return $this->response(array(

                                           'status'     => TRUE,

                                           'message'    => 'Success',

                                           'data'       => $category_list

                                       ), REST_Controller::HTTP_OK);

      }    

      else

      {

         return  $this->response(['status' => FALSE, 'message' => 'No Category found.'], REST_Controller::HTTP_OK);

      }   

   }



   public function search_regional_category_api_post()

   {

      $search_param  = xss_clean($this->input->post('category_name'));

      $category_list = $this->am->search_category(array('status' => '1','is_regional' => '1'), $search_param,TRUE);



      if(!empty($category_list))

      {

         return $this->response(array(

                                           'status'     => TRUE,

                                           'message'    => 'Success',

                                           'data'       => $category_list

                                       ), REST_Controller::HTTP_OK);

      }    

      else

      {

         return  $this->response(['status' => FALSE, 'message' => 'No Regional Category found.'], REST_Controller::HTTP_OK);

      }   

   } 



   public function disease_list_api_post()

   {

      $cat_id = trim($this->input->post('category_id'));

      $disease_list = $this->am->getDiseaseData(array('category_id' => $cat_id,'status' => '1'), TRUE);



      if(!empty($disease_list))

      {

         return $this->response(array(

                                           'status'     => TRUE,

                                           'message'    => 'Success',

                                           'data'       => $disease_list

                                       ), REST_Controller::HTTP_OK);

      }   

      else

      {

         return  $this->response(['status' => FALSE, 'message' => 'No Disease found.'], REST_Controller::HTTP_OK);

      }   

   }



   public function search_disease_api_post()

   {

      $disease_name  = xss_clean($this->input->post('disease_name'));

      $category_id   = xss_clean($this->input->post('category_id'));



      $disease_list = $this->am->search_disease(array('status' => '1','category_id' => $category_id), $disease_name,TRUE);



      if(!empty($disease_list))

      {

         return $this->response(array(

                                           'status'     => TRUE,

                                           'message'    => 'Success',

                                           'data'       => $disease_list

                                       ), REST_Controller::HTTP_OK);

      }   

      else

      {

         return  $this->response(['status' => FALSE, 'message' => 'No Disease found.'], REST_Controller::HTTP_OK);

      }   

   } 



   public function disease_sol_list_api_post()

   {

      $dis_id = trim($this->input->post('disease_id'));

      $disease_sol_list = $this->am->getDiseaseSolData(array('disease_id' => $dis_id,'status' => '1'), TRUE);



      if(!empty($disease_sol_list))

      {

         return $this->response(array(

                                           'status'     => TRUE,

                                           'message'    => 'Success',

                                           'data'       => $disease_sol_list

                                       ), REST_Controller::HTTP_OK);

      }   

      else

      {

         return  $this->response(['status' => FALSE, 'message' => 'The Treatment is yet to be uploaded.'], REST_Controller::HTTP_OK);

      }   

   }



   /*public function search_disease_sol_api_post()

   {

      $disease_solution_name  = xss_clean($this->input->post('disease_solution_name'));

      $disease_id             = xss_clean($this->input->post('disease_id'));



      $disease_sol_list = $this->am->search_disease_sol(array('status' => '1','disease_id' => $disease_id), $disease_solution_name,TRUE);



      if(!empty($disease_sol_list))

      {

         return $this->response(array(

                                           'status'     => TRUE,

                                           'message'    => 'Success',

                                           'data'       => $disease_sol_list,

                                           'img_url'    => base_url().'uploads/disease_sol_protocol_img/'

                                       ), REST_Controller::HTTP_OK);

      }   

      else

      {

         return  $this->response(['status' => FALSE, 'message' => 'No Disease found.'], REST_Controller::HTTP_OK);

      }   

   }*/



   public function search_disease_sol_api_post()

   {

      //$disease_solution_name  = xss_clean($this->input->post('disease_solution_name'));

      $disease_solution_id             = xss_clean($this->input->post('disease_solution_id'));



      $disease_sol_list = $this->am->search_disease_sol(array('status' => '1','id' => $disease_solution_id),FALSE);



      if(!empty($disease_sol_list))

      {

         return $this->response(array(

                                           'status'     => TRUE,

                                           'message'    => 'Success',

                                           'data'       => $disease_sol_list,

                                           'img_url'    => base_url().'uploads/disease_sol_protocol_img/'

                                       ), REST_Controller::HTTP_OK);

      }   

      else

      {

         return  $this->response(['status' => FALSE, 'message' => 'The Treatment is yet to be uploaded.'], REST_Controller::HTTP_OK);

      }   

   }



   public function chart_list_api_post()

   {

      $chart_list = $this->am->getChartData(array('status' => '1'), TRUE);

      if(!empty($chart_list))
      {
         foreach($chart_list as $key => $each_chart)
         {  
            $chart_list[$key]->chart = htmlspecialchars_decode($each_chart->chart);
         } 

         return $this->response(array(

                                           'status'     => TRUE,

                                           'message'    => 'Success',

                                           'data'       => $chart_list

                                       ), REST_Controller::HTTP_OK);

      }   

      else

      {

         return  $this->response(['status' => FALSE, 'message' => 'No Chart found.'], REST_Controller::HTTP_OK);

      }   

   }



   public function search_chart_api_post()

   {

      $search_param  = xss_clean($this->input->post('chart_name'));

      $chart_list = $this->am->search_chart(array('status' => '1'), $search_param,TRUE);



      if(!empty($chart_list))

      {

         return $this->response(array(

                                           'status'     => TRUE,

                                           'message'    => 'Success',

                                           'data'       => $chart_list

                                       ), REST_Controller::HTTP_OK);

      }    

      else

      {

         return  $this->response(['status' => FALSE, 'message' => 'No Chart found.'], REST_Controller::HTTP_OK);

      }   

   }



   public function chart_protocol_list_api_post()

   {

      $chart_id            = trim($this->input->post('chart_id'));

      $chart_protocol_list = $this->am->getChartProtocolData(array('chart_id' => $chart_id,'status' => '1'), TRUE);



      if(!empty($chart_protocol_list))

      {

         return $this->response(array(

                                           'status'     => TRUE,

                                           'message'    => 'Success',

                                           'data'       => $chart_protocol_list,

                                           'img_url'    => base_url().'uploads/chart_protocol_img/'

                                       ), REST_Controller::HTTP_OK);

      }   

      else

      {

         return  $this->response(['status' => FALSE, 'message' => 'No Chart Protocol found.'], REST_Controller::HTTP_OK);

      }   

   

   }



   public function search_chart_protocol_api_post()

   {

      $search_param           = xss_clean($this->input->post('chart_protocol_name'));

      $chart_id               = xss_clean($this->input->post('chart_id'));

      $chart_list_protocol    = $this->am->search_chart_protocol(array('status' => '1','chart_id' => $chart_id), $search_param,TRUE);



      if(!empty($chart_list_protocol))

      {

         return $this->response(array(

                                           'status'     => TRUE,

                                           'message'    => 'Success',

                                           'data'       => $chart_list_protocol,

                                           'img_url'    => base_url().'uploads/chart_protocol_img/'

                                       ), REST_Controller::HTTP_OK);

      }    

      else

      {

         return  $this->response(['status' => FALSE, 'message' => 'No Chart Protocol found.'], REST_Controller::HTTP_OK);

      }   

   }

   public function account_delete_post()
   {
         $postData = $this->input->post();

         if (isset($postData) && !empty($postData)) 
         {
             $user_id            = xss_clean(($this->input->post('user_id') != '') ? $this->input->post('user_id') : '0');
             $remarks            = xss_clean(($this->input->post('remarks') != '') ? $this->input->post('remarks') : '');
         } 
         else 
         {
             $jsonData           = file_get_contents('php://input');
             $postData           = json_decode($jsonData, true);

             $user_id            = xss_clean((isset($postData['user_id'])) ? $postData['user_id'] : '0');
             $remarks            = xss_clean((isset($postData['remarks'])) ? $postData['remarks'] : '');
         }

         if($user_id != '0' && $remarks != '' && $user_id != '')
         {
            $userDetails  =   $this->am->getUserData(array('user_id'=>$user_id));

            if (!empty($userDetails)) 
            {
              $message = '<!DOCTYPE html>';
              $message .= '<html>';
              $message .= '<body  style="font-family: "Open Sans", sans-serif;">';
              $message .= '<div style="width:100%; max-width:600px; margin: 0 auto; ">';
              $message .= '<table style="background: #fff; margin: 0 auto; font-family: "Open Sans", sans-serif; padding: 15px;">';
              $message .= '<tbody>';
              $message .= '<tr>';
              $message .= '<td colspan="2" style="text-align: left;">';
              $message .= '<img src="'.base_url('common/images/krt/logo.png').'" class="img-fluid" alt="" style="width: 20%;">';
              $message .= '</td>';
              $message .= '</tr>';
              $message .= '<tr>';
              $message .= '<td style="padding-top: 20px; vertical-align: top;">';
              $message .= '<p style="font-size: 12px; color: #272727; text-align: left; font-weight: 500; text-transform: capitalize; margin: 0px; margin-bottom: 0px;">Dear,</p>';
              $message .= '<p style="font-size: 12px; color: #272727; text-align: left; font-weight: 500; text-transform: capitalize; margin: 0px; margin-bottom: 8px;"><span>Administrator</span></p>';
              $message .= '</td>';
              $message .= '<td style="padding-top: 20px; vertical-align: top;">';
              $message .= '<p style="font-size: 12px; color: #272727; text-align: right; font-weight: 600; text-transform: capitalize; margin: 0px; margin-bottom: 2px;">Dated: '.date('d/m/Y').'</p>';
              $message .= '</td>';
              $message .= '</tr>';
              $message .= '<tr>';
              $message .= '<td colspan="2">';
              $message .= '<p style="font-size: 12px; color: #272727; text-align: left; font-weight: 500; text-transform: capitalize; margin-top: 20px;">Hope you are doing well !</p>';
              $message .= '<div style="border:solid 1px #ddd; padding: 15px; width:100%;display: inherit;background: #fffdfd;">';
              $message .= '<p style="font-size: 12px; color: #272727; text-align: left; font-weight: 500;">Name : ' . ucfirst($userDetails->full_name). '</p>';
              $message .= '<p style="font-size: 12px; color: #272727; text-align: left; font-weight: 500;">Email : ' . $userDetails->user_name . '</p>';
              $message .= '<p style="font-size: 12px; color: #272727; text-align: left; font-weight: 500;">Message : ' . ucfirst($remarks) . '</p>';
              $message .= '</div>';
              $message .= '</td>';
              $message .= '</tr>';
              $message .= '<tr>';
              $message .= '<td colspan="2" style="">';
              $message .= '<p style="font-size: 12px; color: #1a29d3; text-align: left; font-weight: 500; margin-top: 20px; margin-bottom: 8px;">Saltlake Kreation</p>';
              $message .= '<p style="font-size: 12px; color: #1a29d3; text-align: left; font-weight: 500; margin: 0; margin-bottom: 8px;">Trinity</p>';
              $message .= '<p style="font-size: 12px; color: #272727; text-align: left; font-weight: 500; margin: 0; margin-bottom: 8px;">Administrator</p>';
              $message .= '<p style="font-size: 12px; color: #1a29d3; text-align: left; font-weight: 500; margin: 0; margin-bottom: 8px;">Disclaimer:</p>';
              $message .= '<p style="font-size: 12px; color: #1a29d3; text-align: left; font-weight: 500; margin: 0; margin-bottom: 8px;">This app equips an acu therapist with complex set of useful tools to deal with acute and chronic diseases. However it is not a substitute for professional advice. Reliance of information on our is solely at your own risk.</p>';
              $message .= '<p style="font-size: 12px; color: red; text-align: left; font-weight: 500; margin: 0; margin-bottom: 8px;">This is an automatically generated email, please do not reply.</p>';
              $message .= '</td>';
              $message .= '</tr>';
              $message .= '</tbody>';
              $message .= '</table>';
              $message .= '</div>';
              $message .= '</body>';
              $message .= '</html>';
              
              $subject = 'Delete Account Request';
              $config = array(
                                  'protocol'          => 'smtp',
                                  'smtp_host'         => 'kreation.lnsel.net',
                                  'smtp_port'         => 587,
                                  'smtp_user'         => NO_REPLY_EMAIL_ID,
                                  'smtp_pass'         => NO_REPLY_PASSWORD,
                                  'mailtype'          => 'html',
                                  'smtp_timeout'      => '4',
                                  'charset'           => 'utf-8',
                                  'wordwrap'          => TRUE
                              );
              $this->email->initialize($config);

              $this->email->set_newline("\r\n");
              $this->email->set_mailtype("html");
              $this->email->from(NO_REPLY_EMAIL_ID, 'Trinity');
              $this->email->to(ADMIN_EMAIL);
              $this->email->subject($subject);
              $this->email->message($message);
              /*$this->email->send();
              echo $this->email->print_debugger();die;*/
              if($this->email->send())
              {
                  $data   =   ['successcode' => '200', 'status' => 'success', 'message' => 'Delete Account Request Successfully Submitted.'];
                  $this->response($data);
              } 
              else
              {
                  $data   =   ['successcode' => '404', 'status' => 'failed', 'message' => 'Email Not Sent'];
                  $this->response($data);
              }    
            }  
            else 
            {
              $data   =   ['successcode' => '404', 'status' => 'failed', 'message' => 'User not found'];
              $this->response($data);
            }         
         } 
         else 
         {
            $data   =   ['successcode' => '404', 'status' => 'failed', 'message' => 'Parameter Missing'];
            $this->response($data);
         }  
   }

   public function forget_password_post() {
        $this->load->library('email');
        header('Content-Type: application/json');
        
        $postData = $this->input->post();
        if (isset($postData) && !empty($postData)) {
            $email_id   = $this->input->post('email_id');
        } else {
            $jsonData = file_get_contents('php://input');
            $postData = json_decode($jsonData, true);
            $email_id   = $postData['email_id'];
        }
        if($email_id !='') {
            //$return = $this->api_model->email_id_check($email_id);
            $userDetails = $this->am->getUserData(array('user_name'=>$email_id));

            if(empty($userDetails)) {
                $data['code'] = '201';
                $data['status'] = 'failed';
                $data['message'] = 'user does not exists';
            } else {
                // Send an email with password reset link
                $new_password = rand();
                $user_id      = $userDetails->user_id;
                $dataU   =   [
                    'pass' => md5($new_password)
                ];

                $chkdata = array('user_id'  => $user_id);

                $upduser = $this->am->updateUser($dataU, $chkdata);
                
                $message = '<!DOCTYPE html>';
                $message .= '<html>';
                $message .= '<body  style="font-family: "Open Sans", sans-serif;">';
                $message .= '<div style="width:100%; max-width:600px; margin: 0 auto; ">';
                $message .= '<table style="background: #fff; margin: 0 auto; font-family: "Open Sans", sans-serif; padding: 15px;">';
                $message .= '<tbody>';
                $message .= '<tr>';
                $message .= '<td colspan="2" style="text-align: left;">';
                $message .= '<img src="'.base_url('common/images/krt/logo.png').'" class="img-fluid" alt="" style="width:20%;">';
                $message .= '</td>';
                $message .= '</tr>';
                $message .= '<tr>';
                $message .= '<td style="padding-top: 20px; vertical-align: top;">';
                $message .= '<p style="font-size: 12px; color: #272727; text-align: left; font-weight: 500; text-transform: capitalize; margin: 0px; margin-bottom: 0px;">Dear,</p>';
                $message .= '<p style="font-size: 12px; color: #272727; text-align: left; font-weight: 500; text-transform: capitalize; margin: 0px; margin-bottom: 8px;"><span>'.ucfirst($userDetails->full_name).'</span></p>';
                $message .= '</td>';
                $message .= '<td style="padding-top: 20px; vertical-align: top;">';
                $message .= '<p style="font-size: 12px; color: #272727; text-align: right; font-weight: 600; text-transform: capitalize; margin: 0px; margin-bottom: 2px;">Dated: '.date('d/m/Y').'</p>';
                $message .= '</td>';
                $message .= '</tr>';
                $message .= '<tr>';
                $message .= '<td colspan="2">';
                $message .= '<p style="font-size: 12px; color: #272727; text-align: left; font-weight: 500; text-transform: capitalize; margin-top: 20px;">Hope you are doing well !</p>';
                $message .= '<div style="border:solid 1px #ddd; padding: 15px; width:100%;display: inherit;background: #fffdfd;">';
                $message .= '<p style="font-size: 12px; color: #272727; text-align: left; font-weight: 500;">A Password Reset Request has been received for your Trinity account. Your reset password given below.</p>';
                $message .= '<br>';
                $message .= '<p style="font-size: 12px; color: #272727; text-align: left; font-weight: 500;">Username : ' . $email_id . '</p>';
                $message .= '<p style="font-size: 12px; color: #272727; text-align: left; font-weight: 500;">Password : ' . $new_password . '</p>';
                $message .= '</div>';
                $message .= '</td>';
                $message .= '</tr>';
                $message .= '<tr>';
                $message .= '<td colspan="2" style="">';
                $message .= '<p style="font-size: 12px; color: #1a29d3; text-align: left; font-weight: 500; margin-top: 20px; margin-bottom: 8px;">Soltlake Kreation</p>';
                $message .= '<p style="font-size: 12px; color: #1a29d3; text-align: left; font-weight: 500; margin: 0; margin-bottom: 8px;">Trinity</p>';
                $message .= '<p style="font-size: 12px; color: #272727; text-align: left; font-weight: 500; margin: 0; margin-bottom: 8px;">Administrator</p>';
                $message .= '<p style="font-size: 12px; color: #1a29d3; text-align: left; font-weight: 500; margin: 0; margin-bottom: 8px;">Disclaimer:</p>';
                $message .= '<p style="font-size: 12px; color: #1a29d3; text-align: left; font-weight: 500; margin: 0; margin-bottom: 8px;">This app equips an acu therapist with complex set of useful tools to deal with acute and chronic diseases. However it is not a substitute for professional advice. Reliance of information on our is solely at your own risk.</p>';
                $message .= '<p style="font-size: 12px; color: red; text-align: left; font-weight: 500; margin: 0; margin-bottom: 8px;">This is an automatically generated email, please do not reply.</p>';
                $message .= '</td>';
                $message .= '</tr>';
                $message .= '</tbody>';
                $message .= '</table>';
                $message .= '</div>';
                $message .= '</body>';
                $message .= '</html>';
                
                $config = array(
                                  'protocol'          => 'smtp',
                                  'smtp_host'         => 'kreation.lnsel.net',
                                  'smtp_port'         => 587,
                                  'smtp_user'         => NO_REPLY_EMAIL_ID,
                                  'smtp_pass'         => NO_REPLY_PASSWORD,
                                  'mailtype'          => 'html',
                                  'smtp_timeout'      => '4',
                                  'charset'           => 'utf-8',
                                  'wordwrap'          => TRUE
                              );

                $this->email->initialize($config);

                $this->email->set_newline("\r\n");
                $this->email->set_mailtype("html");
                $this->email->from(NO_REPLY_EMAIL_ID, 'Trinity Forget Password');
                $this->email->to($email_id);
                $this->email->subject('Your Trinity Account Reset Password');
                $this->email->message($message);
                if($this->email->send()) {
                    $data['code'] = '200';
                    $data['status'] = 'success';
                    $data['message'] = 'An email has been sent to your email address. Please check your email to get your password.';
                } else {
                    $data['code'] = '201';
                    $data['status'] = 'failed';
                    $data['message'] = 'mail cannot be sent';
                }
            }
         }
         else{
            $data['code'] = '201';
            $data['status'] = 'failed';
            $data['message'] = 'Parameter Missing';
         }
         $json = json_encode($data);
         echo $json;
    }

   public function check_duplicate_user_post()
   {
      $email = xss_clean($this->input->post('user_name'));

      if (filter_var($email, FILTER_VALIDATE_EMAIL)) 
      {
         $if_email = 1;
      } 
      else 
      {
         $if_email = 0;
         $out_message = $email . " is not a valid email address!!";
      }

      if ($if_email == '1') 
      {
         $user_exists = $this->am->getUserData(array('user_name' => $email), FALSE);

         if ($user_exists) 
         {
            if ($email == $this->session->userdata('username')) 
            {
               $return['user_exists'] = 3;
               $return['out_message'] = $email . "!! You can&apos;t use your current username!";
            } 
            else 
            {
               $return['user_exists'] = 1;
               $return['out_message'] = $email . " already exists!!";
            }
         } 
         else 
         {
            $return['user_exists'] = 0;
            $return['out_message'] = $email . " available";
         }
      } 
      else 
      {
         $return['user_exists'] = 1;
         $return['out_message'] = $out_message;
      }

      header('Content-Type: application/json');
      echo json_encode($return);
   } 

   public function user_registration_post()
   {
      $fullname      = ucwords(xss_clean($this->input->post('full_name')));
      $user_group    = '3'; //superadmin for User only
      $username      = xss_clean($this->input->post('user_name'));
      $password      = xss_clean($this->input->post('password'));
      $chkdata       = array('user_name'  => $username);

      if($fullname !='' && $username !='' && $password !='')
      {
         $userdata = $this->am->getUserData($chkdata, FALSE);

         if (!$userdata) 
         {
            $ins_userdata = array(
                                    'full_name'    => $fullname,
                                    'user_group'   => $user_group,
                                    'user_name'    => $username,
                                    'pass'         => md5($password),
                                    'dtime'        => dtime
                                 );

            $adduser = $this->am->addUser($ins_userdata);

            if($adduser) 
            {
               $return['user_added'] = 'User Created Successfully';
            } 
            else 
            {
               $return['user_added'] = 'failure';
            }
         } 
         else 
         {
            $return['user_added'] = 'User already exists';
         }
      }   
      else 
      {
         $return['user_added'] = 'Parameter Missing';
      }   
      header('Content-Type: application/json');
      echo json_encode($return);
   }
}

?>