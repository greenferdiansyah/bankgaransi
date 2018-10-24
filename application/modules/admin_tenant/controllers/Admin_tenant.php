<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_tenant extends CI_Controller {

	var $tenant_id;
	var $access; 


	function __construct() {

		parent::__construct();

		$this->load->library(array('encryption','drop_down','page_render'));
        $this->load->model("M_admin_tenant");
		$this->tenant_id 	= $this->session->userdata('tenant_id');
		$this->access 		= $this->page_render->page_auth_check('admin_tenant');
		

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
											'page_title'				=> "Tenant",
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

	public function json_list(){

			$parent_page	=  $this->uri->segment(1);
			
			$draw			= $_REQUEST['draw'];
			$length			= $_REQUEST['length'];
			$start			= $_REQUEST['start'];
			$search			= $_REQUEST['search']["value"];
			$order 			= $_REQUEST['order'][0]["column"];
			$dir 			= $_REQUEST['order'][0]["dir"];

			
			$data 			= $this->M_admin_tenant->list_data($length,$start,$search,$order,$dir);
			
			$outpu					= array();
			$output['draw']			= $draw;
			$output['recordsTotal']	= $output['recordsFiltered']=$data['total_data'];
			$output['data']			= array();
			$nomor_urut				= $start+1;
			
			foreach ($data['data'] as $rows =>$row) {
				
				$id 		= $row['id_tenant'];


				$iconAction = "<center>
					<a href='main#".$parent_page."/form/".base64_encode($this->encryption->encrypt('Edit')).'/'.base64_encode($this->encryption->encrypt($id))."' class='btn btn-warning btn-xs'  title='Edit'>
						<i class='fa fa-pencil'></i>
					</a>
                	<a onclick=del('".$id."') id=$id class='btn btn-danger btn-xs' title='Delete'><i class='fa fa-times' style='color: white;'></i></a></center>";
				
				$output['data'][]=array(
					$nomor_urut, 
					$row['company_code'],
					//$row['site_url'],
					$row['tenant_name'],
					$row['address'],
					($row['status']==1)?"<label class='label label-success'>active</label>":"<label class='label label-danger'>deactive</label>",
					$row['created'],
					$row['created_at'],
					$row['updated'],
					$row['updated_at'],
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

				$title					= 'Add Cabang';
				$id_tenant				= null;
				$tenant_name			= null;
				$company_code			= null;
				$address	 			= null;
				$status 				= null;
				// $created_at 			= date("Y-m-d h:m:s",time());
				// $lup					= date("Y-m-d h:m:s",time());
				// $upd	 				= $this->session->userdata('user_id');

				if ($action == 'Edit') {
					
					$result					= $this->M_admin_tenant->detail_data($id);

					$title					= 'Edit Cabang';
					$id_tenant				= $result->id_tenant;
					$company_code			= $result->company_code;
					$tenant_name 			= $result->tenant_name;
					$address				= $result->address;
					$status 				= $result->status;
					// $created_at			= date("Y-m-d",strtotime($result->created_at));
					// $lup					= date("Y-m-d",strtotime($result->updated_at));
					// $upd					= $result->updated;
			
				}

				$this->drop_down->select("option_id","option_name");
				$this->drop_down->from("m_option");
				$this->drop_down->where("option_type = 'opt_status'");
				$this->drop_down->order("sort", "ASC");
				$list_status				= $this->drop_down->build($status);

				$data = array(
					'parent_page'			=> $parent_page,
					'page_content'			=> $parent_page.'_'.$page,
					'base_url'				=> base_url(),
					'title'					=> $title,
					'id'					=> $id,
					'action'				=> $action==""?'Add':'Edit',
					'id_tenant'				=> $id_tenant,
					'company_code'			=> $company_code,
					'tenant_name'			=> $tenant_name,
					'address'				=> $address,
					'status'				=> $status,
					// 'created_at'			=> $created_at,
					'list_status'			=> $list_status
				);

				$this->parser->parse('master/content', $data);
			}
		}else{
			redirect('login');
		}
	}

	public function form_submit(){

		$action		 = $this->input->post("action");

		$data_tenant = array(
								'id_tenant'				=> $this->input->post("id_tenant"),
								'company_code'			=> $this->input->post("company_code"),
								'tenant_name'			=> $this->input->post("tenant_name"),
								'address'				=> $this->input->post("address"),
								'status'				=> $this->input->post("status")
								// 'updated_at'			=> $data_company["updated_at"],
								// 'updated'				=> $data_company["updated"]

						);
		
		$response	= $this->M_admin_tenant->submit($action,$data_tenant);

		echo json_encode(array("status"=> $response["status"], "title"=>$response["title"], "reason"=> $response["reason"]));
	}


	public function delete(){
		$id_tenant	= $this->input->post("id");
		$response	= $this->M_admin_tenant->delete($id_tenant);
		echo json_encode(array("status"=> $response["status"],"title"=>$response["title"], "reason"=> $response["reason"]));
	}
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */
