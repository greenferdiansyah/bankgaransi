<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Participant extends CI_Controller {

	var $tenant_id;
	var $access; 


	function __construct() {

		parent::__construct();

		$this->load->library(array('encryption','drop_down','page_render'));
		//$this->zend->load('Zend/Barcode');
        $this->load->model("m_participant");
		$this->tenant_id 	= $this->session->userdata('tenant_id');
		$this->access 		= $this->page_render->page_auth_check('participant'); //url
		

    }

	public function index(){

		if($this->session->userdata('is_logged_in') == true){
			if($this->access != 0){
				$parent_page	=  $this->uri->segment(1);
				$page			=  $this->uri->segment(1);
	
				$data			=	array(
											'page_content' 				=> $page,
											'parent_page'				=> $parent_page,
											'base_url'					=> base_url(),
											'page_url'					=> base_url().$page,
											'page_title'				=> "Peserta",
											'tenant_id'					=> $this->tenant_id,
											
										);
	
				$this->parser->parse('master/content', $data);
				
			}
		}else{
			redirect('login');
		}
	}

	public function logout(){
		$tenant_id_alias	= $this->session->userdata('tenant_id_alias');
		$this->session->sess_destroy();
		redirect('login/'.$tenant_id_alias);
	}
	
	// private function set_barcode($code)
	// {
	// 	//load in folder Zend
	// 	$this->zend->load('Zend/Barcode');
	// 	//generate barcode
	// 	Zend_Barcode::render('code128', 'image', array('text'=>$code), array());
	// }

	public function json_list(){

			$parent_page	=  $this->uri->segment(1);
			
			$draw			= $_REQUEST['draw'];
			$length			= $_REQUEST['length'];
			$start			= $_REQUEST['start'];
			$search			= $_REQUEST['search']["value"];
			$order 			= $_REQUEST['order'][0]["column"];
			$dir 			= $_REQUEST['order'][0]["dir"];

			
			$data 			= $this->m_participant->list_data($length,$start,$search,$order,$dir);
			
			$output					= array();
			$output['draw']			= $draw;
			$output['recordsTotal']	= $output['recordsFiltered']=$data['total_data'];
			$output['data']			= array();
			$nomor_urut				= $start+1;
			
			foreach ($data['data'] as $rows => $row) {
				
				$id 		= $row['id_participant'];

				$iconAction = "<center>
					<a href='main#".$parent_page."/form/".base64_encode($this->encryption->encrypt('Edit')).'/'.base64_encode($this->encryption->encrypt($id))."' class='btn btn-warning btn-xs'  title='Edit'>
						<i class='fa fa-pencil'></i>
					</a>
                	<a onclick=del('".$id."') id=$id class='btn btn-danger btn-xs' title='Delete'><i class='fa fa-times' style='color: white;'></i></a></center>";
				
				$output['data'][]=array(
					$nomor_urut, 
					//$row['id_participant'],
					$row['no_participant'],
					$row['bank_acc'],
                    $row['nm_participant'],
                    $row['address_participant'],
                    $row['date_participant_doc'],
                    $row['profession_id'],
					$row['created'],
					$row['created_at'],
					$row['updated'],
					$row['updated_at'],
					($row['status']==1)?"<label class='label label-success'>active</label>":"<label class='label label-danger'>deactive</label>",
					$iconAction
				);
				$nomor_urut++;
			}
			echo json_encode($output);
	}

	function mypdf(){
		// $this->load->library('pdf');
		// $pdf = new pdf();
		// $pdf->AddPage();
		// $pdf->SetFont('Arial');
		// $pdf->WriteHTML($this->load->view('mypdf', '', TRUE));
		// $pdf->Output();

		$data = array(
			"dataku" => array(
				"nama" => "Petani Kode",
				"url" => "http://petanikode.com"
			)
		);
	
		$this->load->library('pdf');
	
		$this->pdf->setPaper('A4', 'potrait');
		$this->pdf->filename = "laporan-petanikode.pdf";
		$this->pdf->load_view('mypdf', $data);
	 
   }
   

	public function form(){

		if($this->session->userdata('is_logged_in') == true){
			if($this->access != 0){

				$parent_page			= $this->uri->segment(1);
				$page					= $this->uri->segment(2);
				$action					= $this->encryption->decrypt(base64_decode($this->uri->segment(3)));
				$id						= $this->encryption->decrypt(base64_decode($this->uri->segment(4)));

				$title					= 'Tambah Peserta';
				$tenant_id				= null;
				$tenant_alias			= null;	
				$id_participant			= null;
				$nm_participant			= null;
                $no_participant 		= null;
                $address_participant	= null;
                $date_participant_doc	= null;
                $bank_acc        		= null;
                $profession_id          = null;
				$status 				= null;
				// $created_at 			= null;
				// $updated_at				= null;
				// $created				= null;
				// $updated				= null;

				if ($action == 'Edit') {
					
                    $result			        = $this->m_participant->detail_data($id);
					
					// print_r($result);
					// exit();
					// die();
					$title					= 'Edit Tenant';
					// $tenant_id  			= $result->id;
				    // $tenant_alias		= $result->tenant_alias;
					$id_participant			= $result->id_participant;
					$no_participant			= $result->no_participant;
                    $bank_acc       		= $result->bank_acc;
                    $nm_participant         = $result->nm_participant;
                    $address_participant    = $result->address_participant;
                    $date_participant_doc   = $result->date_participant_doc;
                    $profession_id          = $result->profession_id;
					$status 				= $result->status;
			
				}

				$this->drop_down->select("option_id","option_name");
				$this->drop_down->from("m_option");
				$this->drop_down->where("option_type = 'opt_status'");
				$this->drop_down->order("sort", "ASC");
                $list_status	            = $this->drop_down->build($status);
                
                $this->drop_down->select("id_profession","nm_profession");
				$this->drop_down->from("t_profession");
				//$this->drop_down->where("option_type = 'opt_status'");
				$this->drop_down->order("id_profession", "ASC");
				$list_profession	        = $this->drop_down->build($profession_id);

				$data = array(
					'page'					=> $parent_page,
					'page_content'			=> $parent_page.'_'.$page,
					'base_url'				=> base_url(),
					'title'					=> $title,
					'id'					=> $id,
					'action'				=> $action==""?'Add':'Edit',
					'tenant_id'				=> $tenant_id,
					'tenant_alias'			=> $tenant_alias,
					'id_participant'		=> $id_participant,
					'no_participant'		=> $no_participant,
                    'bank_acc'      		=> $bank_acc,
                    'nm_participant'        => $nm_participant,
                    'address_participant'   => $address_participant,
                    'date_participant_doc'  => $date_participant_doc,
                    'profession_id'         => $profession_id,
					'status'				=> $status,
                    'list_status'			=> $list_status,
                    'list_profession'		=> $list_profession
				);

				$this->parser->parse('master/content', $data);
			}
		}else{
			redirect('login');
		}
	}

	public function form_submit(){

		$action		  = $this->input->post("action");
		$data = array(
								'id_participant'		=> $this->input->post("id_participant"),
								'no_participant'		=> $this->input->post("no_participant"),
                                'bank_acc'      		=> $this->input->post("bank_acc"),
                                'nm_participant'   		=> $this->input->post("nm_participant"),
                                'address_participant'   => $this->input->post("address_participant"),
                                'date_participant_doc'  => $this->input->post("date_participant_doc"),
                                'Profession_id'         => $this->input->post("profession_id"),
								'status'				=> $this->input->post("status"),
								'updated_at'			=> date("Y-m-d h:m:s",time()),
								'updated'				=> $this->session->userdata('user_id')
						);
		
		$response	= $this->m_participant->submit($action, $data);

		echo json_encode(array("status"=> $response["status"], "title"=>$response["title"], "reason"=> $response["reason"]));
	}


	public function delete(){
		$id_participant 	= $this->input->post("id");
		$response		    = $this->m_participant->delete($id_participant);
		echo json_encode(array("status"=> $response["status"], "title"=>$response["title"], "reason"=> $response["reason"]));
	}
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */
