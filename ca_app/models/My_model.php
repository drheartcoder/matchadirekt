<?php if(!defined('BASEPATH'))exit('No direct script access allowed');
class My_model extends CI_Model {
/*
	Created On : 30 April 2018
	Project Name: Sanket Nidhi Limited
*/
 
   // function MyModel()
    public function __construct()
    {
        // Call the Model constructor
       parent::__construct();
    }

	/*
	|--------------------------------------------------------------------------
	| Function for select table data
	|--------------------------------------------------------------------------
		$tablename	=	"bl_users";
		$fieldarr	=	"userid, username, city";
		$condarr	=	"userid > 1";
		$ob			=	"city desc";
		$start		=	0;
		$end		=   3;
		$gb			=	"city";
	*/ 	
	function selTableData($tablename="", $fieldarr="", $condarr="", $ob="", $start=0, $end=0, $gb="")
    {
		
		$this->db->select($fieldarr);
		
		if($condarr != "")
			$this->db->where($condarr);
		
		if($gb != "")
			$this->db->group_by($gb);
		
		if($ob != "")
			$this->db->order_by($ob);
			
		if($end)
			$this->db->limit($end, $start);
		
        $query = $this->db->get_compiled_select($tablename);
		return $this->exequery($query);
    }
	
	/*
	|--------------------------------------------------------------------------
	| Function for select table data
	|--------------------------------------------------------------------------
		$tablename	=	"bl_users";
		$fieldarr	=	"userid, username, city";
		$condarr	=	"userid > 1";
		$ob			=	"city desc";
		$start		=	0;
		$end		=   3;
		$gb			=	"city";
	*/ 	
	function getSingleRowData($tablename="", $fieldarr="", $condarr="", $ob="")
    {
		
		$this->db->select($fieldarr);
		
		if($condarr != "")
			$this->db->where($condarr);
		
		/*if($gb != "")
			$this->db->group_by($gb);*/
		
		if($ob != "")
			$this->db->order_by($ob);
			
		//$this->db->limit(0,1);
		
        $query = $this->db->get_compiled_select($tablename);
		return $this->exequery($query,1);
    }
	
	/*
	|--------------------------------------------------------------------------
	| Function for Insert unique data into table
	|--------------------------------------------------------------------------
	*/ 	
    function insert($tablename="",$insertdata=array())
    {
		if($tablename!=""){
			$this->db->insert($tablename, $insertdata);
			return $this->db->insert_id();
		} else {
			return  FALSE;
		}	
    }
	

	/*
	|--------------------------------------------------------------------------
	| Function for Update data 
	|--------------------------------------------------------------------------
	*/ 	
    function update($tablename="",$updatedata=array(),$cond)
    {
		if(count($cond)){
        	$flag=$this->db->update($tablename, $updatedata, $cond);
			return $flag;
		}else{
			return FALSE;
		}
    }
	
	/*
	|--------------------------------------------------------------------------
	| Function to Delete data 
	|--------------------------------------------------------------------------
	*/ 	
	function del($tablename="",$cond=array())
	{
		if( count($cond) )
		{
      $flag = $this->db->delete($tablename,$cond); 
			return $flag;
		}else{
			return FALSE;
		}
    }
	
	/*
	|--------------------------------------------------------------------------
	| Function to execute give custom query
	|--------------------------------------------------------------------------
	*/ 

	function exequery($query="", $isSingleRow = 0) {		
		$query      =	$this->db->query($query);
		//echo $this->db->last_query(); exit;
		$recordset	=	array();
		if($query && $query->num_rows())
		{
			foreach($query->result() as $row) {
				if($isSingleRow)
					$recordset = $query->row();
				else
					$recordset[]	=	$row;	
			}
			return	$recordset;
		}
		else
		return	FALSE;
    }

    
}// end class
?>