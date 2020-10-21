<?php

class Notice_model extends CI_Model{


    	function __consturct(){
    	   parent::__construct();
    	
    	}
    public function GetNotice(){
        $sql = "SELECT * FROM `notice` ORDER BY `notice`.`date` DESC;";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result; 
        }
    public function Published_Notice($data){
        $this->db->insert('notice',$data);
    }
    public function GetNoticelimit(){
        $this->db->order_by('date', 'DESC');
		$query = $this->db->get('notice');
		$result =$query->result();
        return $result;        
	}
	
	public function DeletNotice($id){ 
		$noti = $this->getInfoById($id, 'notice');
		$checkimage = "./assets/images/notice/".$noti->file_url; 
		// var_dump('<pre>',$noti->file_url,$checkimage);exit;
		$this->db->delete('notice',array('id'=> $id));
		if(file_exists($checkimage)){
			unlink($checkimage);
		}      
	}

	public function getInfoById($id, $table)
	{
		return $this->db->where('id', $id)->get($table)->row();
	}     
}
?>
