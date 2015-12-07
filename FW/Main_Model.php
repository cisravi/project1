<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Model extends CI_Model {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	private $foo = array();
	private $errors = array();
	public function __construct(){
		parent::__construct();		
		$this->load->library("security");
		$this->db->set_dbprefix('cr_');
	}
	
	public function validateData($value)
	{
		try{
			return $this->security->xss_clean($value);
		}
		catch(Exception $e){
			$this->errors[] = $e->getMessage();
			return 0;
		}
	}
	
	public function set($key, $value){
        $this->foo = '';
        if($key=='all'){
            foreach($value as $k=>$v){
                $this->foo[$k] = $this->validateData($v);
            }
        }
        else
            $this->foo[$key] = $this->validateData($value);
    }
	
	public function getData(){
		if(empty($this->errors)){
			/**
			* Where Condition
			* @param: select will be string or array value
			* @param: where will be array or string value
			* @param: order by is an array value
			* @param: group by is a string value
			* @param: offset
			* @param: limit
			* @param: data will be 1 (single data row) or 0 (all data)
			* @return: return array data
			*/
			$this->load->database('default');
			if(isset($this->foo['get']))
				$this->db->select($this->foo['get']);      
			if(isset($this->foo['where']) && $this->foo['where']!='')
					$this->db->where($this->foo['where'], FALSE);
	
			if(isset($this->foo['order_by']) && !empty($this->foo['order_by'])){ 
				foreach($this->foo['order_by'] as $key=>$value)
					$this->db->order_by($key, $value);
			}
			if(isset($this->foo['group_by']) && $this->foo['group_by']!='')
				$this->db->group_by($this->foo['group_by']);
	
			if(isset($this->foo['offset']) && isset($this->foo['limit']) && $this->foo['limit']!='')
				$this->db->limit($this->foo['limit'], $this->foo['offset']);
			
			$query = $this->db->get($this->foo['table']);
	
			if(isset($this->foo['return']) && $this->foo['return']==1)
				$data = $query->row_array();
			else
				$data = $query->result_array();
			unset($this->foo);
			$this->db->close();
			if(!empty($data))
				return $data;
			else
				throw new Exception('No records found');
		}
		else
			throw new Exception('Your data are not valid.');
	}
	
	/**
    * Get count of records
    * @return: Count of Records  
    */
    public function getNum(){
		if(empty($this->errors)){
			$this->load->database('default');
			$this->db->from($this->foo['table']);
			if(isset($this->foo['where']) && $this->foo['where']!='')
				$this->db->where($this->foo['where'], FALSE);
			if(isset($this->foo['where_or']))
				$this->db->or_where($this->foo['where_or'], FALSE);
			$query = $this->db->get();
			$data = $query->num_rows();
			unset($this->foo);
			$this->db->close();
			if(!empty($data))
				return $data;
			else
				throw new Exception('No records found');
		}
		else
			throw new Exception('Your data are not valid.');
    }
	
	/**
    * Insert data in database
    * @param: An array of data
    * @return: Last Insert ID
    */
	public function insert(){
		if(empty($this->errors)){
			$this->load->database('default');
			if(isset($this->foo['insert']) && !empty($this->foo['insert'])){            
			   $this->db->insert($this->foo['table'], $this->foo['insert']);
			   $data = $this->db->insert_id();
			}else
				$data = 0;
				
			unset($this->foo);
			$this->db->close();
			if(!empty($data))
				return $data;
			else
				throw new Exception('No record is save in our records.');
		}
		else
			throw new Exception('Your data are not valid.');
	}
	
	/**
    * Update data in database
    * @param: An array of where condition
    * @param: An array of data
    * @return: Update row status
    */
    public function update(){
		if(empty($this->errors)){
			$this->load->database('default');
			if(isset($this->foo['where']) && !empty($this->foo['where']) && isset($this->foo['update']) && !empty($this->foo['update'])){
				$this->db->where($this->foo['where']);
				$this->db->update($this->foo['table'], $this->foo['update']);
				$data = $this->db->affected_rows();
			}else
				$data = 0;
			unset($this->foo);
			$this->db->close();
			if($data==0)
				throw new Exception('No record is updated in our records');
			else
				return $data;
		}
		else
			throw new Exception('Your data are not valid.');
    }
	
	/**
    * Delete data in database
    * @param: An array of where condition
    * @return: delete status
    */
    public function delete(){
		if(empty($this->errors)){
			$this->load->database('default');
			if(isset($this->foo['where']) && !empty($this->foo['where'])){
				$this->db->where($this->foo['where']);
				if($this->db->delete($this->foo['table']))
					$data = 1;
				else
					$data = 0;
			}
			else
			   $data = 0;
			   
			unset($this->foo);
			$this->db->close();
			if($data==0)
				throw new Exception('Your selected record is not deleted.');
			else
				return $data;
		}
		else
			throw new Exception('Your data are not valid.');
    }
	
	/* Custom query function */
    public function customQry(){
		if(empty($this->errors)){
			$this->load->database('default');
			if($this->foo['query']!=''){
				$qry = str_replace('%s', $this->db->dbprefix($this->foo['table']), $this->foo['query']);
				$query = $this->db->query($qry, $this->foo['where']);
				if(isset($this->foo['return']) && $this->foo['return']=='1'){
					$data = $query->row_array();
				}
				else{
					$data = $query->result_array();
				}
				unset($this->foo);
				$this->db->close();
				return $data;   
			}else
				throw new Exception('Your data are not valid.');
		}
		else
			throw new Exception('Your data are not valid.');
    }
	
	//join function
    /*
    * select : parameters with comma seprators
    * from : table name
    * join : Join is an array of table and on condition
    * where : Where is an array of where condition
    */
    function join(){
		if(empty($this->errors)){
			$this->load->database('default');
			if(isset($this->foo['get']))
				$this->db->select($this->foo['get'], FALSE);
	
			$this->db->from($this->db->dbprefix($this->foo['table']));
	
			if(isset($this->foo['join']))
				foreach($this->foo['join'] as $join_table => $on_condition){
					if(isset($this->foo['join_type']) && $this->foo['join_type']!='')
						$this->db->join($this->db->dbprefix($join_table), $on_condition, $this->foo['join_type']);
					else
						$this->db->join($this->db->dbprefix($join_table), $on_condition);
				}
	
			if(isset($this->foo['where']))
				$this->db->where($this->foo['where'], FALSE);
	
			if(isset($this->foo['where_or']))
				$this->db->or_where($this->foo['where_or'], FALSE);
	
			if(isset($this->foo['order_by']))
				foreach ($this->foo['order_by'] as $order_key => $order_value)
					$this->db->order_by($order_key, $order_value);
	
			if(isset($this->foo['group_by']))
				foreach ($this->foo['group_by'] as $group_key => $group_value)
					$this->db->group_by($group_key, $group_value);
	
			if(isset($this->foo['offset']) && isset($this->foo['limit']) && $this->foo['limit']!='')
				$this->db->limit($this->foo['limit'], $this->foo['offset']);
			
			$query = $this->db->get();
			//die($this->db->last_query());
			if(isset($this->foo['return']) && $this->foo['return']=='1')
				$data = $query->row_array();
			else
				$data = $query->result_array();
			
			unset($this->foo);
			$this->db->close();
			if(empty($data))
				throw new Exception('There is not records with your requirements.');
			else
				return $data;
		}
		else
			throw new Exception('Your data are not valid.');
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */