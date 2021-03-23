<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quotation extends CI_Controller {


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
        $this->load->model('Quotation_model','quote');
    }


    public function index(){
        if($this->session->userdata('user_login_access') != False) {
			$data['quotations'] = $this->quote->get_all_quotation();
			$this->load->view('backend/quotations',$data);
        }
		else{
			redirect(base_url() , 'refresh');
		}            
	}

    public function trash(){
        if($this->session->userdata('user_login_access') != False) {
			$data['quotations'] = $this->quote->get_all_quotationTrash();
			$this->load->view('backend/quotations',$data);
        }
		else{
			redirect(base_url() , 'refresh');
		}            
	}

	public function showQuotation($insert_id)
	{
		if($this->session->userdata('user_login_access') != False) {
			$data=array();
			$data['quotation'] = $this->crud->getInfoId('quotations','id',$insert_id);
			$data['client'] = $this->crud->getInfoId('clients','id',$data['quotation']->client_id);
			$data['quotation_items'] = $this->quote->get_all_items_by_quotationJoin($data['quotation']->id);
			$data['settings'] = $this->crud->getInfoId('settings','id',1);
			// var_dump('<pre>',$data);exit;
			$this->load->view('backend/showQuotation',$data);
        }
		else{
			redirect(base_url() , 'refresh');
		} 
	}
		
    public function addQuotation(){
        if($this->session->userdata('user_login_access') != False) {
			$data['clients'] = $this->crud->getInfo('clients');
			$data['items'] = $this->crud->getInfo('services');
			$data['path'] = base_url().'quotation/saveQuotation/';
			$this->load->view('backend/quotationForm', $data);
        }
		else{
			redirect(base_url() , 'refresh');
		}        
	}
		
	
	public function saveQuotation()
	{
		$insert_id = $this->quote->store_quotation_record();
		if($this->quote->store_quotation_item_record($insert_id)){
			$this->session->set_flashdata('feedback','Quotation created');
			echo "Quotation created";
		}
		else{
			echo "Server error !";
		}
	}

    public function editQuotation($id){
        if($this->session->userdata('user_login_access') != False) { 
			$data= array();
			$data['invoice'] = $this->crud->getInfoId('quotations','id',$id);
			$data['inv_items'] = $this->quote->get_all_items_by_quotationJoin($data['invoice']->id);
			$data['clients'] = $this->crud->getInfo('clients');
			$data['items'] = $this->crud->getInfo('services');
			$data['path'] = base_url().'quotation/updateQuotation/'.$id;
			// var_dump('<pre>',$data);exit;
			$this->load->view('backend/quotationFormEdit', $data);
        }
		else{
			redirect(base_url() , 'refresh');
		}        
	}

    public function updateQuotation($id){
		// var_dump('<pre>',$_POST);exit;
        if($this->session->userdata('user_login_access') != False) {

			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			// $this->form_validation->set_rules('item_id','Service','trim|required|xss_clean');
			$this->form_validation->set_rules('quote_no','Quotation No.','trim|required|xss_clean');

			if ($this->form_validation->run() == FALSE) {
				echo validation_errors();
			}
			else{
				$data=$this->input->post();
				$data['updated_at']=date('Y-m-d H:i:s');
				$success = $this->quote->update_quotation_record($id);
				$this->session->set_flashdata('feedback','Successfully updated');
				echo "Successfully Updated";
			}
			
        }
		else{
			redirect(base_url() , 'refresh');
		}        
	}

    public function deleteQuotation($id){
        if($this->session->userdata('user_login_access') != False) { 
			$this->crud->softDeleteInfo('quotations','id',$id);
			// $this->crud->deleteInfo('invoice','id',$id);
			// $this->crud->deleteInfo('invoice_item','invoice_id',$id);
			$this->session->set_flashdata('delsuccess', 'Successfully Deleted');
			redirect('quotation');
        }
		else{
			redirect(base_url() , 'refresh');
		}        
	}

	
    public function convertToInvoice($id){
        if($this->session->userdata('user_login_access') != False) { 
			$data= array();
			$data['invoice'] = $this->crud->getInfoId('quotations','id',$id);
			$data['inv_items'] = $this->quote->get_all_items_by_QuotJoin($id);
			$data['clients'] = $this->crud->getInfo('clients');
			$data['items'] = $this->crud->getInfo('services');
			$data['path'] = base_url().'invoice/saveInvoiceFromQuotation/';
			// var_dump('<pre>',$data);exit;
			$this->load->view('backend/quotToInv', $data);
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

	
	public function sendQuote($id)
	{
		$quote = $this->crud->getInfoId('quotations','id',$id);
		$client= $this->crud->getInfoId('clients','id',$quote->client_id);
		if($client->email==''){
			$this->session->set_flashdata('error','E-mail id not found for this client. Please set the e-mail id for the client.');
		}
		else{
			$this->load->config('email');
			$from = 'no-reply@digikraftsocial.com';
			$to = $client->email;
			$subject = 'Quotation #'.$quote->quote_no.' - DigiKraft Social';
			$message = '
				<p><b>Hi '. $client->name.',<b></p>
				<p>Your quotation has been generated. Please click on the button below to see the quotation.</p>
				<p>&nbsp;</p>
				<p style="text-align:center"><a href="'.base_url().'quotation/download/'.$client->id.'/'.$quote->id.'/'.$quote->quote_no.'" style="font-size:16px;padding:5px 15px; background-color:#34A2C6; color:white; text-decoration:none;">SEE QUOTATION</a></p>
				<p>&nbsp;</p>
				<p >Cannot see the button? Copy & paste the below link in your browser to see quotation.</p>
				<p >'.base_url().'quotation/download/'.$client->id.'/'.$quote->id.'/'.$quote->quote_no.'</p>
				<p>&nbsp;</p>
				<p>&nbsp;</p>
				<p>Thanks & Regards,</p>
				<p>DigiKraft Social</p>
			';

			$this->email->set_newline("\r\n");
			$this->email->from($from,'DigiKraft Social');
			$this->email->to($to);
			$this->email->subject($subject);
			$this->email->message($message);

			if ($this->email->send()) {
				$this->session->set_flashdata('feedback','Mail sent');
			} else {
				$this->session->set_flashdata('error','Error sending mail');
			}
		}
		redirect(base_url('quotation') );
		// unlink('assets/test.pdf');
	}

	
    public function download($cid,$insert_id,$iid){
		$info= $this->db->where('client_id', $cid)->where('quote_no', $iid)->where('id', $insert_id)->where('is_deleted', 0)->get('quotations')->row();
		if($info){

				$data=array();
				$data['quotation'] = $this->crud->getInfoId('quotations','id',$insert_id);
				$data['client'] = $this->crud->getInfoId('clients','id',$data['quotation']->client_id);
				$data['quotation_items'] = $this->quote->get_all_items_by_quotationJoin($data['quotation']->id);
				$data['settings'] = $this->crud->getInfoId('settings','id',1);
	
				$this->load->view('backend/downloadQuotation',$data);
		}
		else{
			echo '<p style="text-align:center; line-height:90vh; font-size:18px; font-family:sans-serif "><b>No quotation found.</b></p>';
		}
	}


    
}
