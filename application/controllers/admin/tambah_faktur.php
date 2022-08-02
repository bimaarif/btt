<?php

defined('BASEPATH') or exit('No direct script access allowed');

class tambah_faktur extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->db2 = $this->load->database('database2', TRUE);
	}

	public function index()
	{
		// $db2 = $this->load->database('database2', TRUE);
		// $where = array('id_rcv' => $id);
		$data['faktur'] = $this->bttModel->get_faktur('tb_faktur')->result();


		$this->load->view('templates_admin/header');
		$this->load->view('templates_admin/sidebar');
		$this->load->view('admin/tambah_faktur', $data);
		$this->load->view('templates_admin/footer');
	}

	public function updateFaktur()
	{
		$this->load->view('templates_admin/header');
		$this->load->view('templates_admin/sidebar');
		$this->load->view('admin/form_faktur');
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
			$tagihan = str_replace(['Rp', '.', ' '], '', $data['tagihan']);
			$tagihan = str_replace(',', '.', $tagihan);

			$no_faktur = $data['no_faktur'];
			$faktur_pajak = $data['fak_pjk'];
			$tagihan = $data['tagihan'];
			$csv = $data['csv'];

			// if ($csv == '') {
			// } else {
			// 	$config['upload_path'] = './assets/csv';
			// 	//   $config['allow_types'] = 'csv';
			// 	$this->load->library('upload', $config);
			// 	if (!$this->upload->do_upload('csv')) {
			// 		echo "gambar gagal diupload";
			// 	} else {
			// 		$csv = $this->upload->data('file_name');
			// 	}
			// }

			$data['no_faktur'] = $no_faktur;
			$data['fak_pjk'] = $faktur_pajak;
			$data['tagihan'] = $tagihan;
			$data['csv'] = $csv;


			// $data['btt_no'] = $btt_no;
			// $data['selisih'] = 0;
			// $data['proses'] = $data['selisih'] < 100 ? 'Verified' : 'Unverified';
			// dd($data);
			// $tmpSelisih += $data['proses'] == 'Verified' ? 0 : 1;
			$tmpData[] = $data;
		}

		foreach ($tmpData as $data) {
			// var_dump($data); die;
			$simpan = $this->bttModel->insertData($data);
		}

		// echo json_encode('success');

		// if ($simpan == 1) {
		// 	redirect('dasboard');
		// }
	}

	public function simpan_faktur()
	{
			$no_faktur = $this->input->post('no_faktur');
			$faktur_pajak = $this->input->post('fak_pjk');
			$tagihan = $this->input->post('tagihan');

			$tagihan = str_replace(['Rp', '.', ' '], '', $tagihan);
			$tagihan = str_replace(',', '.', $tagihan);

			$csv = $_FILES['csv']['name'];

			if ($csv = '') {
			} else {
				$config['upload_path'] = './assets/csv';
				$config['allowed_types'] = 'csv';
				$this->load->library('upload', $config);
				if (!$this->upload->do_upload('csv')) {
					echo "File gagal di upload";
				} else {
					$csv = $this->upload->data('file_name');
				}
			}

			$data = array(
				'no_faktur' => $no_faktur,
				'fak_pjk' => $faktur_pajak,
				'tagihan' => $tagihan,
				'csv' => $csv
			);

			$this->bttModel->insert_faktur($data,'tb_faktur');
			$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible  fade show" role="alert">
		<strong>Data Berhasil ditambahkan !</strong>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		</div>');

		redirect('admin/tambah_faktur');
		
	}

	public function hapus_faktur($id)
    {
        $this->bttModel->hapusDataFaktur($id);
        $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible  fade show" role="alert">
		<strong>Data Berhasil di hapus!</strong>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		</div>');
        redirect('admin/tambah_faktur');
    }


	public function _rules()
	{
		$this->form_validation->set_rules('no_faktur', 'no_faktur', 'required');
		$this->form_validation->set_rules('fak_pjk', 'fak_pjk', 'required');
		$this->form_validation->set_rules('tagihan', 'tagihan', 'required');
		$this->form_validation->set_rules('csv', 'csv', 'required');
	}
}
