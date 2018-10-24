<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master_setting extends CI_Model {
	
	public function SetSettings()
	{
		$tenant_id	=  $this->session->userdata('tenant_id');
		$data = $this->db->query("SELECT * FROM master_setting WHERE tenant_id='$tenant_id'");
		
		$setting = $data->result_array();
		
		return $setting[0];
	}
	
	public function SetMenu($level=NULL,$tenant_id=NULL)
	{
		$group_level	=  $this->session->userdata('group_level');
		
		$where_clause = "";
		if($level!=NULL){
			$where_clause .= "AND userlevel REGEXP \"$level\"";
		}
		// if($group_level!=NULL){
		// 	$where_clause .= "AND group_level REGEXP \"$group_level\"";
		// }
		if($tenant_id!=NULL){
			$where_clause .= "AND tenant_id REGEXP \"$tenant_id\"";
		}
		
		$sql = "SELECT id, menuname, parent, url, icon, is_default, tooltip, divider
				FROM m_menu
				WHERE `status`=1 
				$where_clause
				ORDER BY parent, id ASC";
		
		$query = $this->db->query($sql);
		
		$menus = $query->result_array();
		
		return $menus;
	}
	
	public function check_auth($level=NULL, $url=NULL)
	{
		
		$where_clause = "AND userlevel REGEXP \"$level\" AND url='$url'";
		
		$sql	=	"SELECT id
					FROM m_menu
					WHERE id IS NOT NULL
					$where_clause";
		
		$query	= $this->db->query($sql);
		
		$result	= $query->num_rows();
		
		return $result;
	}

}

/* End of file Master_setting.php */
/* Location: ./application/models/Master_setting.php */