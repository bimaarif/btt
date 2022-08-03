<?php
defined('BASEPATH') or exit('No direct script access allowed');

class tambah_receiving extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('idempModel');
	}

	public function index()
	{
		$db2 = $this->load->database('database2', TRUE);
		$data['receiving'] = $this->bttModel->get_receiving('tb_rcv')->result();
		// $data['receiving'] = $db2->query('SELECT no_rcv, jml_tgh FROM tb_rcv JOIN tb_faktur ON (tb_rcv.id_rcv = tb_faktur.id_rcv)')->result();
		$this->load->view('templates_admin/header');
		$this->load->view('templates_admin/sidebar');
		$this->load->view('admin/tambah_receiving', $data);
		$this->load->view('templates_admin/footer');
	}

	public function inputFaktur($id)
	{
		$db2 = $this->load->database('database2', TRUE);
		$where = array('id_receiving' => $id);
		$data['faktur'] = $db2->query("SELECT no_rcv, jml_tgh FROM tb_rcv JOIN tb_faktur ON (tb_rcv.id_rcv = tb_faktur.id_rcv)")->result();
		$this->load->view('templates_admin/header');
		$this->load->view('templates_admin/sidebar');
		$this->load->view('templates_admin/form_faktur');
		$this->load->view('templates_admin/footer');
	}


	public function insert_receiving()
	{
		$this->_rules();

		if ($this->form_validation->run() == false) {
			$this->index();
		} else {
			$receiving     = $this->input->post('no_rcv');
			$total_tagihan = $this->input->post('jml_tgh');

			$tagihan = str_replace(['Rp', '.', ' '], '', $total_tagihan);
			$tagihan = str_replace(',', '.', $tagihan);

			$data = array(
				'no_rcv' => $receiving,
				'jml_tgh' => (float)$tagihan
			);

			$this->bttModel->insert_receiving($data, 'tb_rcv');

			//   var_dump($simpan); die;

			redirect('admin/tambah_receiving');
		}
	}

	public function rcvHeader()
	{


		$no_rcv = $this->input->post('no_rcv');
		$check_no_receiving = $this->Idemp9Model->getRcvHeader($no_rcv);

		if ($no_rcv != null) {
			if ($check_no_receiving) {
				echo "<div class='text-red'>no receiving sudah ada, silahkan ganti dengan yang lain</div>";
			} else {
				echo "<div class='text-green'>no receiving ada</div>";
			}
		}
	}

	public function validateRCV()
	{

		try {

			$no_rcv = $this->input->post('norcv');

			$resultLocal = $this->bttModel->getByNoRCV($no_rcv);

			if ($resultLocal > 0) {
				$data = [
					'status'  => 200,
					'error'   => false,
					'message' => "success get data",
					'results' => "<p class='text-danger'>no receiving sudah ada, silahkan ganti dengan yang lain</p>"
				];
				echo json_encode($data);
			} else {
				$data = [
					'status'  => 404,
					'error'   => false,
					'message' => "Data Not Found"
				];
				echo json_encode($data);
				// var_dump('hai');die;
				// $resultIdemp9 = $this->bttModel->getRcvHeader($no_rcv);
				// echo json_encode($resultIdemp9);
				// die;
				// if ($resultIdemp9) {
				// 	$data = [
				// 		'status'  => 200,
				// 		'error'   => false,
				// 		'message' => "success get data recieving",
				// 		'results' => $resultIdemp9
				// 	];
				// 	echo json_encode($data);
				// } else {
				// 	$data = [
				// 		'status'  => 404,
				// 		'error'   => false,
				// 		'message' => "Data Not Found",
				// 		'results' => "<div class='text-red'>no receiving tidak ada, silahkan check kembali no receiving anda</div>"
				// 	];
				// 	echo json_encode($data);
				// }
			}
		} catch (Exception $e) {
			$data = [
				'status'  => 6500,
				'error'   => true,
				'message' => $e
			];
			echo json_encode($data);
		} catch (Throwable $th) {
			$data = [
				'status'  => 500,
				'error'   => true,
				'message' => $th
			];
			echo json_encode($data);
		}
	}

	public function _rules()
	{
		$this->form_validation->set_rules('no_rcv', 'no_rcv', 'required');
		$this->form_validation->set_rules('jml_tgh', 'jml_tgh', 'required');
	}
}
