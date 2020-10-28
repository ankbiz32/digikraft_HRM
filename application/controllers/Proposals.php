<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proposals extends CI_Controller {


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
    }


    public function index(){
        if($this->session->userdata('user_login_access') != False) { 
			$data['proposals'] = $this->crud->getProposals();
			$this->load->view('backend/proposals',$data);
        }
		else{
			redirect(base_url() , 'refresh');
		}            
	}
		
    public function addProposal(){
        if($this->session->userdata('user_login_access') != False) {
			$data['clients'] = $this->crud->getInfo('clients');
			$data['path'] = base_url().'proposals/saveProposal';
			$this->load->view('backend/proposalForm', $data);
        }
		else{
			redirect(base_url() , 'refresh');
		}        
	}
		
    public function saveProposal(){
        if($this->session->userdata('user_login_access') != False) {

			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			$this->form_validation->set_rules('client_id','Client','trim|required|xss_clean');
			$this->form_validation->set_rules('follow_up_date','Follow up date','trim|required|xss_clean');

			if ($this->form_validation->run() == FALSE) {
				echo validation_errors();
			}
			else{
				$data=$this->input->post();
				$data['follow_up_date']=date('Y-m-d',strtotime($_POST['follow_up_date']));
				if($_FILES['file']['name']){
					$config = array(
						'upload_path' => "assets/proposals",
						'allowed_types' => "*",
						'overwrite' => False,
						'max_size' => "20240000"
					);

					$this->load->library('Upload', $config);
					$this->upload->initialize($config);                
					if (!$this->upload->do_upload('file')) {
						echo $this->upload->display_errors();
					}

					else {
						$imgdata = $this->upload->data();
						$data['file_src'] = $imgdata['file_name'];
					}
				}
				if($this->crud->insertInfo('proposal',$data)){
					$this->session->set_flashdata('feedback','Successfully Added');
					echo "Successfully Added";
				}
				else{
					echo "Server error !";
				}
			}
			
        }
		else{
			redirect(base_url() , 'refresh');
		}        
	}

    public function editProposal($id){
        if($this->session->userdata('user_login_access') != False) { 
			$data= array();
			$data['clients'] = $this->crud->getInfo('clients');
			$data['path'] = base_url().'proposals/updateProposal/'.$id;
			$data['proposal'] = $this->crud->getInfoId('proposal','id',$id);
			// var_dump('<pre>',$data['client']);exit;
			$this->load->view('backend/proposalForm', $data);
        }
		else{
			redirect(base_url() , 'refresh');
		}        
	}

    public function updateProposal($id){
        if($this->session->userdata('user_login_access') != False) {

			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			$this->form_validation->set_rules('client_id','Client','trim|required|xss_clean');
			$this->form_validation->set_rules('follow_up_date','Follow up date','trim|required|xss_clean');

			if ($this->form_validation->run() == FALSE) {
				echo validation_errors();
			}
			else{
				$data=$this->input->post();
				$data['follow_up_date']=date('Y-m-d',strtotime($_POST['follow_up_date']));
				if($_FILES['file']['name']){
					$config = array(
						'upload_path' => "assets/proposals",
						'allowed_types' => "*",
						'overwrite' => False,
						'max_size' => "20240000"
					);

					$this->load->library('Upload', $config);
					$this->upload->initialize($config);                
					if (!$this->upload->do_upload('file')) {
						echo $this->upload->display_errors();
					}

					else {
						$imgdata = $this->upload->data();
						$data['file_src'] = $imgdata['file_name'];
						$fileArr=$this->crud->getInfoId('proposal','id',$id);
						unlink('assets/proposals/'.$fileArr->file_src);
					}
				}
				if($this->crud->updateInfo('proposal',$data,'id',$id)){
					$this->session->set_flashdata('feedback','Successfully updated');
					echo "Successfully Updated";
				}
				else{
					echo "Server error !";
				}
			}
			
        }
		else{
			redirect(base_url() , 'refresh');
		}        
	}

    public function deleteProposal($id){
        if($this->session->userdata('user_login_access') != False) { 
			$fileArr=$this->crud->getInfoId('proposal','id',$id);
			unlink('assets/proposals/'.$fileArr->file_src);
			$this->crud->deleteInfo('proposal','id',$id);
			$this->session->set_flashdata('delsuccess', 'Successfully Deleted');
			redirect('proposals');
        }
		else{
			redirect(base_url() , 'refresh');
		}        
	}
    
}
