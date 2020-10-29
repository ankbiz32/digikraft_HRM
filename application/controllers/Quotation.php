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
			$data['quotation'] = $this->crud->getInfoId('quotation','id',$id);
			$data['quotation_items'] = $this->quote->get_all_items_by_quotationJoin($data['quotation']->id);
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

    public function deleteQuotation($id){
        if($this->session->userdata('user_login_access') != False) { 
			$this->crud->softDeleteInfo('quotation','id',$id);
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
