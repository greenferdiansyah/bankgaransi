<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Drop_down extends CI_Controller 
{
	
	
	public function __construct()
	{
		$this->ci =& get_instance();
		
		$this->where_query = NULL;
		$this->order_query = NULL;
	}
		
	public function select($value,$name)
	{
		$this->value_option	= $value;
		$this->name_option	= $name;
		
		$this->select_query = "SELECT ".$this->value_option.", ".$this->name_option;
	}
	
	public function from($from_table)
	{
		$this->from_query = " FROM ".$from_table;
		
		$this->where_query = NULL;
		$this->order_query = NULL;
	}
	
	public function where($where_clause=NULL)
	{
		$where_clause==NULL?
		$this->where_query = "" :
		$this->where_query = " WHERE ".$where_clause;
		$this->order_query = NULL;	
	}

		
	public function order($order_clause=NULL, $statement)
	{
		if($order_clause == NULL){
			$this->order_query = "";
		}else{
			$this->order_query = " ORDER BY ".$order_clause." ".$statement;
		}		
	}
	
	public function build($selected_item=NULL){
		
		$sql = $this->select_query.$this->from_query.$this->where_query.$this->order_query;
		
		$query = $this->ci->db->query($sql);
		
		$result = "";
		
		foreach ($query->result_array() as $row){
				
				$rows = array_keys($row);
				
				$selected_item==$row[$rows[0]]?$selected="selected":$selected="";
				
			   $result .= "<option value='".$row[$rows[0]]."' $selected>".$row[$rows[1]]."</option>";
			}
			
		return $result;
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */