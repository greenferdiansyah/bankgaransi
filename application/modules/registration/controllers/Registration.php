<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Registration extends CI_Controller {

	function __construct() {

		parent::__construct();

		$this->load->library(array('encryption','drop_down','recaptcha'));
        $this->load->model("M_registration");
    }

	public function index(){

		
			$parent_page	=  $this->uri->segment(1);
			$page			=  $this->uri->segment(1);

			$data			=	array(
										'page_content' 				=> $page,
										'base_url'					=> base_url(),
										'page_url'					=> base_url().$page,
										'title'						=> "Registration",
										"captcha"					=> $this->recaptcha->getWidget(),
										"script_captcha" 			=> $this->recaptcha->getScriptTag(),
								
									);

			$this->parser->parse('registration', $data);

	}


	public function submit_register(){
	
		$data 	= array(
							"fullname" 	=> $this->input->post("fullname"),
							"no_ktp"	=> $this->input->post("no_ktp"),
							"email"		=> $this->input->post("email"),
							"password"	=> $this->input->post("password")
						);

		$verify = $this->M_registration->verify_regiter($data);
		if($verify){
			$title	= "Success";
			$reason	= "Please check your email  for  verification account !"; 
		}else{
			$title 	= "Failed";
			$reason = "Email or Residence ID has already register before !";
		}

		echo json_encode(array("status" => $verify,"title"=>$title, "reason"=> $reason));
	}

	public function confirm_account(){

		$user_type	= $this->encryption->decrypt(base64_decode($this->uri->segment(3)));
		$email 		= $this->encryption->decrypt(base64_decode($this->uri->segment(4)));
		$table 		= ($user_type == "employee")?"m_employee":"m_pelamar";
		$confirm	= $this->M_registration->confirm_account("m_pelamar", $email);

		if($confirm){
			
			$parent_page	=  $this->uri->segment(1);
			$page			=  $this->uri->segment(1);

			$data			=	array(
										'page_content' 		=> $page,
										'base_url'			=> base_url(),
										'page_url'			=> base_url().$page,
										'title'				=> "Verification Account",
									);

			$this->parser->parse('registration/verification', $data);

		}else{
			redirect('login');
		}
	}



}

/* End of file home.php */
/* Location: ./application/controllers/home.php */
