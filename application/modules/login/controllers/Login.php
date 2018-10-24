<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct()
    {
        parent::__construct();
		$this->load->library('Recaptcha');
		$this->load->model('q_login');
    }

	public function index(){

			$data = array( 
							"base_url" 			=> base_url(), 
							"title"				=> "Login Application",
							"captcha"			=> $this->recaptcha->getWidget(),
							"script_captcha" 	=> $this->recaptcha->getScriptTag(),
						);
			$this->parser->parse('login', $data);

	}

	public function check_login(){
		$email 				= $this->input->post('username');
		$password			= $this->input->post('password');
		$response  			= $this->recaptcha->verifyResponse($this->input->post('g-recaptcha-response'));
		
		// if (!isset($response['success']) || $response['success'] != true) {
		// 	$result = array("status"=>"fail","title"=>"Login Fail","reason"=>"Captcha required !");    
        // } else {  

			
			$check_login 	= $this->q_login->check_login($email,$password);
			
			if(is_array($check_login)){				

					if($check_login['status']==TRUE){
							$sess	= array(
										'user_id'				=> $check_login['user_id'],
										'fullname'				=> $check_login['fullname'],
										'userlevel' 			=> $check_login['userlevel'],
										// 'usertype' 				=> $check_login['usertype'],
										'email' 				=> $check_login['email'],
										'phone' 				=> $check_login['phone'],
										'foto'					=> $check_login['foto'],
										'tenant_id'				=> $check_login['tenant_id'],
										'is_logged_in'			=> true
										);

							$this->session->set_userdata($sess);
							$route = base_url()."main#".$check_login['route'];
							
							$result = array("status"=>"success","title"=>"Login Success","reason"=>"Please Wait...","route"=>$route);
					}else{

						$result = array("status"=>"fail","title"=>"Login Fail","reason"=>"Username or Password wrong, please try again...");		
					
					}	

			// }else{
				
			// 	$result = array("status"=>"error","title"=>"Login Fail","reason"=>"error");
			
			// }
		}

		echo json_encode($result);
	}

}

/* End of file login.php */
/* Location: ./application/controllers/login.php */
