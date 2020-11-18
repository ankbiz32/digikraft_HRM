<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Summary extends CI_Controller {


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
        $this->load->model('Summary_Model','summ');
    }


    public function index(){
        if($this->session->userdata('user_login_access') != False) {
			$data['clients'] = $this->crud->getInfo('clients');
			$this->load->view('backend/summary_clients',$data);
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

	public function summary_serv($id)
	{
		if($this->session->userdata('user_login_access') != False) {
			$data=array();
			$data['client'] = $this->crud->getInfoId('clients','id',$id);
			$data['summary'] = $this->summ->get_non_billed_summary($id);
			$this->load->view('backend/summary',$data);
        }
		else{
			redirect(base_url() , 'refresh');
		} 
	}

	public function summary_serv_billed($id)
	{
		if($this->session->userdata('user_login_access') != False) {
			$data=array();
			$data['client'] = $this->crud->getInfoId('clients','id',$id);
			$data['summary'] = $this->summ->get_billed_summary($id);
			$this->load->view('backend/summary_billed',$data);
        }
		else{
			redirect(base_url() , 'refresh');
		} 
	}
		
	public function addSummary($cid)
	{
        if($this->session->userdata('user_login_access') != False) {
			$data['client'] = $this->crud->getInfoId('clients','id',$cid);
			$data['services'] = $this->crud->getInfo('services');
			$data['path'] = base_url().'summary/saveSummary/'.$cid;
			$this->load->view('backend/summaryForm', $data);
        }
		else{
			redirect(base_url() , 'refresh');
		}        
	}
		
	
	public function saveSummary($cid)
	{
		$data=$this->input->post();
		$data['client_id']=$cid;
		$data['date']=date('Y-m-d', strtotime($data['date']));
		if($this->crud->insertInfo('summary',$data)){
			$this->session->set_flashdata('feedback','Service created');
			echo "Service added";
		}
		else{
			echo "Server error !";
		}
	}

    public function editSummary($cid,$id){
        if($this->session->userdata('user_login_access') != False) { 
			
			$data= array();
			$data['client'] = $this->crud->getInfoId('clients','id',$cid);
			$data['services'] = $this->crud->getInfo('services');
			$data['service'] = $this->crud->getInfoId('summary','id',$id);
			$data['path'] = base_url().'summary/updateSummary/'.$cid.'/'.$id;
			// var_dump('<pre>',$data);exit;
			$this->load->view('backend/summaryForm', $data);
        }
		else{
			redirect(base_url() , 'refresh');
		}        
	}

    public function updateSummary($cid,$id){
        if($this->session->userdata('user_login_access') != False) {
			$data=$this->input->post();
			$data['client_id']=$cid;
			$data['date']=date('Y-m-d', strtotime($data['date']));
			$data['updated_at']=date('Y-m-d H:i:s');
			if($this->crud->updateInfo('summary',$data,'id',$id)){
				$this->session->set_flashdata('feedback','Service updated');
				echo "Service updated";
			}
			else{
				echo "Server error !";
			}
        }
		else{
			redirect(base_url() , 'refresh');
		}        
	}

    public function deleteSummary($cid,$id){
        if($this->session->userdata('user_login_access') != False) { 
			$this->crud->deleteInfo('summary','id',$id);
			$this->session->set_flashdata('delsuccess', 'Successfully Deleted');
			redirect('summary/summary_serv/'.$cid);
        }
		else{
			redirect(base_url() , 'refresh');
		}        
	}

	public function toInvoice()
    {
		$ids=json_decode($this->input->post('id'));
		foreach($ids as $id){
			$inv_items[$id] = $this->crud->getInfoId('summary','id',$id);
			$inv_items[$id]->price = $this->crud->getInfoId('services','id',$inv_items[$id]->service_id)->price;
		}
		$cid=json_decode($this->input->post('cid'));
		$response['inv_items'] = $inv_items;
		$response['ids'] = $ids;
		$response['cid'] =$cid;
        echo json_encode($response);
    }

    
}
