<?php

class Idemp9Model extends CI_model
{

    function __construct()
    {
        parent::__construct();
        //load our second db
        $this->db3 = $this->load->database('database3', true);
    }

    public function getOrderHeader($pono)
    {
        $sql = "SELECT pono, podate, suppcode, suppname, totpurchase from mv_suz_order_header_v msohv where pono = '$pono'";
        $result = $this->db3->query($sql);

        return $result;
    }
}
