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

			echo true;
		}
		else{
			return false;
		}
	}

	public function update_payment($id)
	{
		// var_dump('<pre>',$_POST);exit;
		$data = array();
		$data2 = array();

		$item_id = $this->input->post('item_id[]', true);
		$item_description = $this->input->post('description[]', true);
		$item_price = $this->input->post('price[]', true);
		$item_qty = $this->input->post('qty[]', true);
		$amount = 0;
		
		$this->db->delete('invoice_item', array('invoice_id' => $id));
		for ($i = 0; $i < count($item_id); $i++) {
			$amount += ($item_price[$i] * $item_qty[$i]);
			
			$data2[$i] = array(
				'invoice_id' => $id,
				'item_id' => $item_id[$i],
				'descr' => $item_description[$i],
				'price' => $item_price[$i],
				'qty' => $item_qty[$i]
			);
			$this->db->insert('invoice_item', $data2[$i]);
		}
		$vat = $this->input->post('vat', true);
		$vat_amount = $amount * ($vat / 100);
		$total_amount = $amount + $vat_amount;
		$paid = $this->input->post('paid', true);
		$data['inv_date'] = $this->input->post('date', true);
		$data['updated_at'] = date('Y-m-d H:i:s');
		$data['sub_total'] = $amount;
		$data['total'] = $total_amount;
		$data['total_paid'] = $this->input->post('paid', true);
		$data['total_due'] = $total_amount - $paid;
		$data['remarks'] = $this->input->post('remarks', true);

		// var_dump('<pre>',$data, $data2);exit;

		$this->db->where('id', $id)->update('invoice', $data);
    }
    
    

	public function get_all_payments()
	{
		
		return $this->db->select('i.*, c.name, c.person, in.inv_no')
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
