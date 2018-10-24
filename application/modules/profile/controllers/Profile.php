<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Controller {

	public function index(){
		if($this->session->userdata('is_logged_in') == true){
			$parent_page	=  $this->uri->segment(1);
			$page			=  $this->uri->segment(1);

			$this->load->library('page_render');

			$data=array(
				'page_content' 				=> $page,
				'base_url'					=> base_url(),
				'page_url'					=> base_url().$page,
				'tenant_id'					=> $this->session->userdata('tenant_id')
			);

			$this->parser->parse('master/content', $data);
		}else{
			redirect('login');
		}
	}

	public function logout(){
		$tenant_id_alias	= $this->session->userdata('tenant_id_alias');
		$this->session->sess_destroy();
		redirect('login/'.$tenant_id_alias);
	}	

}

/* End of file home.php */
/* Location: ./application/controllers/home.php */
