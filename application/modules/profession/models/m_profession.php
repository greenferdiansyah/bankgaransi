<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_profession extends CI_Model {

	public function list_data($length,$start,$search,$order,$dir){

		$order_by="ORDER BY id_profession";
		if($order!=0){
			$order_by="ORDER BY $order $dir";
		}
		
		$where_clause="";
		 if($search!=""){
			$where_clause=" AND (	id_profession like '%$search%' OR 
									nm_profession like '%$search%' OR  
									code_profession like '%$search%' 
									
								)";
		}

		$sql		= " SELECT *
						FROM t_profession
						WHERE 1=1
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
					FROM t_profession
					WHERE 1=1 ";
		$query	= $this->db->query($sql, array($id));
		$data 	= $query->row();

		return $data;

	}

	public function submit($action, $data){

		$this->db->trans_start();
			if($action == "Add"){

				$data["created"]	= $this->session->userdata('user_id');
				$data["created_at"] = date("Y-m-d h:m:s",time());
				$data["updated"] 	= $this->session->userdata("user_id");
				
				$this->db->insert('t_profession',$data); 
		
			}else{

			
				$this->db->where('id_profession', $data["id_profession"]);
				$this->db->update('t_profession', $data); 
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

	public function delete($id_profession){

		$this->db->trans_start();
		$this->db->query("DELETE FROM t_profession WHERE id_profession = ?", array($id_profession));
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