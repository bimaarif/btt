<?php

defined('BASEPATH') or exit('No direct script access allowed');


class ProsesKlaim extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // checklogin();
        $this->db2 = $this->load->database('database2', TRUE);
        $this->db3 = $this->load->database('database3', TRUE);

        // $this->load->model('FakturModel');
    }

    public function Claim(){
        try {
            $header = "SELECT * FROM tb_nobtt";
            $resultHeader = $this->db2->query($header)->result_array();

            $mostRecent = 0;
            $indays = 0;

            // var_dump($resultHeader); die;

            foreach($resultHeader as $valHeader){
               $no_btt = $valHeader['no_btt'];
               $rcvDetail = "SELECT tgl_rcv, topindays FROM tb_rcv WHERE no_btt ='$no_btt'";
               $resultDetail = $this->db2->query($rcvDetail)->result_array();
               
               foreach($resultDetail as $valueDetail){
                //    var_dump($valueDetail['tgl_rcv']);
                  $tanggal = $valueDetail['tgl_rcv'];

                  if($tanggal > $mostRecent){
                    $mostRecent = $tanggal;
                    $indays = $valueDetail['topindays'];
                  }
               }
            }

               $most = strtotime($mostRecent);
               $temp = strtotime("+$indays day", $most);
               $temp = date('Y-m-d', $temp);

               var_dump($temp); die;



        } catch (\Throwable $th) {
            echo "Error: " . $th->getMessage();
        }
    }
}    