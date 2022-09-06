<?php

defined('BASEPATH') or exit('No direct script access allowed');


class ProsesBanding extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        checklogin();
        $this->db2 = $this->load->database('database2', TRUE);
        // $this->load->model('FakturModel');
    }

    public function rcv_vs_erp()
    {
        //ambil data dari btt
        $bttt = "SELECT no_btt,create_at FROM tb_nobtt WHERE status='confirm'";
        $resultBttt = $this->db2->query($bttt)->result_array();
        // var_dump($resultBttt); die;
        
        foreach($resultBttt as $valBtt ){
            $create_at = $valBtt['create_at'];
            // mengambil no bttt dari dari tabel tb_nobtt
            $bttt = "SELECT * FROM tb_nobtt where no_btt = '$valBtt[no_btt]'";
            $resultBtt = $this->db2->query($bttt)->result_array();
            // var_dump($resultBtt); die;
            foreach($resultBtt as $value){
                 $queryBtt   = "SELECT ";
                 $resultBtt1 = $this->db2->query($queryBtt);
                 if($resultBtt1){
                    
                 }
            }    
        }
    }
}
