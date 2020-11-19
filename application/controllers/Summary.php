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
			unset($_SESSION['dates']);
			$data=array();
			$data['client'] = $this->crud->getInfoId('clients','id',$id);
			$data['summary'] = $this->summ->get_non_billed_summary($id);
			$this->load->view('backend/summary',$data);
        }
		else{
			redirect(base_url() , 'refresh');
		} 
	}

	public function dateFilter($id)
	{
		if($this->session->userdata('user_login_access') != False) {
			$data=array();
			$data['client'] = $this->crud->getInfoId('clients','id',$id);
			$from=date('Y-m-d 00:00:00',strtotime($_POST['from']));
			$to=date('Y-m-d 00:00:00',strtotime($_POST['to']));
			$conds='date BETWEEN "'. $from. '" and "'. $to.'"';
			$data['summary'] = $this->summ->get_non_billed_summary($id, $conds);
			$_SESSION['dates']='<p class="col-12"><strong> Summary from <strong>'.date('d-m-Y',strtotime($from)).'</strong> to <strong>'.date('d-m-Y',strtotime($to)).'</strong> &nbsp;&nbsp;<u><a href="'.base_url('summary/summary_serv/').$id.'">Reset</a></u></strong><p>';
			$this->load->view('backend/summary',$data);
        }
		else{
			redirect(base_url() , 'refresh');
		} 
	}

	public function dateFilterBilled($id)
	{
		if($this->session->userdata('user_login_access') != False) {
			$data=array();
			$data['client'] = $this->crud->getInfoId('clients','id',$id);
			$from=date('Y-m-d 00:00:00',strtotime($_POST['from']));
			$to=date('Y-m-d 00:00:00',strtotime($_POST['to']));
			$conds='date BETWEEN "'. $from. '" and "'. $to.'"';
			$data['summary'] = $this->summ->get_billed_summary($id, $conds);
			$_SESSION['dates']='<p class="col-12"><strong> Summary from <strong>'.date('d-m-Y',strtotime($from)).'</strong> to <strong>'.date('d-m-Y',strtotime($to)).'</strong> &nbsp;&nbsp;<u><a href="'.base_url('summary/summary_serv_billed/').$id.'">Reset</a></u></strong><p>';
			$this->load->view('backend/summary_billed',$data);
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
		if($this->session->userdata('user_login_access') != False) {
			$ids=explode(',',$this->input->post('ids'));
			// var_dump('<pre>',$ids);exit;
			foreach($ids as $id){
				$inv_items[$id] = $this->crud->getInfoId('summary','id',$id);
				$inv_items[$id]->price = $this->crud->getInfoId('services','id',$inv_items[$id]->service_id)->price;
			}
			$cid=$this->input->post('cid');
			$response= array();
			$response['inv_items'] = $inv_items;
			$response['ids'] = $ids;
			$response['cid'] =$cid;
			$response['clients'] = $this->crud->getInfo('clients');
			$response['items'] = $this->crud->getInfo('services');
			$response['path'] = base_url().'summary/saveInvoice/'.$id;
			// var_dump('<pre>',$response);exit;
			$this->load->view('backend/summToInv', $response);
        }
		else{
			redirect(base_url() , 'refresh');
		}  
		
	}

    public function saveInvoice(){
        if($this->session->userdata('user_login_access') != False) {
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			$this->form_validation->set_rules('invoice_no','Invoice No.','trim|required|xss_clean');
			if ($this->form_validation->run() == FALSE) {
				echo validation_errors();
			}
			else{
				$this->load->model('Invoice_Model','invoice');
				// var_dump('<pre>',$this->input->post());exit;
				$insert_id = $this->invoice->store_invoice_record();
				if($this->invoice->store_invoice_item_record($insert_id)){
					$ids=explode(',',$this->input->post('ids'));
					$this->summ->setToBilled($ids);
					$this->session->set_flashdata('message','<div class="message" style="display:initial;opacity:1">Invoice generated</div>');
					redirect ('summary');
				}
				else{
					$this->session->set_flashdata('message','<div class="message" style="display:initial;background-color:#d00000">Error</div>');
					redirect ('summary');
				}
			}
			
        }
		else{
			redirect(base_url() , 'refresh');
		}        
	}

    
}
