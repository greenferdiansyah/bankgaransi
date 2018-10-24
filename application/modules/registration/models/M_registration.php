<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_registration extends CI_Model {

	public function verify_regiter($data){

        $query      = $this->db->query("SELECT id FROM m_login WHERE email = ?", array($data['email']));
        $registerd  = $query->result_array();
        $response   = FALSE;

        if(!isset($registerd[0]['id'])){

            $login      = array(
                                "email"         => $data["email"],
                                "password"      => password_hash($data["password"], PASSWORD_BCRYPT, ['cost' => 10]),
                                "user_type"     => "applicant",
                                "is_locked"     => 1,
                                "updated_at"    => date("Y-m-d",time())
                                );

            $pelamar    = array(
                                "email"             => $data["email"],
                                "no_ktp"            => $data["no_ktp"],
                                "fullname"          => $data["fullname"],
                                "is_email_verified" => 0,
                                "created_at"        => date("Y-m-d",time()),
                                "updated_at"        => date("Y-m-d",time())
                                );

            $response = $this->submit_register($pelamar, $login);
        }   
        return $response;
    }

    public function submit_register($pelamar, $login){

		$this->db->trans_start();
		$this->db->insert('m_login',$login); 
		$data_login["company_id"] = $this->db->insert_id();
		$this->db->insert('m_pelamar', $pelamar); 
        $this->db->trans_complete();
        $response	= $this->db->trans_status();
        
		return $response;

    }
    
    public function confirm_account($table, $email){
        
        $this->db->trans_start();
        $this->db->set('is_email_verified', '1');
        $this->db->where('email', $email);
        $this->db->update($table);
        $this->db->set('is_locked', '0');
        $this->db->where('email', $email);
        $this->db->update('m_login');
        $this->db->trans_complete();
        $response= $this->db->trans_status();
		return $response;

	}
}