<?php

defined('BASEPATH') or exit('No direct script access allowed');

class tambah_btt extends CI_Controller
{

	public function __construct(){
        parent::__construct();

    }

    public function index(){
        $kode_btt = $this->bttModel->createCode();
        $data['kode_btt'] = $kode_btt;
        $data['tampil_btt'] = $this->bttModel->get_nobtt('tb_nobtt')->result();
        $this->load->view('templates_admin/header');
		$this->load->view('templates_admin/sidebar');
		$this->load->view('admin/tambah_btt', $data);
		$this->load->view('templates_admin/footer');
    }

    // public function generate_btt(){
    //     $tahun = date('Y');
    //     $bulan = date('m');
    //     $thn = substr($tahun,2,2);
    //     $supplier = $this->session->userdata('username');
    //     $no_btt   = buatkode($supplier,$bulan.$thn, 4);
    //     // var_dump($no_btt); die;
    //     $this->bttModel->insert_nobtt($no_btt);

    //     redirect('admin/tambah_btt');
    // }

    public function inputKode(){
        $batas = date('Ym').'.'.date('dHis');
        $kodetampil = "BTTT".'.'.$batas;
        $data['no_btt'] = $kodetampil;

        $this->bttModel->insert_nobtt($data,'tb_nobtt');

        redirect('admin/tambah_btt');     
    }
}
