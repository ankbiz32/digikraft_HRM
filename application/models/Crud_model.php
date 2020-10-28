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

	function getProposals(){
		return $this->db->select('p.*, c.name')
						->from('proposal p')
						->join('clients c', 'c.id = p.client_id', 'LEFT')
						->order_by('id','desc')
						// ->where('invoice_id', $id)
						->get()->result();
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
