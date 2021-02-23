<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice extends CI_Controller {


    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('login_model');
        $this->load->model('dashboard_model'); 
        $this->load->model('employee_model'); 
        $this->load->model('organization_model');
        $this->load->model('settings_model');
        $this->load->model('leave_model');
        $this->load->model('Crud_model','crud');
        $this->load->model('Invoice_model','invoice');
    }


    public function proforma(){
        if($this->session->userdata('user_login_access') != False) {
			$data['invoices'] = $this->invoice->get_all_invoice();
			$this->load->view('backend/proforma',$data);
        }
		else{
			redirect(base_url() , 'refresh');
		}            
	}

    public function index(){
        if($this->session->userdata('user_login_access') != False) {
			$data['invoices'] = $this->invoice->get_all_final_invoice();
			$this->load->view('backend/invoice_services',$data);
        }
		else{
			redirect(base_url() , 'refresh');
		}            
	}

    public function trash(){
        if($this->session->userdata('user_login_access') != False) {
			$data['invoices'] = $this->invoice->get_all_invoiceTrash();
			$this->load->view('backend/invoice_services',$data);
        }
		else{
			redirect(base_url() , 'refresh');
		}            
	}

	public function showInvoice($insert_id)
	{
		if($this->session->userdata('user_login_access') != False) {

			$data=array();
			$data['invoice'] = $this->crud->getInfoId('invoice','id',$insert_id);
			$data['client'] = $this->crud->getInfoId('clients','id',$data['invoice']->client_id);
			$data['inv_items'] = $this->invoice->get_all_items_by_invoiceJoin($data['invoice']->id);
			$data['cat'] = $this->invoice->get_all_items_by_invoiceJoin_cat($data['invoice']->id);
			$data['settings'] = $this->crud->getInfoId('settings','id',1);

			$data['amtWords']=ucfirst($this->getWords($data['invoice']->total));

			// var_dump('<pre>',$amtWords);exit;
			$this->load->view('backend/showInvoice',$data);
        }
		else{
			redirect(base_url() , 'refresh');
		} 
	}
		
    public function addInvoice(){
        if($this->session->userdata('user_login_access') != False) {
			$data['invoice'] = '';
			$data['clients'] = $this->crud->getInfo('clients');
			$data['items'] = $this->crud->getInfo('services');
			$data['path'] = base_url().'invoice/saveInvoice/';
			$this->load->view('backend/invoiceForm', $data);
        }
		else{
			redirect(base_url() , 'refresh');
		}        
	}

	
	public function saveInvoice()
	{
		$insert_id = $this->invoice->store_invoice_record();
		
		if($this->invoice->store_invoice_item_record($insert_id)){
			
			if($this->input->post('ref_quotation_id')){
				$this->db->where('id', $this->input->post('ref_quotation_id'))->update('quotations', ['ref_invoice_id'=>$insert_id]);
			}
			$this->session->set_flashdata('feedback','Invoice generated');
			echo "Invoice generated";
		}
		else{
			echo "Server error !";
		}
	}

    public function editinvoice($id){
        if($this->session->userdata('user_login_access') != False) { 
			$data= array();
			$data['invoice'] = $this->crud->getInfoId('invoice','id',$id);
			$data['inv_items'] = $this->invoice->get_all_items_by_invoiceJoin($data['invoice']->id);
			$data['clients'] = $this->crud->getInfo('clients');
			$data['items'] = $this->crud->getInfo('services');
			$data['path'] = base_url().'invoice/updateInvoice/'.$id;
			// var_dump('<pre>',$data);exit;
			$this->load->view('backend/invoiceFormEdit', $data);
        }
		else{
			redirect(base_url() , 'refresh');
		}        
	}

    public function updateinvoice($id){
		// var_dump('<pre>',$_POST);exit;
        if($this->session->userdata('user_login_access') != False) {

			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			// $this->form_validation->set_rules('item_id','Service','trim|required|xss_clean');
			$this->form_validation->set_rules('invoice_no','Invoice No.','trim|required|xss_clean');

			if ($this->form_validation->run() == FALSE) {
				echo validation_errors();
			}
			else{
				$data=$this->input->post();
				$data['updated_at']=date('Y-m-d H:i:s');
				$success = $this->invoice->update_invoice_record($id);
				$this->session->set_flashdata('feedback','Successfully updated');
				echo "Successfully Updated";
			}
			
        }
		else{
			redirect(base_url() , 'refresh');
		}        
	}

    public function deleteInvoice($id){
        if($this->session->userdata('user_login_access') != False) { 
			$this->crud->softDeleteInfo('invoice','id',$id);
			// $this->crud->deleteInfo('invoice','id',$id);
			// $this->crud->deleteInfo('invoice_item','invoice_id',$id);
			$this->session->set_flashdata('delsuccess', 'Successfully Deleted');
			redirect('invoice');
        }
		else{
			redirect(base_url() , 'refresh');
		}        
	}

	public function serviceInfo()
	{
		$svc_id = $this->input->post('svc_id', true);
		$svc = $this->crud->getInfoId('services','id',$svc_id);
		if ($svc) {
			$resp= array();
			$resp['price'] = $svc->price;
			$resp['short_descr'] = $svc->short_descr;
		} else {
			$resp = '';
		}
		echo json_encode($resp);
	}

	public function sendPdf($id)
	{

		$this->load->library('pdf');
		$html_content = '<h3 align="center">Convert HTML to PDF in CodeIgniter using Dompdf</h3>';
		$html_content .=  json_encode($this->crud->getInfoId('invoice','id',$id));
		$this->pdf->loadHtml($html_content);
		$this->pdf->setPaper('A4','Portrait');
		$this->pdf->render();
		$file = $this->pdf->output();
		file_put_contents('assets/test.pdf', $file);

		$config = Array(
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://smtp.googlemail.com',
			'smtp_port' => 465,
			'smtp_user' => 'ankbiz32@gmail.com', // change it to yours
			'smtp_pass' => 'kgfklpnostq*32', // change it to yours
			'mailtype' => 'html',
			'charset' => 'iso-8859-1',
			'wordwrap' => TRUE
		  );
		  $this->load->library('email', $config);
		  $this->email->set_newline("\r\n");

		$this->email->from('ankbiz32@gmail.com', 'Identification');
		$this->email->to('ankur.agr32@gmail.com');
		$this->email->subject('Send Email Codeigniter');
		$this->email->message('The email send using codeigniter library');
		if($this->email->send())
			echo 'sent';
		else
			show_error($this->email->print_debugger());

		// $this->pdf->stream($id.".pdf", array("Attachment"=>0));
	}

	function getWords(float $number)
	{
		$decimal = round($number - ($no = floor($number)), 2) * 100;
		$hundred = null;
		$digits_length = strlen($no);
		$i = 0;
		$str = array();
		$words = array(0 => '', 1 => 'one', 2 => 'two',
			3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
			7 => 'seven', 8 => 'eight', 9 => 'nine',
			10 => 'ten', 11 => 'eleven', 12 => 'twelve',
			13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
			16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
			19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
			40 => 'forty', 50 => 'fifty', 60 => 'sixty',
			70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
		$digits = array('', 'hundred','thousand','lakh', 'crore');
		while( $i < $digits_length ) {
			$divider = ($i == 2) ? 10 : 100;
			$number = floor($no % $divider);
			$no = floor($no / $divider);
			$i += $divider == 10 ? 1 : 2;
			if ($number) {
				$plural = (($counter = count($str)) && $number > 9) ? '' : null;
				$hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
				$str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
			} else $str[] = null;
		}
		$Rupees = implode('', array_reverse($str));
		return ($Rupees ? $Rupees . 'rupees only' : '');
	}


    
}
