<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_profile extends CI_Model {

	public function get_profile_info($user_id , $tenant_id){
		$this->db->select("*");
		$this->db->from("m_user");
		$this->db->where("user_id" , $user_id);
		$this->db->where("tenant_id" , $tenant_id);
	}
	
}

/* End of file M_home.php */
/* Location: ./application/models/M_home.php */
