<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends CI_Controller {


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
        $this->load->model('Payment_model','pay');
    }


    public function index(){
        if($this->session->userdata('user_login_access') != False) {
			$data['payments'] = $this->pay->get_all_payments();
			$this->load->view('backend/payments',$data);
        }
		else{
			redirect(base_url() , 'refresh');
		}            
	}

    public function trash(){
        if($this->session->userdata('user_login_access') != False) {
			$data['quotations'] = $this->pay->get_all_quotationTrash();
			$this->load->view('backend/quotations',$data);
        }
		else{
			redirect(base_url() , 'refresh');
		}            
	}

	public function showPayment($insert_id)
	{
		if($this->session->userdata('user_login_access') != False) {
			$data=array();
			$data['quotation'] = $this->crud->getInfoId('quotations','id',$insert_id);
			$data['client'] = $this->crud->getInfoId('clients','id',$data['quotation']->client_id);
			$data['quotation_items'] = $this->pay->get_all_items_by_quotationJoin($data['quotation']->id);
			$data['settings'] = $this->crud->getInfoId('settings','id',1);
			// var_dump('<pre>',$data);exit;
			$this->load->view('backend/showQuotation',$data);
        }
		else{
			redirect(base_url() , 'refresh');
		} 
	}
		
    public function addPayment(){
        if($this->session->userdata('user_login_access') != False) {
			$data['clients'] = $this->crud->getInfo('clients');
			$data['path'] = base_url().'payment/savePayment/';
			$this->load->view('backend/paymentForm', $data);
        }
		else{
			redirect(base_url() , 'refresh');
		}        
	}
	
	
	public function savePayment()
	{
		// var_dump('<pre>',$_POST);exit;
		$insert_id = $this->pay->store_payment();
		if($insert_id){
			$this->session->set_flashdata('feedback','Payment added');
			redirect(base_url('payment') , 'refresh');
		}
		else{
			$this->session->set_flashdata('feedback','Some error');
			redirect(base_url('payment') , 'refresh');
		}
	}
	
    public function getProformaByClient(){
		$res['status']='false';
        if($this->session->userdata('user_login_access') != False) {
			$cid=$this->input->post('cid');
			$proforma=$this->pay->getProforma($cid);
			if($proforma){
				$res['status']='true';
				$res['main']=$proforma;
			}
        }
		echo json_encode($res);
	}
		

    public function editPayment($id){
        if($this->session->userdata('user_login_access') != False) { 
			$data= array();
			$data['invoice'] = $this->crud->getInfoId('quotations','id',$id);
			$data['inv_items'] = $this->pay->get_all_items_by_quotationJoin($data['invoice']->id);
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

    public function updatePayment($id){
		// var_dump('<pre>',$_POST);exit;
        if($this->session->userdata('user_login_access') != False) {

			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			// $this->form_validation->set_rules('item_id','Service','trim|required|xss_clean');
			$this->form_validation->set_rules('pay_no','Quotation No.','trim|required|xss_clean');

			if ($this->form_validation->run() == FALSE) {
				echo validation_errors();
			}
			else{
				$data=$this->input->post();
				$data['updated_at']=date('Y-m-d H:i:s');
				$success = $this->pay->update_payment($id);
				$this->session->set_flashdata('feedback','Successfully updated');
				echo "Successfully Updated";
			}
			
        }
		else{
			redirect(base_url() , 'refresh');
		}        
	}

    public function deletePayment($id){
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



    
}
