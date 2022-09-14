<?php

class RcvModel extends CI_model
{
    protected $db2;

    function __construct()
    {
        parent::__construct();
        //load our second db
        $this->db2 = $this->load->database('database2', true);
    }


    public function total_tgh_rcv($no_rcv){
        $sql = "SELECT jml_tgh FROM tb_rcv WHERE no_rcv = '$no_rcv'";
        $result = $this->db2->query($sql);
        return $result;
    } 
}    