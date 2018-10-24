<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Q_login extends CI_Model {

	
	public function check_login($email,$password){
		
		$sql 	= "	SELECT 	a.id,
							a.email,
							a.password,
							a.fullname,
							a.userlevel,
							a.tenant_id,
							a.phone,
							a.img_profile,
							a.last_login,
							b.route
					FROM m_user a 
					JOIN m_route b ON (a.userlevel = b.userlevel) 
					WHERE a.email = ? AND a.is_locked = ?";
		$query 	= $this->db->query($sql, array($email,0));
		$login 	= $query->result_array();

		if(isset($login[0]['id']) && password_verify($password, $login[0]['password'])){
		
			//$table 	= ($login[0]['user_type'] == 'employee') ? "m_employee" : "m_pelamar";
			//$user 	= $this->get_data_login($login[0]['email'], $table);
		

			$result = array(
								"status"		=> true,
								"user_id"		=> $login[0]['id'],
								"fullname"		=> $login[0]['fullname'],
								"userlevel"		=> $login[0]['userlevel'],
							//	"usertype"		=> $login[0]['user_type'],
								"email"			=> $login[0]['email'],
								"phone"			=> $login[0]['phone'],
								"foto"			=> $login[0]['img_profile'],
								"tenant_id"		=> $login[0]['tenant_id'],
								"route"			=> $login[0]['route']
							);

		}else{
			
			$result = array(
								"status"		=> false,
								"user_id"		=> '',
								"fullname"		=> '',
								"userlevel"		=> '',
								"usertype"		=> '',
								"email"			=> '',
								"phone"			=> '',
								"foto"			=> '',
								"tenant_id"		=> '',
								"route"			=> ''
							);
			
		}	
		
		return $result;
	}

	// public function get_data_login($email, $table){
		
	// 	$sql = "SELECT 	a.id, 
	// 					a.fullname, 
	// 					a.userlevel, 
	// 					a.tenant_id, 
	// 					a.email, 
	// 					a.phone, 
	// 					a.img_profile,  
	// 					b.route
	// 			FROM $table a
	// 			JOIN m_route b ON (a.userlevel = b.userlevel)
	// 			WHERE  a.email = ? AND a.status = ? AND a.is_deleted = ?";
	// 	$query = $this->db->query($sql, array($email, '1', '0'));
	// 	// echo $this->db->last_query();
	// 	// exit();
	// 	// die();

	// 	$data = $query->result_array();
		
	// 	return $data;
	// }
	
	public function check_tenant($page){
		
		$this->db->select('tenant_id, favicon, logo, title ');
		$query = $this->db->get_where('master_setting', array('tenant_id_alias'=> $page));

		$data = $query->result_array();

		if(isset($data[0]['tenant_id'])){
				$result = array("status" => true, "tenant_id" => $data[0]['tenant_id'], "favicon" => $data[0]['favicon'] , "logo" => $data[0]['logo'], "title" => $data[0]['title']);
		}else{
				$result = array("status" => false );
		}

		return $result;
	}

	public function find_page($ticket_status){

		$sql ="	SELECT flow_page
				FROM m_page_config 
				WHERE JSON_SEARCH(JSON_EXTRACT(flow_group,'$.order_status'), 'one', '$ticket_status') IS NOT NULL
				LIMIT 1";
		$query = $this->db->query($sql);
		
		$result = $query->result_array();

		return $result[0]['flow_page'];

	}


}

/* End of file q_login.php */
/* Location: ./application/models/q_login.php */
