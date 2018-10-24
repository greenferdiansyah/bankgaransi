<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page_render 
{
		
	public function __construct()
	{
		$CI =& get_instance();
		
		$this->userlevel 	= $CI->session->userdata('userlevel');
		$this->usertype 	= $CI->session->userdata('usertype');
		$this->tenant_id 	= $CI->session->userdata('tenant_id');
		//CUSTOME OJAN
		//if($this->usertype == "employee"){
			$CI->load->model('master/Master_setting');
			$menu = $CI->Master_setting->SetMenu( strtolower($this->userlevel),$this->tenant_id);
		// }else{
		// 	$CI->load->model('master_applicant/M_master_applicant');
		// 	$menu = $CI->M_master_applicant->SetMenu( strtolower($this->userlevel),$this->tenant_id);
		// }
		//END CUSTOM
	
		$menus = array('id' => array(), 'parents' => array());
		
			foreach ($menu as $menu_key){
				
				$top_menu[] = $menu_key['url'];
				
				$menus['id'][$menu_key['id']] = $menu_key;
				
				$menus['parents'][$menu_key['parent']][] = $menu_key['id'];
			}
		
		$this->top_menu = $top_menu;
				
		$this->menus = array("menus" => $menu);
		
		$file_type = get_mime_by_extension(base_url().'assets/images/users/' . $CI->session->userdata('foto'));
		
		switch ($file_type){
			
			case 'image/jpeg':
			$photo = base_url().'assets/images/users/' . $CI->session->userdata('foto');
			break;
			
			case 'image/png':
			$photo = base_url().'assets/images/users/' . $CI->session->userdata('foto');
			break;
			
			default:
			$photo = base_url().'assets/images/users/1.jpg';
			break;
			
		}
		
		$photos = array( "photos" => $photo );
		
		$this->data_menu = array("base_url" => base_url(),
						"user_id" 		=> ucwords($CI->session->userdata('user_id')),
						"fullname"	 	=> ucwords($CI->session->userdata('fullname')),
						"userlevel" 	=> ucwords($CI->session->userdata('userlevel')),
						"usertype" 		=> ucwords($CI->session->userdata('usertype')),
						"email" 		=> $CI->session->userdata('email'),
						"tenant_id" 	=> $CI->session->userdata('tenant_id'),
						"photos" 		=> $photo,
						"menus" 		=> $menus
						);
		//CUSTOME OJAN
		//if($this->usertype == "employee"){
			$this->settings = array_merge($CI->Master_setting->SetSettings(),$photos,$this->menus,$this->data_menu);
		// }else{
		// 	$this->settings = array_merge($CI->M_master_applicant->SetSettings(),$photos,$this->menus,$this->data_menu);
		// }
		//END CUSTOM
	
	
	}
	
	public function set_layout($layout,$data=NULL)
	{
			$CI =& get_instance();
			
			return array("page_content" => $CI->parser->parse($layout,$data,true));
	}
	
	public function set_menu($data=NULL,$active_menu=NULL,$level=NULL)
	{
		$CI =& get_instance();
		
		//CUSTOME OJAN
		// if($this->usertype == "employee"){
			return array("menu" =>  $CI->parser->parse("master/m_menu_user",array_merge($data, array("active_menu"=>$active_menu)),true) ) ;
		// }else{
		// 	return array("menu" =>  $CI->parser->parse("master_applicant/m_menu_user",array_merge($data, array("active_menu"=>$active_menu)),true) ) ;
		// }
		//END CUSTOME	
		
	}
	
	public function page_auth_check($url)
	{
		$CI =& get_instance();
		
		//CUSTOME OJAN
		// if($this->usertype == "employee"){
			$CI->load->model('master/Master_setting');
			$check = $CI->Master_setting->check_auth(strtolower($CI->session->userdata('userlevel')), $url );
		// }else{
		// 	$CI->load->model('master_applicant/M_master_applicant');
		// 	$check = $CI->M_master_applicant->check_auth(strtolower($CI->session->userdata('userlevel')), $url );
		// }
		//END CUSTOME
		return $check;
		
	}
	
	public function render($parent_page,$page,$data=array())
	{
		$CI =& get_instance();
		$top_menus=array();
		foreach($this->top_menu as $top_menu){
			
			if($top_menu==$parent_page){
				$topMenu='active';
			}else{
				$topMenu='';
			}
			
			$top_menus = array_merge($top_menus,array("class_".$top_menu=>$topMenu));
		}
		
		$this->menu = $this->set_menu($this->data_menu,$parent_page,$CI->session->userdata('userlevel'));
		
		$layout		= $this->set_layout($page,array_merge(array("base_url"=>base_url(), 
																"thispage"=>base_url().$page, 
																"thisparent"=>$parent_page)
										,$data,$this->data_menu));
		//CUSTOME OJAN
		//if($this->usertype == "employee"){
			return $CI->parser->parse('master/portal',array_merge($this->settings,$layout,$this->menu,$top_menus));
		// }else{
		// 	return $CI->parser->parse('master_applicant/portal',array_merge($this->settings,$layout,$this->menu,$top_menus));

		// }
		//END CUSTOME
		
	}

	public function content_render($parent_page,$page,$data=array())
	{
		$CI =& get_instance();
		$top_menus=array();

		foreach($this->top_menu as $top_menu){
			
			if($top_menu==$parent_page){
				$topMenu='active';
			}else{
				$topMenu='';
			}
			
			$top_menus = array_merge($top_menus,array("class_".$top_menu=>$topMenu));
		}
		
		$this->menu = $this->set_menu($this->data_menu,$parent_page,$CI->session->userdata('userlevel'));
		
		$layout		= $this->set_layout($page,array_merge(array("base_url"=>base_url(), 
																"thispage"=>base_url().$page, 
																"thisparent"=>$parent_page)
										,$data,$this->data_menu));
			//CUSTOME OJAN
		//if($this->usertype == "employee"){
			return $CI->parser->parse('master/content',$layout);
		// }else{
		// 	return $CI->parser->parse('master_applicant/content',$layout);

		// }
		//END CUSTOME

	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */