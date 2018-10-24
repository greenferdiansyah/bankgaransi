<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_admin_tenant extends CI_Model {

	public function list_data($length,$start,$search,$order,$dir){

		$order_by="ORDER BY id_tenant";
		if($order!=0){
			$order_by="ORDER BY $order $dir";
		}
		
		$where_clause="";
		 if($search!=""){
			$where_clause=" AND (	id_tenant like '%$search%' OR 
									tenant_name like '%$search%' OR 
									address like '%$search%' OR 
									company_name like '%$search%' 
								)";
		}

		$sql		= " SELECT 	*
						FROM m_tenant 
						WHERE id_tenant != 0
						$where_clause
						$order_by";
						
		$query		= $this->db->query($sql . " LIMIT $start, $length");

		$numrows	= $this->db->query($sql);
		$total		= $numrows->num_rows();
		
		return array("data"=>$query->result_array(),
					"total_data"=>$total
				);
	}


	public function detail_data($id){
		
		$sql 	= "SELECT *
					FROM m_tenant 
					WHERE a.id 	= ?";
		$query	= $this->db->query($sql, array($id));
		$data 	= $query->row();

		return $data;

	}

	public function submit($action,$data_tenant){

		$this->db->trans_start();
			if($action == "Add"){

				//$data_company["created"]	=  $this->session->userdata('user_id');
				//$data_company["created_at"] = date("Y-m-d",time());
				$data_tenant["created"]		=  $this->session->userdata('user_id');
				$data_tenant["created_at"] 	= date("Y-m-d",time());
				$data_tenant["updated"]		= $this->session->userdata('user_id');
				$data_tenant["updated_at"] 	= date("Y-m-d",time());
				
				//$this->db->insert('m_company',$data_company); 
				//$data_tenant["company_id"] = $this->db->insert_id();
				$this->db->insert('m_tenant', $data_tenant); 
		
			}else{

			
				//$this->db->where('id_tenant', $data_tenant["id_tenat"]);
				//$this->db->update('m_company', $data_company); 
				$this->db->where('id_tenant', $data_tenant["id_tenant"]);
				$this->db->update('m_tenant', $data_tenant); 

			}
		
		$this->db->trans_complete();
		$response	= $this->db->trans_status();

		if($response){
			$title 	= 	"success";
			$reason	= 	($action=="Add")?'Inserted':'Updated';
		}else{
			$title 	= 	"failed";
			$reason	= 	($action=="Add")?'Fail Insert':'Fail Update';
		}
		return array("status"=>$response,"title"=>$title,"reason"=>$reason);

	}

	public function delete($tenant_id){

		$this->db->trans_start();
		$this->db->query("DELETE FROM m_tenant WHERE id_tenant = ?", array($tenant_id));
		$this->db->trans_complete();
		
		$response	= $this->db->trans_status();

		if($response){
			$title 	= 	"success";
			$reason	= 	"Deleted";
		}else{
			$title 	= 	"failed";
			$reason	= 	"Error while deleted data";
		}
		return array("status"=>$response,"title"=>$title,"reason"=>$reason);
	}
	
}