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

	public function showPayment($id)
	{
		if($this->session->userdata('user_login_access') != False) {
			$data=array();
			$data['rcpt'] = $this->crud->getInfoId('client_payments','id',$id);
			if($data['rcpt']->invoice_id){
				$data['inv_no'] = $this->crud->getInfoId('invoice','id',$data['rcpt']->invoice_id)->inv_no;
			}
			$data['client'] = $this->crud->getInfoId('clients','id',$data['rcpt']->client_id); 
			$data['settings'] = $this->crud->getInfoId('settings','id',1);
			// var_dump('<pre>',$data);exit;
			$this->load->view('backend/showPayment',$data);
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
			$data['payment'] = $this->crud->getInfoId('client_payments','id',$id);
			$data['inv'] = $this->crud->getInfoId('invoice','id',$data['payment']->invoice_id);
			$data['clients'] = $this->crud->getInfo('clients');
			$data['path'] = base_url().'payment/updatePayment/'.$id;
			// var_dump('<pre>',$data);exit;
			$this->load->view('backend/paymentFormEdit', $data);
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
			$this->form_validation->set_rules('receipt_no','Quotation No.','trim|required|xss_clean');

			if ($this->form_validation->run() == FALSE) {
				echo validation_errors();
			}
			else{
				$success = $this->pay->update_payment($id);
				$this->session->set_flashdata('feedback','Successfully updated');
				// echo "Successfully Updated";
				redirect(base_url('payment') , 'refresh');
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


	public function sendReceipt($id)
	{
		$rcpt = $this->crud->getInfoId('client_payments','id',$id);
		$client= $this->crud->getInfoId('clients','id',$rcpt->client_id);
		if($client->email==''){
			$this->session->set_flashdata('error','E-mail id not found for this client. Please set the e-mail id for the client.');
		}
		else{
			$this->load->config('email');
			$from = 'no-reply@digikraftsocial.com';
			$to = $client->email;
			$subject = 'Payment receipt #'.$rcpt->receipt_no.' - DigiKraft Social';
			$message = '
				<p><b>Hi '. $client->name.',<b></p>
				<p>Your payment receipt has been generated. Please click on the button below to see your payment receipt.</p>
				<p>&nbsp;</p>
				<p style="text-align:center"><a href="'.base_url().'payment/download/'.$client->id.'/'.$rcpt->id.'/'.$rcpt->receipt_no.'" style="font-size:16px;padding:5px 15px; background-color:#34A2C6; color:white; text-decoration:none;">SEE PAYMENT RECEIPT</a></p>
				<p>&nbsp;</p>
				<p >Cannot see the button? Copy & paste the below link in your browser to see your payment receipt.</p>
				<p >'.base_url().'payment/download/'.$client->id.'/'.$rcpt->id.'/'.$rcpt->receipt_no.'</p>
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
		redirect(base_url('payment') );
		// unlink('assets/test.pdf');
	}

	
    public function download($cid,$insert_id,$iid){
		$info= $this->db->where('client_id', $cid)->where('receipt_no', $iid)->where('id', $insert_id)->where('is_deleted', 0)->get('client_payments')->row();
		if($info){
			$data=array();
			$data['rcpt'] = $this->crud->getInfoId('client_payments','id',$insert_id);
			if($data['rcpt']->invoice_id){
				$data['inv_no'] = $this->crud->getInfoId('invoice','id',$data['rcpt']->invoice_id)->inv_no;
			}
			$data['client'] = $this->crud->getInfoId('clients','id',$data['rcpt']->client_id); 
			$data['settings'] = $this->crud->getInfoId('settings','id',1);
	
			$this->load->view('backend/downloadReceipt',$data);
		}
		else{
			echo '<p style="text-align:center; line-height:90vh; font-size:18px; font-family:sans-serif "><b>No receipt found.</b></p>';
		}
	}



    
}
