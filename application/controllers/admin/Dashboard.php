<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

	public function __construct(){
        parent::__construct();

    }

	public function index()
	{
		$this->load->view('templates_admin/header');
		$this->load->view('templates_admin/sidebar');
		$this->load->view('admin/dashboard');
		$this->load->view('templates_admin/footer');
	}

	public function insert_data()
	{
		$allData = $this->input->post('dataForm');
		// $btt_no = 'BTTT/22/' . rand();


		// $tmpSelisih = 0;
		$tmpData = [];
		for ($i = 0; $i < count($allData); $i++) {
			$data = [];
			for ($j = 0; $j < count($allData[$i]); $j++) {
				$data[$allData[$i][$j]['name']] = $allData[$i][$j]['value'];
			}
			$tagihan = str_replace(['Rp', '.', ' '], '', $data['jumlah_tagihan']);
			$tagihan = str_replace(',', '.', $tagihan);
			$qrcode = $data['qrcode_pajak'];
			$no_faktur = $data['no_faktur_supplier'];
			$no_rcv_suzuya = $data['no_receiving_suzuya']; 
            
			$data['qrcode_pajak'] = $qrcode;
			$data['no_faktur_supplier'] = $no_faktur;
			$data['no_receiving_suzuya'] = $no_rcv_suzuya;
			$data['jumlah_tagihan'] = $tagihan;
			// $data['btt_no'] = $btt_no;
			// $data['selisih'] = 0;
			// $data['proses'] = $data['selisih'] < 100 ? 'Verified' : 'Unverified';
			// dd($data);
			// $tmpSelisih += $data['proses'] == 'Verified' ? 0 : 1;
			$tmpData[] = $data;
		}

		foreach ($tmpData as $data) {
			// var_dump($data);
			$simpan = $this->bttModel->insertData($data);
        }

		// echo json_encode('success');

		// if ($simpan == 1) {
		// 	redirect('dasboard');
		// }
	}
}
