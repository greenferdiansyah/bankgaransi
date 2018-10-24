<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profession extends CI_Controller {

	var $tenant_id;
	var $access; 


	function __construct() {

		parent::__construct();

		$this->load->library(array('encryption','drop_down','page_render','zend'));
        $this->load->model("m_profession");
		$this->tenant_id 	= $this->session->userdata('tenant_id');
		$this->access 		= $this->page_render->page_auth_check('profession'); //url
		

    }

	public function index(){

		if($this->session->userdata('is_logged_in') == true){
			if($this->access != 0){
				$parent_page	=  $this->uri->segment(1);
				$page			=  $this->uri->segment(1);
				// $kode			=  "BB-".strtotime(date("Y-m-d h:m:s",time()));
				// $barcode		=  '<img src="'.site_url().'/profession/set_barcode/'.$kode.'">';
				$data			=	array(
											'page_content' 				=> $page,
											'parent_page'				=> $parent_page,
											'base_url'					=> base_url(),
											'page_url'					=> base_url().$page,
											'page_title'				=> "Profesi",
											//'barcode'					=> $barcode,
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
	
	public function set_barcode($code)
	{
		//load in folder Zend
		$this->zend->load('Zend/Barcode');
		//generate barcode
		Zend_Barcode::render('code128', 'image', array('text'=>$code), array());
	}

	public function json_list(){

			$parent_page	=  $this->uri->segment(1);
			
			$draw			= $_REQUEST['draw'];
			$length			= $_REQUEST['length'];
			$start			= $_REQUEST['start'];
			$search			= $_REQUEST['search']["value"];
			$order 			= $_REQUEST['order'][0]["column"];
			$dir 			= $_REQUEST['order'][0]["dir"];

			
			$data 			= $this->m_profession->list_data($length,$start,$search,$order,$dir);
			
			$output					= array();
			$output['draw']			= $draw;
			$output['recordsTotal']	= $output['recordsFiltered']=$data['total_data'];
			$output['data']			= array();
			$nomor_urut				= $start+1;
			
			foreach ($data['data'] as $rows => $row) {
				
				$id 		= $row['id_profession'];
				
				$kode 		= $row['code_profession'];
				$barkode	= '<img src="'.site_url().'/profession/set_barcode/'.$kode.'">';

				$iconAction = "<center>
					<a href='main#".$parent_page."/form/".base64_encode($this->encryption->encrypt('Edit')).'/'.base64_encode($this->encryption->encrypt($id))."' class='btn btn-warning btn-xs'  title='Edit'>
						<i class='fa fa-pencil'></i>
					</a>
                	<a onclick=del('".$id."') id=$id class='btn btn-danger btn-xs' title='Delete'><i class='fa fa-times' style='color: white;'></i></a></center>";
				
				$output['data'][]=array(
					$nomor_urut,
					$barkode, 
					$row['nm_profession'],
					$row['code_profession'],
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

				$title					= 'Tambah Profesi';
				// $tenant_id			= null;
				// $tenant_alias		= null;
				$id_profession 			= null;
				$nm_profession			= null;
				$code_profession		= null;
				$status 				= null;
				// $created_at 			= null;
				// $updated_at			= null;
				// $created				= null;
				// $updated				= null;

				if ($action == 'Edit') {
					
					$result					= $this->m_profession->detail_data($id);

					$title					= 'Edit Tenant';
					// $tenant_id			= $result->id;
					// $tenant_alias		= $result->tenant_alias;
					$id_profession 			= $result->id_profession;
					$nm_profession			= $result->nm_profession;
					$code_profession		= $result->code_profession;
					$status 				= $result->status;
			
				}

				$this->drop_down->select("option_id","option_name");
				$this->drop_down->from("m_option");
				$this->drop_down->where("option_type = 'opt_status'");
				$this->drop_down->order("sort", "ASC");
				$list_status	= $this->drop_down->build($status);

				$data = array(
					'page'					=> $parent_page,
					'page_content'			=> $parent_page.'_'.$page,
					'base_url'				=> base_url(),
					'title'					=> $title,
					'id'					=> $id,
					'action'				=> $action==""?'Add':'Edit',
					// 'tenant_id'				=> $tenant_id,
					// 'tenant_alias'			=> $tenant_alias,
					'id_profession'			=> $id_profession,
					'nm_profession'			=> $nm_profession,
					'code_profession'		=> $code_profession,
					'status'				=> $status,
					'list_status'			=> $list_status
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
								'id_profession'			=> $this->input->post("id_profession"),
								'nm_profession'			=> $this->input->post("nm_profession"),
								'code_profession'		=> $this->input->post("code_profession"),
								'status'				=> $this->input->post("status"),
								'created_at'			=> date("Y-m-d h:m:s",time()),
								'updated_at'			=> date("Y-m-d h:m:s",time()),
								'updated'				=> $this->session->userdata('user_id')
						);
		
		$response	= $this->m_profession->submit($action, $data);

		echo json_encode(array("status"=> $response["status"], "title"=>$response["title"], "reason"=> $response["reason"]));
	}


	public function delete(){
		$id_profession 	= $this->input->post("id");
		$response		= $this->m_profession->delete($id_profession);
		echo json_encode(array("status"=> $response["status"], "title"=>$response["title"], "reason"=> $response["reason"]));
	}
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */
