<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_participant extends CI_Model {

	public function list_data($length,$start,$search,$order,$dir){

		$order_by="ORDER BY a.id_participant";
		if($order!=0){
			$order_by="ORDER BY $order $dir";
		}
		
		$where_clause="";
		 if($search!=""){
			$where_clause=" AND (	a.id_participant like '%$search%' OR
                                    a.nm_participant like '%$search%' OR
									a.no_participant like '%$search%' OR  
									a.address_participant like '%$search%' OR
                                    a.bank_acc like '%$search%' OR
                                    a.date_participant_doc '%$search%' OR
                                    b.profession_id like '%$search%'
									
								)";
		}

		$sql		= " SELECT a.*,b.nm_profession
						FROM t_participant as a
                        inner join t_profession as b
                        on a.profession_id = b.id_profession 
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
        
		$sql 	= " SELECT *
				    FROM t_participant
					WHERE id_participant = ? ";
		$query	= $this->db->query($sql, array($id));
		$data 	= $query->row();

		return $data;

	}

	public function submit($action, $data){

		$this->db->trans_start();
			if($action == "Add"){

				$data["created"]	= $this->session->userdata('user_id');
				$data["created_at"] = date("Y-m-d",time());
				
				$this->db->insert('t_participant',$data); 
		
			}else{

			
				$this->db->where('id_participant', $data["id_participant"]);
				$this->db->update('t_participant', $data); 
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

	public function delete($id_participant){

		$this->db->trans_start();
		$this->db->query("DELETE FROM t_participant WHERE id_participant = ?", array($id_participant));
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