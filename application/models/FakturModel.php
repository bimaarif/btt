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
}
