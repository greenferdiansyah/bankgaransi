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
				
				$id 		= $row['id'];


				$iconAction = "<center>
					<a href='main#".$parent_page."/form/".base64_encode($this->encryption->encrypt('Edit')).'/'.base64_encode($this->encryption->encrypt($id))."' class='btn btn-warning btn-xs'  title='Edit'>
						<i class='fa fa-pencil'></i>
					</a>
                	<a onclick=del('".$id."') id=$id class='btn btn-danger btn-xs' title='Delete'><i class='fa fa-times' style='color: white;'></i></a></center>";
				
				$output['data'][]=array(
					$nomor_urut, 
					$row['company_name'],
					$row['site_url'],
					$row['email_support'],
					$row['phone_support'],
					$row['city'],
					$row['zip_code'],
					($row['status']==1)?"<label class='label label-success'>active</label>":"<label class='label label-danger'>deactive</label>",
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

				$title					= 'Add Tenant';
				$tenant_id				= null;
				$tenant_alias			= null;
				$company_id 			= null;
				$company_name			= null;
				$company_nickname		= null;
				$company_description	= null;
				$logo					= null;
				$city					= null;
				$address 				= null;
				$site_url				= null;
				$zip_code 				= null;
				$email_support 			= null;
				$phone_support 			= null;
				$status 				= null;
				$created_at 			= date("Y-m-d h:m:s",time());
				$lup					= date("Y-m-d h:m:s",time());
				$upd	 				= $this->session->userdata('user_id');

				if ($action == 'Edit') {
					
					$result			= $this->M_admin_tenant->detail_data($id);

					$title					= 'Edit Tenant';
					$tenant_id				= $result->id;
					$tenant_alias			= $result->tenant_alias;
					$company_id 			= $result->company_id;
					$company_name			= $result->company_name;
					$company_nickname		= $result->company_nickname;
					$company_description	= $result->company_description;
					$logo					= $result->logo;
					$city					= $result->city;
					$address 				= $result->address;
					$site_url				= $result->site_url;
					$zip_code 				= $result->zip_code;
					$email_support 			= $result->email_support;
					$phone_support 			= $result->phone_support;
					$status 				= $result->status;
					$created_at				= date("Y-m-d",strtotime($result->created_at));
					$lup					= date("Y-m-d",strtotime($result->updated_at));
					$upd					= $result->updated;
			
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
					'tenant_id'				=> $tenant_id,
					'tenant_alias'			=> $tenant_alias,
					'company_id'			=> $company_id,
					'company_name'			=> $company_name,
					'company_nickname'		=> $company_nickname,
					'company_description'	=> $company_description,
					'logo'					=> $logo,
					'city'					=> $city,
					'address'				=> $address,
					'site_url'				=> $site_url,
					'zip_code'				=> $zip_code,
					'email_support'			=> $email_support,
					'phone_support'			=> $phone_support,
					'status'				=> $status,
					'created_at'			=> $created_at,
					'lup'					=> $lup,
					'upd'					=> $upd,
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
		$data_company = array(
								
								'company_name'			=> $this->input->post("company_name"),
								'company_nickname'		=> $this->input->post("company_nickname"),
								'company_description'	=> $this->input->post("company_description"),
								'logo'					=> $this->input->post("logo"),
								'city'					=> $this->input->post("city"),
								'address'				=> $this->input->post("address"),
								'site_url'				=> $this->input->post("site_url"),
								'zip_code'				=> $this->input->post("zip_code"),
								'email_support'			=> $this->input->post("email_support"),
								'phone_support'			=> $this->input->post("phone_support"),
								'status'				=> $this->input->post("status"),
								'updated_at'			=> date("Y-m-d",time()),
								'updated'				=> $this->session->userdata('user_id')
						);
		$data_tenant = array(
								'id'					=> $this->input->post("tenant_id"),
								'tenant_alias'			=> $this->input->post("tenant_alias"),
								'company_id'			=> $this->input->post("company_id"),
								'tenant_name'			=> $data_company["company_name"],
								'status'				=> $data_company["status"],
								'updated_at'			=> $data_company["updated_at"],
								'updated'				=> $data_company["updated"]

						);
		
		$response	= $this->M_admin_tenant->submit($action, $data_company, $data_tenant);

		echo json_encode(array("status"=> $response["status"], "title"=>$response["title"], "reason"=> $response["reason"]));
	}


	public function delete(){
		$tenant_id 		= $this->input->post("id");
		$response	= $this->M_admin_tenant->delete($tenant_id);
		echo json_encode(array("status"=> $response["status"], "title"=>$response["title"], "reason"=> $response["reason"]));
	}
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */
