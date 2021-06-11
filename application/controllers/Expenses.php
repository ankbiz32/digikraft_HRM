<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Expenses extends CI_Controller
{


	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->model('login_model');
		$this->load->model('dashboard_model');
		$this->load->model('employee_model');
		$this->load->model('organization_model');
		$this->load->model('settings_model');
		$this->load->model('leave_model');
		$this->load->model('Crud_model', 'crud');
	}


	public function index()
	{
		// var_dump('<pre>',$this->session->userdata);exit;
		if ($this->session->userdata('user_login_access') != False) {
			$data['expenses'] = $this->crud->getExpenses();
			$this->load->view('backend/expenses', $data);
		} else {
			redirect(base_url(), 'refresh');
		}
	}

	public function addExpense()
	{
		if ($this->session->userdata('user_login_access') != False) {
			$data['path'] = base_url() . 'expenses/saveExpense';
			$this->load->view('backend/expenseForm', $data);
		} else {
			redirect(base_url(), 'refresh');
		}
	}

	public function saveExpense()
	{
		if ($this->session->userdata('user_login_access') != False) {
			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			$this->form_validation->set_rules('amount', 'Amount', 'trim|required|xss_clean');
			$this->form_validation->set_rules('descr', 'Description', 'trim|required|xss_clean');
			$this->form_validation->set_rules('created_at', 'Date', 'trim|required|xss_clean');

			if ($this->form_validation->run() == FALSE) {
				$data['path'] = base_url() . 'expenses/saveExpense';
				$this->load->view('backend/expenseForm', $data);
			} else {
				$data = $this->input->post();
				$data['user_id'] = $this->session->userdata('uid');
				$data['created_at'] = date('Y-m-d', strtotime($data['created_at']));
				if ($_FILES['file']['name']) {
					$config = array(
						'upload_path' => "assets/expenses",
						'allowed_types' => "*",
						'overwrite' => False,
						'max_size' => "20240000"
					);

					$this->load->library('Upload', $config);
					$this->upload->initialize($config);
					if (!$this->upload->do_upload('file')) {
						echo $this->upload->display_errors();
						return;
					} else {
						$imgdata = $this->upload->data();
						$data['file_src'] = $imgdata['file_name'];
					}
				}
				// var_dump('<pre>',$data);exit;
				if ($this->crud->insertInfo('expenses', $data)) {
					$this->session->set_flashdata('message', '<div class="message" style="display:initial;opacity:1">Expense added</div>');
					redirect('expenses');
				} else {
					$this->session->set_flashdata('message', '<div class="message" style="display:initial;background-color:#d00000">Error</div>');
					redirect('expenses');
				}
			}
		} else {
			redirect(base_url(), 'refresh');
		}
	}

	public function editExpense($id)
	{
		if ($this->session->userdata('user_login_access') != False) {
			$data = array();
			$data['expense'] = $this->crud->getExpensesId($id);
			$data['path'] = base_url() . 'expenses/updateExpense/' . $id;
			// var_dump('<pre>',$data['client']);exit;
			$this->load->view('backend/expenseForm', $data);
		} else {
			redirect(base_url(), 'refresh');
		}
	}

	public function updateExpense($id)
	{
		if ($this->session->userdata('user_login_access') != False) {

			$this->load->library('form_validation');
			$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			$this->form_validation->set_rules('amount', 'Amount', 'trim|required|xss_clean');
			$this->form_validation->set_rules('descr', 'Description', 'trim|required|xss_clean');
			$this->form_validation->set_rules('created_at', 'Date', 'trim|required|xss_clean');

			if ($this->form_validation->run() == FALSE) {
				echo validation_errors();
			} else {
				$data = $this->input->post();
				$data['user_id'] = $this->session->userdata('uid');
				$data['created_at'] = date('Y-m-d', strtotime($data['created_at']));
				if ($_FILES['file']['name']) {
					$config = array(
						'upload_path' => "assets/expenses",
						'allowed_types' => "*",
						'overwrite' => False,
						'max_size' => "20240000"
					);

					$this->load->library('Upload', $config);
					$this->upload->initialize($config);
					if (!$this->upload->do_upload('file')) {
						echo $this->upload->display_errors();
					} else {
						$imgdata = $this->upload->data();
						$data['file_src'] = $imgdata['file_name'];
						$fileArr = $this->crud->getInfoId('expenses', 'id', $id);
					}
				}
				if ($this->crud->updateInfo('expenses', $data, 'id', $id)) {
					unlink('assets/expenses/' . $fileArr->file_src);
					$this->session->set_flashdata('message', '<div class="message" style="display:initial;opacity:1">Expense updated</div>');
					redirect('expenses');
				} else {
					$this->session->set_flashdata('message', '<div class="message" style="display:initial;background-color:#d00000">Error</div>');
					redirect('expenses');
				}
			}
		} else {
			redirect(base_url(), 'refresh');
		}
	}

	public function removeFile($id)
	{
		if ($this->session->userdata('user_login_access') != False) {
			$fileArr = $this->crud->getExpensesId($id);
			unlink('assets/expenses/' . $fileArr->file_src);
			$this->crud->updateInfo('expenses', ['file_src' => null], 'id', $id);
			$this->session->set_flashdata('message', '<div class="message" style="display:initial;opacity:1">File removed</div>');
			redirect('expenses');
		} else {
			redirect(base_url(), 'refresh');
		}
	}

	public function deleteExpense($id)
	{
		if ($this->session->userdata('user_login_access') != False) {
			$fileArr = $this->crud->getExpensesId($id);
			unlink('assets/expenses/' . $fileArr->file_src);
			$this->crud->deleteInfo('expenses', 'id', $id);
			$this->session->set_flashdata('message', '<div class="message" style="display:initial;opacity:1">Deleted</div>');
			redirect('expenses');
		} else {
			redirect(base_url(), 'refresh');
		}
	}
}
