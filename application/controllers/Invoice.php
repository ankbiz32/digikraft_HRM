<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Invoice extends CI_Controller
{


	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->model('login_model');
		$this->load->model('dashboard_model');
		$this->load->model('employee_model');
		$this->load->model('organization_model');
		$this->load->model('settings_model');
		$this->load->model('leave_model');
		$this->load->model('Crud_model', 'crud');
		$this->load->model('Invoice_model', 'invoice');
	}


	public function proforma()
	{
		if ($this->session->userdata('user_login_access') != False) {
			$data['invoices'] = $this->invoice->get_all_invoice();
			$this->load->view('backend/proforma', $data);
		} else {
			redirect(base_url(), 'refresh');
		}
	}


	public function index()
	{
		if ($this->session->userdata('user_login_access') != False) {
			$data['invoices'] = $this->invoice->get_all_final_invoice();
			$this->load->view('backend/invoice_services', $data);
		} else {
			redirect(base_url(), 'refresh');
		}
	}

	public function trash()
	{
		if ($this->session->userdata('user_login_access') != False) {
			$data['invoices'] = $this->invoice->get_all_invoiceTrash();
			$this->load->view('backend/invoice_services', $data);
		} else {
			redirect(base_url(), 'refresh');
		}
	}

	public function showInvoice($insert_id)
	{
		if ($this->session->userdata('user_login_access') != False) {

			$data = array();
			$data['invoice'] = $this->crud->getInfoId('invoice', 'id', $insert_id);
			$data['client'] = $this->crud->getInfoId('clients', 'id', $data['invoice']->client_id);
			$data['all_invoice'] = $this->crud->getInfo('invoice', ['client_id' => $data['invoice']->client_id]);
			$due = 0;
			foreach ($data['all_invoice'] as $d) {
				if ($d->inv_no != $data['invoice']->inv_no) {
					$due += $d->total_due;
				}
			}
			$data['invoice']->prev_due = $due;
			$data['inv_items'] = $this->invoice->get_all_items_by_invoiceJoin($data['invoice']->id);
			$data['cat'] = $this->invoice->get_all_items_by_invoiceJoin_cat($data['invoice']->id);
			$data['settings'] = $this->crud->getInfoId('settings', 'id', 1);

			$data['amtWords'] = ucfirst($this->getWords($data['invoice']->total));

			$this->load->view('backend/showInvoice', $data);
		} else {
			redirect(base_url(), 'refresh');
		}
	}

	public function sendWhatsAppProforma($insert_id)
	{
		if ($this->session->userdata('user_login_access') != False) {

			$data = array();
			$data['invoice'] = $this->crud->getInfoId('invoice', 'id', $insert_id);
			$data['client'] = $this->crud->getInfoId('clients', 'id', $data['invoice']->client_id);
			$data['all_invoice'] = $this->crud->getInfo('invoice', ['client_id' => $data['invoice']->client_id]);
			$due = 0;
			foreach ($data['all_invoice'] as $d) {
				if ($d->inv_no != $data['invoice']->inv_no) {
					$due += $d->total_due;
				}
			}
			$data['invoice']->prev_due = $due;
			$data['inv_items'] = $this->invoice->get_all_items_by_invoiceJoin($data['invoice']->id);
			$data['cat'] = $this->invoice->get_all_items_by_invoiceJoin_cat($data['invoice']->id);
			$data['settings'] = $this->crud->getInfoId('settings', 'id', 1);

			$data['amtWords'] = ucfirst($this->getWords($data['invoice']->total));

			$this->load->view('backend/sendWhatsAppProforma', $data);
		} else {
			redirect(base_url(), 'refresh');
		}
	}

	public function addInvoice()
	{
		if ($this->session->userdata('user_login_access') != False) {
			$data['invoice'] = '';
			$data['clients'] = $this->crud->getInfo('clients');
			$data['items'] = $this->crud->getInfo('services');
			$data['path'] = base_url() . 'invoice/saveInvoice/';
			$this->load->view('backend/invoiceForm', $data);
		} else {
			redirect(base_url(), 'refresh');
		}
	}
	public function saveInvoice()
	{
		$insert_id = $this->invoice->store_invoice_record();

		if ($this->invoice->store_invoice_item_record($insert_id)) {

			if ($this->input->post('ref_quotation_id')) {
				$this->db->where('id', $this->input->post('ref_quotation_id'))->update('quotations', ['ref_invoice_id' => $insert_id]);
			}
			$this->session->set_flashdata('feedback', 'Invoice generated');
			echo "Invoice generated";
			redirect(base_url() . "/invoice/proforma");
		} else {
			$data['path'] = base_url() . 'invoice/saveInvoice/';
			$this->load->view('backend/invoiceForm', $data);
			$this->session->set_flashdata('formdata', 'Server Error!');
		}
	}

	public function saveInvoiceFromQuotation()
	{
		$insert_id = $this->invoice->store_invoice_record();
		if ($this->invoice->store_invoice_item_record($insert_id)) {
			if ($this->input->post('ref_quotation_id')) {
				$this->db->where('id', $this->input->post('ref_quotation_id'))->update('quotations', ['ref_invoice_id' => $insert_id]);
			}
			$this->session->set_flashdata('feedback', 'Invoice generated');
			redirect(base_url() . "/invoice/proforma");
		} else {
			$this->session->set_flashdata('error', 'Error occured');
			redirect(base_url() . "/invoice/proforma");
		}
	}

	public function editinvoice($id)
	{
		if ($this->session->userdata('user_login_access') != False) {
			$data = array();
			$data['invoice'] = $this->crud->getInfoId('invoice', 'id', $id);
			$data['inv_items'] = $this->invoice->get_all_items_by_invoiceJoin($data['invoice']->id);
			$data['clients'] = $this->crud->getInfo('clients');
			$data['items'] = $this->crud->getInfo('services');
			if(isset($_GET['final'])){
				$data['path'] = base_url() . 'invoice/updateInvoice/' . $id.'?final=1';
			}
			else{
				$data['path'] = base_url() . 'invoice/updateInvoice/' . $id;
			}
			// var_dump('<pre>',$data);exit;
			$this->load->view('backend/invoiceFormEdit', $data);
		} else {
			redirect(base_url(), 'refresh');
		}
	}

	public function updateinvoice($id)
	{
		// var_dump('<pre>',$_GET);exit;
		if ($this->session->userdata('user_login_access') != False) {

			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			// $this->form_validation->set_rules('item_id','Service','trim|required|xss_clean');
			$this->form_validation->set_rules('invoice_no', 'Invoice No.', 'trim|required|xss_clean');

			if ($this->form_validation->run() == FALSE) {
				$data = array();
				$data['invoice'] = $this->crud->getInfoId('invoice', 'id', $id);
				$data['inv_items'] = $this->invoice->get_all_items_by_invoiceJoin($data['invoice']->id);
				$data['clients'] = $this->crud->getInfo('clients');
				$data['items'] = $this->crud->getInfo('services');
				$data['path'] = base_url() . 'invoice/updateInvoice/' . $id;
				$this->load->view('backend/invoiceFormEdit', $data);
			} else {
				$data = $this->input->post();
				$data['updated_at'] = date('Y-m-d H:i:s');
				$success = $this->invoice->update_invoice_record($id);
				$this->session->set_flashdata('feedback', 'Successfully updated');
				echo "Successfully Updated";
				if(isset($_GET['final'])){
					redirect(base_url() . "/invoice");
				}
				else{
					redirect(base_url() . "/invoice/proforma");
				}
			}
		} else {
			redirect(base_url(), 'refresh');
		}
	}

	public function deleteInvoice($id)
	{
		if ($this->session->userdata('user_login_access') != False) {
			$this->crud->softDeleteInfo('invoice', 'id', $id);
			// $this->crud->deleteInfo('invoice','id',$id);
			// $this->crud->deleteInfo('invoice_item','invoice_id',$id);
			$this->session->set_flashdata('delsuccess', 'Successfully Deleted');
			redirect('invoice');
		} else {
			redirect(base_url(), 'refresh');
		}
	}

	public function serviceInfo()
	{
		$svc_id = $this->input->post('svc_id', true);
		$svc = $this->crud->getInfoId('services', 'id', $svc_id);
		if ($svc) {
			$resp = array();
			$resp['price'] = $svc->price;
			$resp['short_descr'] = $svc->short_descr;
		} else {
			$resp = '';
		}
		echo json_encode($resp);
	}

	public function sendInvoice($id, $final)
	{
		$invoice = $this->crud->getInfoId('invoice', 'id', $id);
		$client = $this->crud->getInfoId('clients', 'id', $invoice->client_id);
		if ($client->email == '') {
			$this->session->set_flashdata('error', 'E-mail id not found for this client. Please set the e-mail id for the client.');
		} else {
			// if (file_exists('assets/test.pdf')){
			// 	unlink('assets/test.pdf');
			// }
			// // Creating dynamic PDF & saving it in assets folder
			// $this->load->library('pdf');
			// $this->pdf->set_base_path('http://localhost/hrm_digikraft/');
			// $html_content = '
			// 	<link href="http://localhost/hrm_digikraft/assets/css/test.css" rel="stylesheet">
			// 	<h3 class="red-custom">Convert HTML to PDF in CodeIgniter using Dompdf</h3>
			// ';
			// $this->pdf->loadHtml($html_content);
			// $this->pdf->setPaper('A4','Portrait');
			// $this->pdf->render();
			// // $this->pdf->stream("dompdf_out.pdf", array("Attachment" => false));
			// $file = $this->pdf->output();
			// file_put_contents('assets/test.pdf', $file);
			// exit;

			// Sending the dynamic PDF through attachment from SMTP e-mail
			$this->load->config('email');
			// $from = $this->email->smtp_user;
			$from = 'no-reply@digikraftsocial.com';
			$to = $client->email;
			$subject = 'Invoice #' . $invoice->inv_no . ' - DigiKraft Social';
			$message = '
				<p><b>Hi ' . $client->name . ',<b></p>
				';
			if ($final == 'final') {
				$message .= '
					<p>Your invoice has been generated. Please click on the button below to see your invoice.</p>
					<p>&nbsp;</p>
					<p style="text-align:center"><a href="' . base_url() . 'invoice/download/' . $client->id . '/' . $invoice->id . '/' . $invoice->inv_no . '?final=1" style="font-size:16px;padding:5px 15px; background-color:#34A2C6; color:white; text-decoration:none;">SEE INVOICE</a></p>
					<p>&nbsp;</p>
					<p >Cannot see the button? Copy & paste the below link in your browser to see your invoice.</p>
					<p >' . base_url() . 'invoice/download/' . $client->id . '/' . $invoice->id . '/' . $invoice->inv_no . '?final=1</p>
				';
			} else {
				$message .= '
					<p>Your unpaid invoice has been generated. Please click on the button below to see your invoice.</p>
					<p>&nbsp;</p>
					<p style="text-align:center"><a href="' . base_url() . 'invoice/download/' . $client->id . '/' . $invoice->id . '/' . $invoice->inv_no . '" style="font-size:16px;padding:5px 15px; background-color:#34A2C6; color:white; text-decoration:none;">SEE INVOICE</a></p>
					<p>&nbsp;</p>
					<p>Cannot see the button? Copy & paste the below link in your browser to see your invoice.</p>
					<p>' . base_url() . 'invoice/download/' . $client->id . '/' . $invoice->id . '/' . $invoice->inv_no . '</p>
				';
			}
			$message .= '
				<p>&nbsp;</p>
				<p>&nbsp;</p>
				<p>Thanks & Regards,</p>
				<p>DigiKraft Social</p>
			';

			$this->email->set_newline("\r\n");
			$this->email->from($from, 'DigiKraft Social');
			$this->email->to($to);
			$this->email->subject($subject);
			$this->email->message($message);

			if ($this->email->send()) {
				$this->session->set_flashdata('feedback', 'Mail sent');
			} else {
				$this->session->set_flashdata('error', 'Error sending mail');
			}
		}

		if ($final == 'final') {
			redirect(base_url('invoice'));
		} else {
			redirect(base_url('invoice/proforma'));
		}
		// unlink('assets/test.pdf');
	}



	public function sales_report()
	{
		if ($this->session->userdata('user_login_access') != False) {
			unset($_SESSION['dates']);
			$data = array();
			$data['invoices'] = $this->invoice->get_all_invoice_report();
			$this->load->view('backend/sales_report', $data);
		} else {
			redirect(base_url(), 'refresh');
		}
	}

	public function salesReportDateFilter()
	{
		if ($this->session->userdata('user_login_access') != False) {
			
			$from=date('Y-m-d 00:00:00',strtotime($_POST['from']));
			$to=date('Y-m-d 00:00:00',strtotime($_POST['to']));
			$conds='inv_date BETWEEN "'. $from. '" and "'. $to.'"';
			$data = array();
			$data['invoices'] = $this->invoice->get_all_invoice_report(null, $conds);
			$data['dates']='<strong>'.date('d-m-Y',strtotime($from)).'</strong> to <strong>'.date('d-m-Y',strtotime($to)).'</strong> ';
			$this->load->view('backend/sales_report', $data);
		} else {
			redirect(base_url(), 'refresh');
		}
	}

	public function download($cid, $insert_id, $iid)
	{
		$info = $this->db->where('client_id', $cid)->where('inv_no', $iid)->where('id', $insert_id)->where('is_deleted', 0)->get('invoice')->row();
		if ($info) {
			$data = array();
			$data['invoice'] = $this->crud->getInfoId('invoice', 'id', $insert_id);
			$data['client'] = $this->crud->getInfoId('clients', 'id', $data['invoice']->client_id);
			$data['inv_items'] = $this->invoice->get_all_items_by_invoiceJoin($data['invoice']->id);
			$data['cat'] = $this->invoice->get_all_items_by_invoiceJoin_cat($data['invoice']->id);
			$data['settings'] = $this->crud->getInfoId('settings', 'id', 1);

			$data['amtWords'] = ucfirst($this->getWords($data['invoice']->total));

			// var_dump('<pre>',$amtWords);exit;
			$this->load->view('backend/downloadInvoice', $data);
		} else {
			echo '<p style="text-align:center; line-height:90vh; font-size:18px; font-family:sans-serif "><b>No invoice found.</b></p>';
		}
	}


	function getWords($number)
	{
		$decimal = round($number - ($no = floor($number)), 2) * 100;
		$hundred = null;
		$digits_length = strlen($no);
		$i = 0;
		$str = array();
		$words = array(
			0 => '', 1 => 'one', 2 => 'two',
			3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
			7 => 'seven', 8 => 'eight', 9 => 'nine',
			10 => 'ten', 11 => 'eleven', 12 => 'twelve',
			13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
			16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
			19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
			40 => 'forty', 50 => 'fifty', 60 => 'sixty',
			70 => 'seventy', 80 => 'eighty', 90 => 'ninety'
		);
		$digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
		while ($i < $digits_length) {
			$divider = ($i == 2) ? 10 : 100;
			$number = floor($no % $divider);
			$no = floor($no / $divider);
			$i += $divider == 10 ? 1 : 2;
			if ($number) {
				$plural = (($counter = count($str)) && $number > 9) ? '' : null;
				$hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
				$str[] = ($number < 21) ? $words[$number] . ' ' . $digits[$counter] . $plural . ' ' . $hundred : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural . ' ' . $hundred;
			} else $str[] = null;
		}
		$Rupees = implode('', array_reverse($str));
		return ($Rupees ? $Rupees . 'rupees only' : '');
	}
}
