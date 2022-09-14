<?php

class FakturModel extends CI_model
{
    protected $db2;

    function __construct()
    {
        parent::__construct();
        //load our second db
        $this->db2 = $this->load->database('database2', true);
    }

    public function updateStatus($no_btt)
    {
        $sql = "UPDATE tb_nobtt SET status = 'Unconfirm' WHERE no_btt = '$no_btt'";
        $result = $this->db2->query($sql);
        return $result;
    }

    public function validasiQrcode($no_faktur){
        $sql = "SELECT fak_pjk FROM tb_faktur WHERE no_faktur = '$no_faktur'";
        $result = $this->db2->query($sql);
        return $result;
    }

    public function total_jml_fak($no_rcv){
        $sql = "SELECT SUM(tagihan) as total_fak FROM tb_faktur WHERE no_rcv = '$no_rcv'";
        $result = $this->db2->query($sql);
        return $result;
    } 
}
