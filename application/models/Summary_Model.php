<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Summary_model extends CI_Model
{
	public function store_quotation_record()
	{
		$data = array(
			'quote_no' => $this->input->post('quote_no', true),
			'client_id' => $this->input->post('client_id', true),
			'quote_date' => $this->input->post('quote_date', true),
			'valid_till' => $this->input->post('valid_till', true),
			'gst' => $this->input->post('vat', true),
			'status' => 'SENT',
			'remarks' => $this->input->post('remarks', true),
			'discount' => $this->input->post('discount', true)
		);
		$item_price = $this->input->post('price[]', true);
		$item_qty = $this->input->post('qty[]', true);
		$amount = 0;
		for ($i = 0; $i < count($item_price); $i++) {
			$amount += ($item_price[$i] * $item_qty[$i]);
		}
		$vat = $this->input->post('vat', true);
		$vat_amount = $amount * ($vat / 100);
		$total_amount = $amount + $vat_amount;
		$paid = $this->input->post('discount', true);
		$data['sub_total'] = $amount;
		$data['total'] = $total_amount - $paid;
		// var_dump('<pre>',$data);exit;
		$this->db->insert('quotations', $data);
		return $this->db->insert_id();
	}

	public function store_quotation_item_record($insert_id)
	{
		
		// var_dump('dd',$_POST);exit;
		$item_id = $this->input->post('item_id[]', true);
		$item_description = $this->input->post('description[]', true);
		$item_price = $this->input->post('price[]', true);
		$item_qty = $this->input->post('qty[]', true);
		$data = array();
		for ($i = 0; $i < count($item_id); $i++) {
			$data[$i] = array(
				'item_id' => $item_id[$i],
				'descr' => $item_description[$i],
				'price' => $item_price[$i],
				'qty' => $item_qty[$i],
				'quotation_id' => $insert_id
			);
		}
		if($this->db->insert_batch('quotation_item', $data)){
			return true;
		}
		else{
			return false;
		}
	}

	public function update_quotation_record($id)
	{
		// var_dump('<pre>',$_POST);exit;
		$data = array();
		$data2 = array();

		$item_id = $this->input->post('item_id[]', true);
		$item_description = $this->input->post('description[]', true);
		$item_price = $this->input->post('price[]', true);
		$item_qty = $this->input->post('qty[]', true);
		$amount = 0;
		
		$this->db->delete('quotation_item', array('quotation_id' => $id));
		for ($i = 0; $i < count($item_id); $i++) {
			$amount += ($item_price[$i] * $item_qty[$i]);
			
			$data2[$i] = array(
				'quotation_id' => $id,
				'item_id' => $item_id[$i],
				'descr' => $item_description[$i],
				'price' => $item_price[$i],
				'qty' => $item_qty[$i]
			);
			$this->db->insert('quotation_item', $data2[$i]);
		}
		$vat = $this->input->post('vat', true);
		$vat_amount = $amount * ($vat / 100);
		$total_amount = $amount + $vat_amount;
		$discount = $this->input->post('discount', true);
		$data['quote_no'] = $this->input->post('quote_no', true);
		$data['quote_date'] = $this->input->post('quote_date', true);
		$data['valid_till'] = $this->input->post('valid_till', true);
		$data['updated_at'] = date('Y-m-d H:i:s');
		$data['sub_total'] = $amount;
		$data['discount'] = $this->input->post('discount', true);
		$data['total'] = $total_amount - $discount;
		$data['remarks'] = $this->input->post('remarks', true);
		$data['status'] = $this->input->post('status', true);

		// var_dump('<pre>',$data, $data2);exit;

		$this->db->where('id', $id)->update('quotations', $data);
	}

	public function get_non_billed_summary($client_id, $conds=null)
	{
		 $this->db->select('s.*, sv.name AS service_name')
					->from('summary s')
					->join('services sv', 'sv.id = s.service_id', 'LEFT');
					if($conds){
						$this->db->where($conds);
					}
		return $this->db->where('s.client_id',$client_id)
						->where('is_billed',0)
						->order_by('date','desc')
						->get()->result();
	}

	public function get_billed_summary($client_id, $conds=null)
	{
		 $this->db->select('s.*, sv.name AS service_name')
					->from('summary s')
					->join('services sv', 'sv.id = s.service_id', 'LEFT');
					if($conds){
						$this->db->where($conds);
					}
		return $this->db->where('s.client_id',$client_id)
						->where('is_billed',1)
						->order_by('date','desc')
						->get()->result();
	}



	public function get_all_quotationTrash()
	{
		return $this->db->select('q.*, c.name')
						->from('quotations q')
						->join('clients c', 'c.id = q.client_id', 'LEFT')
						->where('is_deleted',1)
						->order_by('id','desc')
						->get()->result();
	}

	function get_all_items_by_quotationJoin($id){
		return $this->db->select('ii.*, s.name')
						->from('quotation_item ii')
						->join('services s', 's.id = ii.item_id', 'LEFT')
						->where('quotation_id', $id)
						->get()->result();
	}

	public function setToBilled($ids)
	{
		$this->db->where_in("id", $ids);
    	$this->db->update("summary",['is_billed'=>1,'updated_at'=>date('Y-m-d H:i:s')]);
	}
	
	public function get_settings_record()
	{
		return $this->db->where('id', 1)->get('tbl_settings')->row();
	}

	public function delete_invoice_record($id)
	{
		$this->db->delete('tbl_invoice_item', array('invoice_id' => $id));
		$this->db->delete('tbl_invoice', array('id' => $id));
		if ($this->db->affected_rows() > 0) {
			return "Data Deleted Successfully";
		}
	}

}
