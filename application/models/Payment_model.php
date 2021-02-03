<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment_model extends CI_Model
{
	public function store_payment()
	{
		$data = $this->input->post();
		
		$data['amount']=(int)$data['amount'];
		unset($data['payment_type']);
		if($this->input->post('payment_type')=="advance"){
			unset($data['invoice_id']);
		}
		// var_dump('<pre>',$data);exit;

		if($this->db->insert('client_payments', $data)){
			$amt=$data['amount'];
			$cid=$data['client_id'];
			
			if($this->input->post('payment_type')=="advance"){
				$bal=$this->db->where('id', $cid)->get('clients')->row()->balance;
				$newbal=$bal+$amt;
				$this->db->where('id', "$cid");
				$this->db->set('balance' , $newbal);
				$this->db->update('clients');
				// $this->db->query("UPDATE clients SET balance = balance + '$amt' WHERE id='$cid' ");
			}
			else{
				$invid=$data['invoice_id'];
				$info=$this->db->where('id', $invid)->get('invoice')->row();
				$paid=$info->total_paid + $amt;
				$due=$info->total_due - $amt;

				$this->db->where('id', $data['invoice_id']);
				$this->db->set('total_paid', $paid);
				$this->db->set('total_due', $due);
				$this->db->update('invoice');
			}

			return true;
		}
		else{
			return false;
		}
	}

	public function update_payment($id)
	{
		// var_dump('<pre>',$this->input->post());exit;
		$data=$this->input->post();
		$old_payment=$this->db->where('id', $id)->get('client_payments')->row();
		if($data['advance_payment']){
			$bal=$this->db->where('id', $data['client_id'])->get('clients')->row()->balance;
			$bal= $bal - $old_payment->amount + $data['amount'];
			$this->db->where('id', $data['client_id'])->update('clients', ['balance'=>$bal]);
		}
		else{
			$inv=$this->db->where('id', $old_payment->invoice_id)->get('invoice')->row();
			$paid= $inv->total_paid - $old_payment->amount + $data['amount'];
			$due= $inv->total_due + $old_payment->amount - $data['amount'];
			$this->db->where('id', $old_payment->invoice_id)->update('invoice', ['total_paid'=>$paid, 'total_due'=>$due]);
		}
		unset($data['advance_payment']);
		$data['updated_at']=date('Y-m-d H:i:s');
		if($this->db->where('id', $id)->update('client_payments', $data)){
			return true;
		}
		else{
			return false;
		}
    }
    
    
	public function get_all_payments()
	{
		
		return $this->db->select('i.*, c.name, c.person, in.inv_no, in.total_due, in.id AS inv_id')
						->from('client_payments i')
						->join('invoice in', 'in.id = i.invoice_id', 'LEFT')
						->join('clients c', 'c.id = i.client_id', 'LEFT')
						->where('i.is_deleted',0)
						->order_by('id','desc')
						->get()->result();
	}

	public function get_all_paymentsTrash()
	{
		return $this->db->order_by('id','desc')->where('is_deleted',1)->get('invoice')->result();
	}

    public function getProforma($client){
		$query = $this->db->where('client_id',$client)->where('total_due > 0');
		$result = $query->get('invoice')->result();
		return $result;
	}

	public function get_settings_record()
	{
		return $this->db->where('id', 1)->get('tbl_settings')->row();
	}

}
