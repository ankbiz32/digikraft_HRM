<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quotation_model extends CI_Model
{
	public function store_quotation_record()
	{
		// var_dump($_POST);exit;
		$data = array(
			'inv_no' => $this->input->post('invoice_no', true),
			'client_id' => $this->input->post('client_id', true),
			'inv_date' => $this->input->post('date', true),
			'gst' => $this->input->post('vat', true),
			'remarks' => $this->input->post('remarks', true),
			'total_paid' => $this->input->post('paid', true)
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
		$paid = $this->input->post('paid', true);
		$data['sub_total'] = $amount;
		$data['total_due'] = $total_amount - $paid;
		$data['total'] = $total_amount;
		$this->db->insert('quotations', $data);
		return $this->db->insert_id();
	}

	public function store_invoice_item_record($insert_id)
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
				'invoice_id' => $insert_id
			);
		}
		if($this->db->insert_batch('quotation_item', $data)){
			return true;
		}
		else{
			return false;
		}
	}

	public function update_invoice_record($id)
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
			$this->db->insert('quotation_item', $data2[$i]);
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

		$this->db->where('id', $id)->update('quotations', $data);
	}

	public function update_invoice_item_record()
	{
		
	}

	public function get_all_quotation()
	{
		return $this->db->order_by('id','desc')->where('is_deleted',0)->get('quotations')->result();
	}

	public function get_invoice_record($invoice_id)
	{
		return $this->db->where('id', $invoice_id)->get('quotations')->row();
	}

	public function get_all_items_by_invoice($invoice_id)
	{
		return $this->db->where('invoice_id', $invoice_id)->get('quotation_item')->result();
	}

	function get_all_items_by_invoiceJoin($id){
		return $this->db->select('ii.*, s.name')
						->from('invoice_item ii')
						->join('services s', 's.id = ii.item_id', 'LEFT')
						->where('invoice_id', $id)
						->get()->result();
	}

	public function count_item_record_by_invoice($invoice_id)
	{
		return $this->db->where('invoice_id', $invoice_id)->count_all_results('tbl_invoice_item');
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

	public function get_for_chart()
	{
		$data = $this->db->query('SELECT client_id, SUM(total) as amount FROM `tbl_invoice` GROUP BY client_id')->result_array();
		if($data) {
			foreach ($data as $d) {
				$client = $this->MClient->get_record($d['client_id']);
				$d['amount'] = (int)$d['amount'];
				$name = $client->name;
				$data = array($d['amount']);
				$series_data[] = array('name' => $name, 'data' => $data);

			}
			return $series_data = json_encode($series_data);
		}
	}
}
