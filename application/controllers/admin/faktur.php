<?php

defined('BASEPATH') or exit('No direct script access allowed');


class faktur extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		checklogin();
		$this->db2 = $this->load->database('database2', TRUE);
		$this->load->model('FakturModel');
	}

	public function index($no_rcv)
	{
		// var_dump($no_rcv);
		// die;
		$this->load->model('FakturModel');

		$checkReceiving = $this->bttModel->noFaktur($no_rcv)->result();
		// $this->FakturModel->total_jml_fak($no_rcv)->num_rows();
		if (count($checkReceiving) > 0) {
			$data['faktur'] = $this->bttModel->cekFaktur($checkReceiving[0]->no_rcv)->result();
			$noBtt = $data['faktur'][0]->no_btt;
			// var_dump($noBtt);

			if (count($data) > 0) {
				$data['faktur'] = $this->bttModel->noFaktur($no_rcv)->result();
				$data['no_rcv'] = $no_rcv;
				$data['no_bttt'] = $noBtt;
				$data['total_faktur'] = $this->FakturModel->total_jml_fak($no_rcv)->row();
				$this->load->view('templates_admin/header');
				$this->load->view('templates_admin/sidebar');
				$this->load->view('admin/view_faktur', $data);
				$this->load->view('templates_admin/footer');
			}
		} else {

			$data['faktur'] = $this->bttModel->noFaktur($no_rcv)->result();
			$data['no_rcv'] = $no_rcv;
			$data['no_bttt'] = $no_rcv;
			$data['total_faktur'] = $this->FakturModel->total_jml_fak($no_rcv)->row();
			// var_dump($no_rcv);

			$this->load->view('templates_admin/header');
			$this->load->view('templates_admin/sidebar');
			$this->load->view('admin/view_faktur', $data);
			$this->load->view('templates_admin/footer');
		}

		// $data['faktur'] = $this->bttModel->noFaktur($no_receiving)->result();
		// $data['no_rcv'] = $no_receiving;

		// $this->load->view('templates_admin/header');
		// $this->load->view('templates_admin/sidebar');
		// $this->load->view('admin/tambah_faktur', $data);
		// $this->load->view('templates_admin/footer');
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
		$kode_supplier = $this->session->userdata('username');
		$no_rcv = $this->input->post('no_rcv');
		$no_faktur = $this->input->post('no_faktur');
		$faktur_pajak = $this->input->post('fak_pjk');
		$no_faktur_pajak = $this->input->post('no_fak_pjk');
		$tagihan = $this->input->post('tagihan');

		$tagihan = str_replace(['Rp', '.', ' '], '', $tagihan);
		$tagihan = str_replace(',', '.', $tagihan);

		$csv = $_FILES['csv']['name'];

		$this->load->model('RcvModel');
		$this->load->model('FakturModel');

		$totalHargaRcv    = $this->RcvModel->total_tgh_rcv($no_rcv)->row();
		$totalHargaFaktur = $this->FakturModel->total_jml_fak($no_rcv)->row();

		$totalRcv = $totalHargaRcv->jml_tgh;
		$totalFaktur = $totalHargaFaktur->total_fak + $tagihan;

		// $selisihFakRcv = $totalRcv - $totalFaktur;
		// if($totalFaktur > $totalRcv){
		// 	echo "total rcv : ".$totalRcv;
		// 	echo "<br>";
		// 	echo "total faktur : ".$totalFaktur;
		// 	echo "<br>";
		// 	echo "Total harga faktur yang anda masukkan sudah melebihi total harga di reiceiving";
		// }else{
		// 	echo "total rcv : ".$totalRcv;
		// 	echo "<br>";
		// 	echo "total faktur : ".$totalFaktur;
		// 	echo "<br>";
		// 	echo "Total faktur yang anda masukkan sesuai rcv";
		// }

		// die;

		// var_dump($selisihFakRcv);
		// var_dump($totalRcv); die;
		// var_dump($totalFaktur); die;
		// var_dump($no_faktur); die;


		// cek validasi data duplikat pada nomor faktur supplier
		// $sql = "";
		$sqlCekFaktur  = $this->db2->query("SELECT fak_pjk FROM tb_faktur WHERE fak_pjk = '$faktur_pajak'");

		// var_dump($sqlCekFaktur); die;
		// $sqlCekBarcode = $this->db2->query("SELECT fak_pjk FROM tb_faktur WHERE fak_pjk = '$faktur_pajak'");
		$cek = $sqlCekFaktur->num_rows();

		// var_dump($cek); die;
		// $cek2 = $sqlCekBarcode->num_rows();
		// var_dump($totalHargaFaktur->total_fak);
		// var_dump($totalHargaRcv->jml_tgh);
		// die;


		// var_dump($totalFaktur);
		// var_dump($totalRcv);
		//  die;


		if ($cek > 0) {
			$this->session->set_flashdata('message', '<div class="alert alert-warning alert-dismissible  fade show" role="alert">
			<strong>url barcode faktur pajak sudah pernah digunakan</strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
			</div>');
			redirect('admin/faktur/index/' . $no_rcv);
			// $data = [
			// 	'status'  => 200,
			// 	'error'   => false,
			// 	'message' => "success get data",
			// 	'results' => "<p class='text-danger'>no receiving sudah ada, silahkan ganti dengan yang lain</p>"
			// ];
			// echo json_encode($data);

		} else {
			if ($csv = '') {
			} else {
				$config['upload_path'] = './assets/csv';
				$config['allowed_types'] = 'csv';
				$this->load->library('upload', $config);

				if (!$this->upload->do_upload('csv')) {
					echo "File gagal di upload";
				} else {
					$csv = $this->upload->data('file_name');


					$pecahCsv = array_map('str_getcsv', file(base_url() . '/assets/csv/' . $csv));

					// echo "<pre>";
					// echo print_r($pecahCsv);
					// die;
					// echo "</pre>";

					$cek = '';
					$no = 1;
					$total = 0;
					$sum = 0;
					$data = [];

					foreach ($pecahCsv as $key => $values) {
						// echo print_r(array_sum($values[11])); die;
						// var_dump($values[11]); die;
						// total di csv
						$total += (int) $values[11];


						$cekCount = count($values);
						// var_dump($cekCount);die;


						if ($key > 0) {
							if ($cekCount == 12) {
								$data[] = [
									'no_rcv' => $no_rcv,
									'fak_supp' => $no_faktur,
									'kode_supp' => $kode_supplier,
									'barcode' => $values[5],
									'nama_brg' => $values[6],
									'qty' => $values[7],
									'harga' => $values[8],
									'disc' => $values[9],
									'ppn' => $values[10],
									'total' => $values[11]
								];


								// $detailCsv = "REPLACE INTO csv_detail (fak_supp, kode_supp, nama_brg, qty, harga, disc, ppn) values('$no_faktur','$kode_supplier','$values[6]','$values[7]','$values[8]','$values[9]','$values[10]')";

								// $result = $this->db2->query($detailCsv);

								// var_dump($result);

								// echo "<pre>";
								// echo print_r($result);
								// echo "</pre>";
								// die;
								// $cek = $no++;

								// die

								// var_dump($data); die;
							}
						}

						// if(){

						// }
					}


					// selisih tagihan di faktur pajak di kurang dengan total di csv

					$selisih = $tagihan - $total;

					// var_dump($values[1]); die;


					// var_dump(abs($selisih)); die;
					if (abs($selisih) <= 300) {
						// var_dump($totalHargaRcv); 
						// var_dump($totalHargaFaktur); die;   						
						foreach ($data as $dt) {
							// print_r($dt); die;
							// var_dump($values[1]); die;
							if ($no_faktur !== $values[1]) {
								echo "no faktur supplier anda tidak sesuai dengan file di csv";
							}else{
								$this->db2->insert('csv_detail', $dt);
							}								
							
						}
					} else {
						// print_r('selisih');
						$this->session->set_flashdata('message', '<div class="alert alert-warning alert-dismissible  fade show" role="alert">
						<strong>file csv anda tidak sesuai dengan total tagihan faktur pajak</strong>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
						</div>');
						redirect('admin/faktur/index/' . $no_rcv);
					}

					// print_r($data);
					// print_r($total);
					// die;

					// $pecahFile  = $pecahCsv[1][0];
					// $pecahFile1 = $pecahCsv[1][1];


					// $ccv = count($pecahCsv);
					// $nama_brg = $pecahCsv[1][6];
					// $qty = $pecahCsv[1][7];
					// $hrg = $pecahCsv[1][8];
					// $disc = $pecahCsv[1][9];
					// $ppn = $pecahCsv[1][10];
					// $total = $pecahCsv[1][11];

				}
			}



			$data = array(
				'no_rcv' => $no_rcv,
				'no_faktur' => $no_faktur,
				'fak_pjk' => $faktur_pajak,
				'no_fak_pjk' => $no_faktur_pajak,
				'tagihan' => $tagihan,
				'csv' => $csv
			);

			// $selisihRcvFak = $totalFaktur - $totalRcv;
			// var_dump($values[1]); 
			// var_dump($selisihRcvFak);
			// var_dump($totalFaktur);
			// var_dump($totalRcv);
			// die;
		    // var_dump($no_faktur); die;
				// echo "faktur supp file csv :".var_dump($values[1]); die;
			if ($no_faktur !== $values[1]) {
				
				$this->session->set_flashdata('message', '<div class="alert alert-warning alert-dismissible  fade show" role="alert">
									<strong>no faktur supplier anda tidak sesuai dengan file di csv</strong>
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									   <span aria-hidden="true">&times;</span>
									</button>
								  </div>');
				redirect('admin/faktur/index/' . $no_rcv);
			} else {
				if ($totalFaktur > $totalRcv) {
					// var_dump($totalFaktur);
					// var_dump($totalRcv); die;
					$this->session->set_flashdata('message', '<div class="alert alert-warning alert-dismissible  fade show" role="alert">
									<strong>Total harga faktur yang anda masukkan sudah melebihi total harga di reiceiving</strong>
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									   <span aria-hidden="true">&times;</span>
									</button>
								  </div>');
					redirect('admin/faktur/index/' . $no_rcv);
				} else {
					$this->bttModel->insert_faktur($data, 'tb_faktur');
					$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible  fade show" role="alert">
									<strong>Data Berhasil ditambahkan !</strong>
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									  <span aria-hidden="true">&times;</span>
									</button>
									</div>');

					redirect('admin/faktur/index/' . $no_rcv);
				}
			}



			// var_dump($totalFaktur);
			// var_dump($totalRcv); die;

			// $this->bttModel->insert_faktur($data, 'tb_faktur');
			// $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible  fade show" role="alert">
			// 				<strong>Data Berhasil ditambahkan !</strong>
			// 				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			// 				  <span aria-hidden="true">&times;</span>
			// 				</button>
			// 				</div>');

			// redirect('admin/faktur/index/' . $no_rcv);
		}
	}


	public function pecahCsv($string)
	{
		$data = array();

		// Splits
		$rows = explode("\n", trim($string));
		$headings = explode(',', array_shift($rows));
		foreach ($rows as $row) {
			// The substr removes " from start and end
			$data_fields = explode('","', trim(substr($row, 1, -1)));

			if (count($data_fields) == count($headings)) {
				$data[] = array_combine($headings, $data_fields);
			}
		}

		return $data;
	}



	public function validateFakturSupplier()
	{

		$no_faktur    = $this->input->post('no_faktur');


		$cekFakturSupplier = $this->bttModel->cekFakturSupplier($no_faktur);


		if ($cekFakturSupplier > 0) {
			$data = [
				'status'  => 200,
				'error'   => false,
				'message' => "success get data",
				'results' => "<p class='text-danger'>no. faktur supplier sudah ada, silahkan ganti dengan yang lain</p>"
			];
			echo json_encode($data);
		}
	}

	public function validateNofakturPajak()
	{
		$no_faktur_pajak = $this->input->post('no_fak_pjk');

		$cekScanQrcode = $this->bttModel->cekScanQrcode($no_faktur_pajak);

		if ($cekScanQrcode > 0) {
			$data = [
				'status'  => 200,
				'error'   => false,
				'message' => "success get data",
				'results' => "<p class='text-danger'>nomor faktur pajak sudah digunakan</p>"
			];
			echo json_encode($data);
		}
	}

	public function hapus_faktur($id, $no_rcv, $no_fak_supp)
	{
		$faktur = $this->bttModel->hapusDataFaktur($id, $no_rcv);
		// $data['no_rcv'] = $no_receiving;
		if($faktur){
			$this->db2->delete('csv_detail', array('fak_supp' => $no_fak_supp));
		}

		$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible  fade show" role="alert">
		<strong>Data Berhasil di hapus!</strong>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		</div>');
		redirect(base_url('admin/faktur/index/' . $no_rcv));
	}

	public function checkqrcode()
	{
		$url = $this->input->post('link');
		$cek = $this->db2->query("SELECT fak_pjk FROM tb_faktur WHERE fak_pjk = '$url'")->result_array();
		$hitung = count($cek);

		if ($hitung == 0) {
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
			// curl_setopt($curl, CURLOPT_HTTPHEADER, $key_load);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			// EXECUTE:
			$result = curl_exec($curl);
			curl_close($curl);
			$data = simplexml_load_string($result);


			if ($data->body . '0' == "No service was found.0") {
				echo json_encode($data->body . '0' == "No service was found.0");
			} else {
				$faktur = $data->nomorFaktur;
				$total = $data->jumlahDpp + $data->jumlahPpn;

				$data = [
					'no_faktur' => $faktur . "0",
					'total' => $total
				];
				echo json_encode($data);
			}
		} else {
			echo json_encode(array("ada"));
		}



		// die;

		// $cek = $this->db->query("SELECT * from tb_faktur WHERE fak_pjk ='$url'")->result_array();

		// $hitung = count($cek);

		// if ($hitung == 0) {
		// 	$curl = curl_init();
		// 	curl_setopt($curl, CURLOPT_URL, $url);
		// 	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		// 	// curl_setopt($curl, CURLOPT_HTTPHEADER, $key_load);
		// 	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		// 	// EXECUTE:
		// 	$result = curl_exec($curl);

		// 	if (!$result) {
		// 		echo json_encode(array("fail"));
		// 	} else {
		// 		curl_close($curl);
		// 		$data = simplexml_load_string($result);
		// 		$total = $data->jumlahDpp + $data->jumlahPpn;
		// 		$faktur = $data->nomorFaktur;

		// 		if ($total > 0) {
		// 			echo json_encode(array("success", $data->jumlahDpp + $data->jumlahPpnm, $faktur));
		// 		} else {
		// 			echo json_encode(array("err"));
		// 		}
		// 	}
		// } else {
		// 	echo json_encode(array("ada"));
		// }
	}

	public function updateStatus($no_btt, $no_rcv)
	{
		// var_dump($no_btt);
		// var_dump($no_rcv); 
		// die;
		$result = $this->FakturModel->updateStatus($no_btt);
		if ($result) {
			redirect('admin/btt/index');
		} else {
			redirect('admin/faktur/index/' . $no_rcv);
		}
	}

	public function edit_Faktur()
	{
		$kode_supplier = $this->session->userdata('username');
		$id_faktur = $this->input->post('id_faktur');
		$no_rcv = $this->input->post('no_rcv');
		$no_faktur = $this->input->post('no_faktur');
		$faktur_pajak = $this->input->post('fak_pjk');
		$no_faktur_pajak = $this->input->post('no_fak_pjk');
		$tagihan = $this->input->post('tagihan');

		$tagihan = str_replace(['Rp', '.', ' '], '', $tagihan);
		$tagihan = str_replace(',', '.', $tagihan);

		$csv = $_FILES['csv']['name'];


		$this->load->model('RcvModel');
		$this->load->model('FakturModel');

		$totalHargaRcv    = $this->RcvModel->total_tgh_rcv($no_rcv)->row();
		$totalHargaFaktur = $this->FakturModel->total_jml_fak($no_rcv)->row();

		$totalRcv = $totalHargaRcv->jml_tgh;
		$totalFaktur = $totalHargaFaktur->total_fak;

		if ($csv) {
			$config['upload_path']   = './assets/csv';
			$config['allowed_types'] = 'csv';
			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('csv')) {
				// $csv = $this->upload->data('file_name');

				// $this->db2->set('csv', $csv);
				// echo $this->upload->display_errors();

				echo "File gagal di upload";
			} else {
				$csv = $this->upload->data('file_name');

				$pecahCsv = array_map('str_getcsv', file(base_url() . '/assets/csv/' . $csv));
				// var_dump($pecahCsv);

				// var_dump($pecahCsv); die;
				$cek = '';
				$no = 1;
				$total = 0;
				$sum = 0;
				$data = [];

				foreach ($pecahCsv as $key => $values) {

					$total += (int) $values[11];


					$cekCount = count($values);


					if ($key > 0) {
						if ($cekCount == 12) {
							$data[] = [
								'no_rcv' => $no_rcv,
								'fak_supp' => $no_faktur,
								'kode_supp' => $kode_supplier,
								'barcode' => $values[5],
								'nama_brg' => $values[6],
								'qty' => $values[7],
								'harga' => $values[8],
								'disc' => $values[9],
								'ppn' => $values[10],
								'total' => $values[11]
							];


							// $detailCsv = "REPLACE INTO csv_detail (fak_supp, kode_supp, nama_brg, qty, harga, disc, ppn) values('$no_faktur','$kode_supplier','$values[6]','$values[7]','$values[8]','$values[9]','$values[10]')";

							// $result = $this->db2->query($detailCsv);

							// var_dump($data); die;

							// echo "<pre>";
							// echo print_r($result);
							// echo "</pre>";
							// die;
							// $cek = $no++;

							// die
						}
					}
				}

				// selisih tagihan di faktur pajak di kurang dengan total di csv

				$selisih = $tagihan - $total;

				// var_dump(abs($selisih)); die;
				if (abs($selisih) <= 300) {
					// var_dump($totalHargaFaktur); die;   
					// foreach ($data as $dt) {
					// print_r($dt); die; 
					$delete = $this->db2->delete('csv_detail', array('no_rcv' => $no_rcv));

					if ($delete) {
						foreach ($data as $dt) {
							$this->db2->insert('csv_detail', $dt);
						}
					}
					// }
				} else {
					// print_r('selisih');
					$this->session->set_flashdata('message', '<div class="alert alert-warning alert-dismissible  fade show" role="alert">
					<strong>file csv anda tidak sesuai dengan total tagihan faktur pajak</strong>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
					</div>');
					redirect('admin/faktur/index/' . $no_rcv);
				}
			}
		}


		$data = array(
			'no_rcv' => $no_rcv,
			'no_faktur' => $no_faktur,
			'fak_pjk' => $faktur_pajak,
			'no_fak_pjk' => $no_faktur_pajak,
			'tagihan' => (float)$tagihan,
			'csv' => $csv
		);

		// var_dump($data); die;

		$where = array(
			'id_faktur' => $id_faktur
		);

		// var_dump($where); die;

		if ($no_faktur != $values[1]) {
			$this->session->set_flashdata('message', '<div class="alert alert-warning alert-dismissible  fade show" role="alert">
									<strong>no faktur supplier anda tidak sesuai dengan file di csv</strong>
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									   <span aria-hidden="true">&times;</span>
									</button>
								  </div>');
			redirect('admin/faktur/index/' . $no_rcv);
		} else {
			if ($totalFaktur > $totalRcv) {
				$this->session->set_flashdata('message', '<div class="alert alert-warning alert-dismissible  fade show" role="alert">
									<strong>Total harga faktur yang anda masukkan sudah melebihi total harga di reiceiving</strong>
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									   <span aria-hidden="true">&times;</span>
									</button>
								  </div>');
				redirect('admin/faktur/index/' . $no_rcv);
			} else {
				// var_dump($data);
				// var_dump($where); die;
				$this->bttModel->edit_faktur($data, $where);
				$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible  fade show" role="alert">
				<strong>Data Berhasil diubah!</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				</div>');

				redirect('admin/faktur/index/' . $no_rcv);
			}
		}
	}



	public function _rules()
	{
		$this->form_validation->set_rules('no_faktur', 'no_faktur', 'required');
		$this->form_validation->set_rules('fak_pjk', 'fak_pjk', 'required');
		$this->form_validation->set_rules('tagihan', 'tagihan', 'required');
		$this->form_validation->set_rules('csv', 'csv', 'required');
	}
}
