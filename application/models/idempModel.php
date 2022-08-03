<?php

class idempModel extends CI_model
{
    protected $db3;

    function __construct()
    {
        parent::__construct();
        //load our second db
        $this->db3 = $this->load->database('database3', true);
    }

    public function getRcvHeader($no_rcv)
    {
        $sql = "SELECT * from mv_suz_receiving_header_v msrhv where rcvno = '2003.RC.2202.027142'";
        $result = $this->db3->query($sql)->result_array();
        echo $result;
        die;
        return $result;
    }

    public function indexGetRcv()
    {
        $sql = "SELECT rcvno, pono, rcvdate, totalrcv from mv_suz_receiving_header_v limit 10";
        $result = $this->db3->query($sql)->result_array();
        return $result;
    }
}
