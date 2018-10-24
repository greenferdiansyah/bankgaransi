<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

	public function index()
	{
		if($this->session->userdata('is_logged_in')){
			$parent_page	=  $this->uri->segment(1);
			$page			=  $this->uri->segment(1);
				
				$this->load->library('page_render');
				$this->page_render->render($parent_page,$page);

		}else{
			redirect('login');
		}

	}	
	

}

/* End of file home.php */
/* Location: ./application/controllers/home.php */
