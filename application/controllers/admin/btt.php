<?php

defined('BASEPATH') or exit('No direct script access allowed');

class btt extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        checklogin();
    }

    public function index()
    {
        $kode_btt = $this->bttModel->createCode();
        $data['kode_btt'] = $kode_btt;
        $data['tampil_btt'] = $this->bttModel->get_nobtt('tb_nobtt')->result();
        $this->load->view('templates_admin/header');
        $this->load->view('templates_admin/sidebar');
        $this->load->view('admin/view_btt', $data);
        $this->load->view('templates_admin/footer');
    }

    public function inputKode()
    {   
        $kodeSuplier = $this->session->userdata('username');
        
        $counter = $this->bttModel->getCounter($kodeSuplier);
        // var_dump($kode_supplier); die;

        $a = 6;
        $b = strlen($counter);
        $c = $a - $b;
        $d = '';

        for ($i=0; $i < $c; $i++) { 
            $d .='0';
        }

        $counter = $d.$counter;

        $date = date('Ym');
        $kodetampil = "BTTT" . '.' . $date .'.'.$counter;
        // $tgl_btt = date('dmy');
        $data['no_btt'] = $kodetampil;

        $this->bttModel->insert_nobtt($data, 'tb_nobtt');

        redirect('admin/btt');
    }

    public function getDataPrint($no_btt)
    {
        $resultData = $this->bttModel->cetak($no_btt);
        $resultTotal = $this->bttModel->getTotal($no_btt);

        //  var_dump($resultData);
        //  var_dump($resultTotal);
        //  var_dump($no_btt); die;
        
        // var_dump($printPdf); die;
        if ($resultData && $resultTotal) {

            //   var_dump($resultData);
            //   var_dump($resultTotal);
            //   var_dump($no_btt); die;
            $printPdf = $this->printPdf($resultData, $resultTotal, $no_btt);

            // var_dump($printPdf); die;
            // return $printPdf;
            // var_dump($printPdf); die;

            if ($printPdf) {
                $data = [
                    'status' => 200,
                    'message' => 'Success'
                ];
            //    var_dump($printPdf); die;
            } else {
                $data = [
                    'status' => 400,
                    'message' => 'Failed'
                ];
            }
            // echo json_encode($data);
        } else {
            $data = [
                'status' => 400,
                'message' => 'Failed'
            ];
            echo json_encode($data);
        }
    }

    public function printPdf($resultData, $resultTotal, $no_btt)
    {

        // $no = 1;
        // // $this->load->helper('szy');
        // // require('./application/helpers/viewpref.php');
        // $pdf = new FPDF('P', 'mm', 'A4');
        // $pdf->Open();
        // $pdf->AddPage('P', 'A4');
        // $pdf->SetFont('Arial','B',16);
        // $pdf->SetMargins(12, 10, 12);
        // $pdf->SetAutoPageBreak(true, 14);

        // echo json_encode($resultData);

        // // $pdf->Output();
        // ob_start();
        $no = 1;
        $user = $this->session->userdata('fullname');
        $newdate = date("d/m/Y");
        $crt = date("d/m/Y");
        $hitung = 1;
        $num = "Lembar";

        $this->load->library('Pdf');

        error_reporting(0); // AGAR ERROR MASALAH VERSI PHP TIDAK MUNCUL
        $pdf = new FPDF('P', 'mm', 'A4');
        $pdf->Open();
        $pdf->AddPage();
        $pdf->SetMargins(12, 10, 12);
        $pdf->SetAutoPageBreak(true, 14);


        $pdf->SetTitle('FORM-BTT-' . $no_btt);
        $pdf->SetFillColor(232, 232, 232);
        $pdf->SetFont('Arial', 'UB', 12);
        // $pdf->Image(base_url() . 'assets/uploads/images/szy.png', 10, 20, 45, 10);
        $pdf->SetX(75);
        $pdf->Cell(120, 10, 'BUKTI TANDA TERIMA TAGIHAN', 0, 0, 'L');
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 8);

        $pdf->SetX(90);
        $pdf->Cell(10, 0, 'No BTTT : ' . $no_btt, 5, 0, 'B');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Ln(2);
        $pdf->Ln(2);
        $pdf->Ln(2);
        $pdf->Ln(2);
        $pdf->Ln(2);
        $pdf->Ln(2);
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetX(20);
        $pdf->Cell(23, 5, 'Telah diterima sebanyak   : ' . $hitung . ' (' . $num . ')' . ' lembar Faktur Tagihan', 0, 0, 'L');
        $pdf->Ln();
        $pdf->SetX(20);
        $pdf->Cell(120, 10, 'Atas Nama                         : ' . $user, 0, 0, 'L');
        $pdf->Ln();
        $pdf->SetX(20);
        $pdf->Cell(120, 5, 'Total Tagihan                     : ' . 'Rp.' . number_format($resultTotal['tot_tagihan']), 0, 0, 'L');
        $pdf->Ln();
        $pdf->Ln();
        $pdf->SetX(20);
        $pdf->Cell(120, 5, 'Yang Akan Dibayar Dengan ', 0, 0, 'L');
        $pdf->SetX(65);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(120, 5, 'GIRO/CEK/UANG TUNAI', 0, 0, 'L');
        $pdf->SetX(107);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(120, 5, 'dan dapat diambil pada tanggal ' . $newdate, 0, 0, 'L');
        $pdf->Ln();
        $pdf->SetX(40);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(120, 10, 'Perincian Tagihan', 0, 0, 'C');
        $pdf->Ln();

        $pdf->SetX(10);
        $pdf->SetFont('Arial', 'b', 10);
        $pdf->SetX(8);
        $pdf->Cell(10, 7, 'No', 1, 0, 'C', true);
        $pdf->Cell(50, 7, 'No Faktur Pajak', 1, 0, 'C', true);
        $pdf->Cell(50, 7, 'No Faktur', 1, 0, 'C', true);
        $pdf->Cell(25, 7, 'Tgl', 1, 0, 'C', true);
        $pdf->Cell(60, 7, 'Jumlah Tagihan', 1, 0, 'C', true);

        $pdf->Ln();

        foreach ($resultData as $value) {
            $pdf->SetX(8);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(10, 7, $no, 1, 0, 'C');
            $pdf->Cell(50, 7, $value['no_fak_pjk'], 1, 0, 'C');
            $pdf->Cell(50, 7, $value['no_faktur'], 1, 0, 'C');
            $pdf->Cell(25, 7, date("d-m-y", strtotime($value['tgl_rcv'])), 1, 0, 'C');
            $pdf->Cell(60, 7, "Rp. " . number_format($value['tagihan']), 1, 0, 'C');
            $no++;
            $pdf->Ln();
        }


        $pdf->SetX(8);
        $pdf->Cell(135, 7, 'Jumlah Tagihan', 1, 0, 'L', true);
        $pdf->Cell(60, 7, 'Rp.' . number_format($resultTotal['tot_tagihan']), 1, 0, 'C', true);
        $pdf->Ln(10);
        $pdf->SetX(8);


        $pdf->Cell(20, 10, 'Perhatian: Penagihan Giro/Cek/uang Tunai Pada Hari Jumat ,Pada Jam:13.00-16.00 ', 0, 0, 'L');


        $pdf->Ln();
        $pdf->SetX(170);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(20, 10, 'Medan, ' . $crt, 0, 0, 'L');

        // return $pdf->Output('BTTT_Report.pdf','D');
        $pdf->Output('BTTT_Report.pdf','I');
        // ob_end_flush();
        // $pdf->Output();
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

   

    public function updateConfirm($no_btt, $status = null)
    {

        if ($status == "Confirm") {
            $result = $this->bttModel->updateConfirm($no_btt, "Confirm");
            $data = [
                'status' => 200,
                'message' => "Success"
            ];
            echo json_encode($data);
            // if ($result) {
            //     redirect('admin/btt/index');
            // }
        } else {
            $result = $this->bttModel->updateConfirm($no_btt, "Unconfirm");
            $data = [
                'status' => 400,
                'message' => "Failed"
            ];
            $data = [
                'status' => 200,
                'message' => "Success"
            ];
            // if ($result) {
            //     redirect('admin/btt/index');
            // }
        }


        // if ($result) {
        //     redirect('admin/btt/index');
        // }
    }
}
