 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Organization extends CI_Controller {


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
    
	public function index()
	{
		#Redirect to Admin dashboard after authentication
        if ($this->session->userdata('user_login_access') == 1)
            redirect('dashboard/Dashboard');
            $data=array();
            #$data['settingsvalue'] = $this->dashboard_model->GetSettingsValue();
			$this->load->view('login');
	}

    public function Department(){
        if($this->session->userdata('user_login_access') != False) { 
			$data['department'] = $this->organization_model->depselect();
			$this->load->view('backend/department',$data); 
        }
		else{
			redirect(base_url() , 'refresh');
		}            
	}

    public function Clients(){
        if($this->session->userdata('user_login_access') != False) { 
			$data['clients'] = $this->crud->getInfo('clients');
			$this->load->view('backend/clients',$data);
        }
		else{
			redirect(base_url() , 'refresh');
		}            
	}
		
    public function addClient(){
        if($this->session->userdata('user_login_access') != False) {
			$data['path'] = base_url().'organization/saveClient/';
			$this->load->view('backend/clientForm', $data);
        }
		else{
			redirect(base_url() , 'refresh');
		}        
	}
		
    public function saveClient(){
        if($this->session->userdata('user_login_access') != False) {

			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			$this->form_validation->set_rules('name','Name','trim|required|xss_clean');
			$this->form_validation->set_rules('person','Concerned Person','trim|required|xss_clean');
			$this->form_validation->set_rules('contact_no','Contact No.','trim|required|xss_clean|min_length[10]|max_length[10]');

			if ($this->form_validation->run() == FALSE) {
				echo validation_errors();
			}
			else{
				$data=$this->input->post();
				// var_dump('<pre>',$data);exit;
				if($this->crud->insertInfo('clients',$data)){
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

    public function editClient($id){
        if($this->session->userdata('user_login_access') != False) { 
			$data= array();
			$data['client'] = $this->crud->getInfoId('clients','id',$id);
			$data['path'] = base_url().'organization/updateClient/'.$id;
			// var_dump('<pre>',$data['client']);exit;
			$this->load->view('backend/clientForm', $data);
        }
		else{
			redirect(base_url() , 'refresh');
		}        
	}

    public function updateClient($id){
        if($this->session->userdata('user_login_access') != False) {

			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			$this->form_validation->set_rules('name','Name','trim|required|xss_clean');
			$this->form_validation->set_rules('person','Concerned Person','trim|required|xss_clean');
			$this->form_validation->set_rules('contact_no','Contact No.','trim|required|xss_clean|min_length[10]|max_length[10]');

			if ($this->form_validation->run() == FALSE) {
				echo validation_errors();
			}
			else{
				$data=$this->input->post();
				$data['updated_at']=date('Y-m-d H:i:s');
				$success = $this->crud->updateInfo('clients',$data,'id',$id);
				$this->session->set_flashdata('feedback','Successfully updated');
				echo "Successfully Updated";
			}
			
        }
		else{
			redirect(base_url() , 'refresh');
		}        
	}

    public function deleteClient($id){
        if($this->session->userdata('user_login_access') != False) { 
			$this->crud->deleteInfo('clients','id',$id);
			$this->session->set_flashdata('delsuccess', 'Successfully Deleted');
			redirect('organization/Clients');
        }
		else{
			redirect(base_url() , 'refresh');
		}        
	}


    public function ServicesCat(){
        if($this->session->userdata('user_login_access') != False) { 
			$data['cat'] = $this->crud->getInfo('services_category');
			$this->load->view('backend/servicesCat',$data);
        }
		else{
			redirect(base_url() , 'refresh');
		}            
	}
		
    public function addServiceCat(){
        if($this->session->userdata('user_login_access') != False) {
			$data['path'] = base_url().'organization/saveServiceCat/';
			$this->load->view('backend/serviceFormCat', $data);
        }
		else{
			redirect(base_url() , 'refresh');
		}        
	}
		
    public function saveServiceCat(){
        if($this->session->userdata('user_login_access') != False) {

			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			$this->form_validation->set_rules('cname','Service name','trim|required|xss_clean');

			if ($this->form_validation->run() == FALSE) {
				echo validation_errors();
			}
			else{
				$data=$this->input->post();
				// var_dump('<pre>',$data);exit;
				if($this->crud->insertInfo('services_category',$data)){
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

    public function editServiceCat($id){
        if($this->session->userdata('user_login_access') != False) { 
			$data= array();
			$data['cat'] = $this->crud->getInfoId('services_category','id',$id);
			$data['path'] = base_url().'organization/updateServiceCat/'.$id;
			// var_dump('<pre>',$data['client']);exit;
			$this->load->view('backend/serviceFormCat', $data);
        }
		else{
			redirect(base_url() , 'refresh');
		}        
	}

    public function updateServiceCat($id){
        if($this->session->userdata('user_login_access') != False) {

			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			$this->form_validation->set_rules('cname','Service name','trim|required|xss_clean');

			if ($this->form_validation->run() == FALSE) {
				echo validation_errors();
			}
			else{
				$data=$this->input->post();
				$data['updated_at']=date('Y-m-d H:i:s');
				$success = $this->crud->updateInfo('services_category',$data,'id',$id);
				$this->session->set_flashdata('feedback','Successfully updated');
				echo "Successfully Updated";
			}
			
        }
		else{
			redirect(base_url() , 'refresh');
		}        
	}

    public function deleteServiceCat($id){
        if($this->session->userdata('user_login_access') != False) { 
			$this->crud->deleteInfo('services_category','id',$id);
			$this->session->set_flashdata('delsuccess', 'Successfully Deleted');
			redirect('organization/ServicesCat');
        }
		else{
			redirect(base_url() , 'refresh');
		}        
	}

    public function Services(){
        if($this->session->userdata('user_login_access') != False) { 
			$data['services'] = $this->crud->getServices();
			$this->load->view('backend/services',$data);
        }
		else{
			redirect(base_url() , 'refresh');
		}            
	}
		
    public function addService(){
        if($this->session->userdata('user_login_access') != False) {
			$data['cat'] = $this->crud->getInfo('services_category');
			$data['path'] = base_url().'organization/saveService/';
			// var_dump('<pre>',$data);exit;
			$this->load->view('backend/serviceForm', $data);
        }
		else{
			redirect(base_url() , 'refresh');
		}        
	}
		
    public function saveService(){
        if($this->session->userdata('user_login_access') != False) {

			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			$this->form_validation->set_rules('name','Service name','trim|required|xss_clean');
			$this->form_validation->set_rules('price','Price','trim|required|xss_clean');

			if ($this->form_validation->run() == FALSE) {
				echo validation_errors();
			}
			else{
				$data=$this->input->post();
				// var_dump('<pre>',$data);exit;
				if($this->crud->insertInfo('services',$data)){
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

    public function editService($id){
        if($this->session->userdata('user_login_access') != False) { 
			$data= array();
			$data['cat'] = $this->crud->getInfo('services_category');
			$data['service'] = $this->crud->getInfoId('services','id',$id);
			$data['path'] = base_url().'organization/updateService/'.$id;
			// var_dump('<pre>',$data['client']);exit;
			$this->load->view('backend/serviceForm', $data);
        }
		else{
			redirect(base_url() , 'refresh');
		}        
	}

    public function updateService($id){
        if($this->session->userdata('user_login_access') != False) {

			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			$this->form_validation->set_rules('name','Service name','trim|required|xss_clean');
			$this->form_validation->set_rules('price','Price','trim|required|xss_clean');

			if ($this->form_validation->run() == FALSE) {
				echo validation_errors();
			}
			else{
				$data=$this->input->post();
				$data['updated_at']=date('Y-m-d H:i:s');
				$success = $this->crud->updateInfo('services',$data,'id',$id);
				$this->session->set_flashdata('feedback','Successfully updated');
				echo "Successfully Updated";
			}
			
        }
		else{
			redirect(base_url() , 'refresh');
		}        
	}

    public function deleteService($id){
        if($this->session->userdata('user_login_access') != False) { 
			$this->crud->deleteInfo('services','id',$id);
			$this->session->set_flashdata('delsuccess', 'Successfully Deleted');
			redirect('organization/Services');
        }
		else{
			redirect(base_url() , 'refresh');
		}        
	}
	
	
    public function Save_dep(){
		if($this->session->userdata('user_login_access') != False) { 
			$dep = $this->input->post('department');
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			$this->form_validation->set_rules('department','department','trim|required|xss_clean');

			if ($this->form_validation->run() == FALSE) {
				echo validation_errors();
			}else{
				$data = array();
				$data = array('dep_name' => $dep);
				$success = $this->organization_model->Add_Department($data);
				$this->session->set_flashdata('feedback','Successfully Added');
				echo "Successfully Added";
			}
		}
		else{
			redirect(base_url() , 'refresh');
		}        
	}
	
    public function Delete_dep($dep_id){
        if($this->session->userdata('user_login_access') != False) { 
			$this->organization_model->department_delete($dep_id);
			$this->session->set_flashdata('delsuccess', 'Successfully Deleted');
			redirect('organization/Department');
        }
		else{
			redirect(base_url() , 'refresh');
		}            
	}
	
    public function Dep_edit($dep){
        if($this->session->userdata('user_login_access') != False) { 
			$data['department'] = $this->organization_model->depselect();
			$data['editdepartment']=$this->organization_model->department_edit($dep);
			$this->load->view('backend/department', $data);
        }
		else{
			redirect(base_url() , 'refresh');
		}        
	}
	
    public function Update_dep(){
        if($this->session->userdata('user_login_access') != False) { 
			$id = $this->input->post('id');
			$department = $this->input->post('department');
			$data =  array('dep_name' => $department );
			$this->organization_model->Update_Department($id, $data);
			#$this->session->set_flashdata('feedback','Updated Successfully');
			echo "Successfully Added";
        }
		else{
			redirect(base_url() , 'refresh');
		}            
	}
	
    public function Designation(){
        if($this->session->userdata('user_login_access') != False) { 
			$data['designation'] = $this->organization_model->desselect();
			$this->load->view('backend/designation',$data);
        }
		else{
			redirect(base_url() , 'refresh');
		}        
	}
	
    public function Save_des(){
        if($this->session->userdata('user_login_access') != False) { 
			$des = $this->input->post('designation');
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters();
			$this->form_validation->set_rules('designation','designation','trim|required|xss_clean');

			if ($this->form_validation->run() == FALSE) {
				echo validation_errors();
			}else{
				$data = array();
				$data = array('des_name' => $des);
				$success = $this->organization_model->Add_Designation($data);
				echo "Successfully Added";
			}
        }
		else{
			redirect(base_url() , 'refresh');
		}            
	}
	
    public function des_delete($des_id){
        if($this->session->userdata('user_login_access') != False) {
			$this->organization_model->designation_delete($des_id);
			$this->session->set_flashdata('delsuccess', 'Successfully Deleted');
			redirect('organization/Designation');
        }
		else{
			redirect(base_url() , 'refresh');
		}        
	}
	
    public function Edit_des($des){
        if($this->session->userdata('user_login_access') != False) {
			$data['designation'] = $this->organization_model->desselect();
			$data['editdesignation']=$this->organization_model->designation_edit($des);
			$this->load->view('backend/designation', $data);
        }
		else{
			redirect(base_url() , 'refresh');
		}            
	}
	
    public function Update_des(){
        if($this->session->userdata('user_login_access') != False) {
			$id = $this->input->post('id');
			$designation = $this->input->post('designation');
			$data =  array('des_name' => $designation );
			$this->organization_model->Update_Designation($id, $data);
			echo "Successfully Updated";
        }
		else{
			redirect(base_url() , 'refresh');
		}        
    }
    
}
