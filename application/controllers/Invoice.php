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


    public function index(){
        if($this->session->userdata('user_login_access') != False) {
			$data['invoices'] = $this->invoice->get_all_invoice();
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
			$data['settings'] = $this->crud->getInfoId('settings','id',1);
			// var_dump('<pre>',$data);exit;
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


    
}
