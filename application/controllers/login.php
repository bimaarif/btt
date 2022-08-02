<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class login extends CI_Controller {
	
	public function index()
	{
		$this->_rules();

		if($this->form_validation->run() == FALSE){
			$data['title'] = 'login';
			$this->load->view('templates_admin/header');
		    $this->load->view('login');
		}else{
            $username = $this->input->post('username', TRUE);
			$password = $this->input->post('password', TRUE);
			
			$cek = $this->loginModel->cek_login($username,$password);

			if($cek == FALSE){
               $this->session->set_flashdata('message','<div class="alert alert-danger alert-dismissible  fade show" role="alert">
			   <strong>username atau password anda salah !</strong>
			   <button type="button" class="close" data-dismiss="alert" aria-label="Close">
				   <span aria-hidden="true">&times;</span>
			   </button>
			   </div>');
			   redirect('login'); 
			}else{
				// var_dump($cek->row());
				// var_dump($cek->row()->username);
				// var_dump($cek->row()->fullname);
				
				$this->session->set_userdata('username', $cek->row()->username);
			    $this->session->set_userdata('fullname', $cek->row()->fullname);

	
				redirect('admin/tambah_btt');
			}
		}

		
	}

	public function _rules(){
		$this->form_validation->set_rules('username','username','required');
		$this->form_validation->set_rules('password','password','required');
	}

	public function logout(){
		$this->session->sess_destroy();
		redirect('login');
	}
}
