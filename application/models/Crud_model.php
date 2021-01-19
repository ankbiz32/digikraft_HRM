<?php

class Crud_model extends CI_Model{


	function __consturct(){
		parent::__construct();
	}

	
	public function getInfo($table,$conds=null){
		if($conds){
			$this->db->where($conds);
		}
		$query = $this->db->get($table);
		$result = $query->result();
		return $result;
	}

	public function getInfo2($table,$conds=null){
		if($conds){
			$this->db->where($conds)
			
			->where("cd.created >='$from'")
			->where("cd.created <='$to'");
		}
		$query = $this->db->get($table);
		$result = $query->result();
		return $result;
	}

	function getServices(){
		return $this->db->select('s.*, sc.cname')
						->from('services s')
						->join('services_category sc', 'sc.id = s.category_id', 'LEFT')
						->order_by('id','desc')
						// ->where('invoice_id', $id)
						->get()->result();
	}

	function getProposals(){
		return $this->db->select('p.*, c.name')
						->from('proposal p')
						->join('clients c', 'c.id = p.client_id', 'LEFT')
						->order_by('id','desc')
						// ->where('invoice_id', $id)
						->get()->result();
	}

	function getExpenses(){
		return $this->db->select('e.*, em.first_name, em.last_name')
						->from('expenses e')
						->join('employee em', 'em.id = e.user_id', 'LEFT')
						->order_by('created_at','desc')
						->get()->result();
	}

	function getExpensesId($id){
		return $this->db->select('e.*, em.first_name, em.last_name')
						->from('expenses e')
						->join('employee em', 'em.id = e.user_id', 'LEFT')
						->order_by('created_at','desc')
						->where('e.id',$id)
						->get()->row();
	}


	public function getInfoId($table,$col,$id,$conds=null){
		$query = $this->db->where($col,$id);
		if($conds){
			$query->where($conds);
		}
		$result = $query->get($table)->row();
		return $result;
	}

	public function insertInfo($table,$data){
		if ($this->db->insert($table,$data)){
			return $this->db->insert_id();
		}
		else{
			return false;
		}
	}

	public function softDeleteInfo($table,$col,$id){
		$d=$this->db->where($col,$id)->update($table,['is_deleted'=>1]);
		if ($d){
			return true;
		}
		else{
			return false;
		}
	}

	public function deleteInfo($table,$col,$id){
		return $this->db->delete($table,array($col => $id ));
	}

	
	public function updateInfo($table, $data, $col, $id){
		$d=$this->db->where($col,$id)->update($table,$data);
		if ($d){
			return true;
		}
		else{
			return false;
		}
	}






}
?>
