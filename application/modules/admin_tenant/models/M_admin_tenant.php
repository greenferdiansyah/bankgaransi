<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_admin_tenant extends CI_Model {

	public function list_data($length,$start,$search,$order,$dir){

		$order_by="ORDER BY id";
		if($order!=0){
			$order_by="ORDER BY $order $dir";
		}
		
		$where_clause="";
		 if($search!=""){
			$where_clause=" AND (	a.id like '%$search%' OR 
									b.company_name like '%$search%' OR  
									b.city like '%$search%' OR 
									b.zip_code like '%$search%' OR 
									b.email_support like '%$search%' 
								)";
		}

		$sql		= " SELECT 	a.id,
								a.company_id,
								a.created_at,
								a.updated,
								a.updated_at,
								a.status, 
								b.company_name, 
								b.city,
								b.site_url,
								b.zip_code,
								b.email_support,
								b.phone_support
						FROM m_tenant  a
						JOIN m_company b ON (a.company_id = b.id)
						WHERE a.id != 0
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
		
		$sql 	= "SELECT 	a.id, 
							a.company_id,
							a.tenant_alias,
							a.status,
							a.created_at,
							a.updated,
							a.updated_at,
							b.company_name,
							b.company_nickname,
							b.company_description,
							b.logo,
							b.city,
							b.address,
							b.site_url,
							b.zip_code,
							b.email_support,
							b.phone_support
					FROM m_tenant a
					JOIN m_company b ON (a.company_id = b.id)
					WHERE a.id 	= ?";
		$query	= $this->db->query($sql, array($id));
		$data 	= $query->row();

		return $data;

	}

	public function submit($action, $data_company, $data_tenant){

		$this->db->trans_start();
			if($action == "Add"){

				$data_company["created"]	= "system";
				$data_company["created_at"] = date("Y-m-d",time());
				$data_tenant["created"]		= "system";
				$data_tenant["created_at"] 	= date("Y-m-d",time());
				
				$this->db->insert('m_company',$data_company); 
				$data_tenant["company_id"] = $this->db->insert_id();
				$this->db->insert('m_tenant', $data_tenant); 
		
			}else{

			
				$this->db->where('id', $data_tenant["company_id"]);
				$this->db->update('m_company', $data_company); 
				$this->db->where('id', $data_tenant["id"]);
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
		$this->db->query("DELETE m_tenant, m_company FROM m_tenant INNER JOIN m_company ON m_tenant.company_id = m_company.id WHERE m_tenant.id = ?", array($tenant_id));
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