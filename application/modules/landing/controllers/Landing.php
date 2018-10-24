<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Landing extends MX_Controller {

	public function index()
	{
		if ($this->session->userdata('is_logged_in') == true) {
			redirect('main#home');
		}else{
		
			
			
			$data		 = array( 
									"base_url" 		=> base_url(), 
									
								);
			$this->parser->parse('landing', $data);
		}
		
	}

}
