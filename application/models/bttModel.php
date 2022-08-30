<?php

class bttModel extends CI_model
{

    function __construct()
    {
        parent::__construct();
        //load our second db
        $this->db2 = $this->load->database('database2', true);
        $this->db3 = $this->load->database('database3', true);
    }

    public function getCounter($supplierKode){
        $sql = "SELECT counter FROM tb_counter WHERE supplier = '$supplierKode'";

        $tampil = $this->db2->query($sql)->result_array();
        // var_dump($tampil);die;
        $data = null;
        $hitung = count($tampil);
        if($hitung > 0 ){
            $counter = $tampil[0]['counter'] + 1;
            $data = "UPDATE tb_counter SET counter = '$counter' WHERE supplier = '$supplierKode'";
        }else{
            $counter = 1;
            $data = "INSERT INTO tb_counter (supplier, counter) VALUES('$supplierKode','1')";
        }
        // var_dump($data);die;
        $simpan = $this->db2->query($data);
        // var_dump($simpan);
        return $counter;
    }

    // create kode
    public function createCode()
    {   
        $kodeSuplier = $this->session->userdata('username');
        
        $counter = $this->getCounter($kodeSuplier);
        // var_dump($kode_supplier); die;

        $a = 6;
        $b = strlen($counter);
        $c = $a - $b;
        $d = '';

        for ($i=0; $i < $c; $i++) { 
            $d .='0';
        }

        $counter = $d.$counter;
        $batas = date('Ym');
        $kodetampil = "BTTT" . '.' . $batas.'.'.$counter;
        return $kodetampil;
    }

    public function insertData($data)
    {
        $no_fak = $data['no_faktur'];
        $faktur_tagihan = $data['fak_pjk'];
        $tagihan = $data['tagihan'];
        $csv = $data['csv'];


        $sql = "Insert into tb_faktur (no_faktur, fak_pjk, tagihan, csv) Values ('$no_fak','$faktur_tagihan', '$tagihan','$csv')";
        $simpan = $this->db2->query($sql);

        return $simpan;
    }

    public function get_receiving($table)
    {

        $tampil = $this->db2->get($table);

        return $tampil;
    }


    public function getByNoRCV($no_rcv)
    {
        $sql = "SELECT no_rcv, jml_tgh FROM tb_rcv WHERE no_rcv = '$no_rcv'";
        $result = $this->db2->query($sql);
        return $result->num_rows();
    }

    public function getByNoFaktur($no_faktur, $faktur_pajak)
    {
        $sql = "SELECT no_faktur, fak_pjk, tagihan, csv FROM tb_faktur WHERE no_faktur = '$no_faktur' AND fak_pjk = '$faktur_pajak'";
        $result = $this->db2->query($sql);
        return $result->num_rows();
    }

    public function getRcvHeader($no_rcv)
    {
        var_dump($no_rcv);
        $sql = "SELECT * from mv_suz_receiving_header_v msrhv where rcvno = '$no_rcv'";
        $result = $this->db3->query($sql)->result_array();
        return $result;
    }



    public function get_faktur($table)
    {

        $tampil = $this->db2->get($table);

        return $tampil;
    }

    public function cekFakturSupplier($no_faktur){
        $sql = "SELECT no_faktur FROM tb_faktur WHERE no_faktur = '$no_faktur'";
        $result = $this->db2->query($sql);
        return $result->num_rows();
    }

    public function cekScanQrcode($faktur_pajak){
        $sql = "SELECT fak_pjk FROM tb_faktur WHERE fak_pjk = '$faktur_pajak'";
        $result = $this->db2->query($sql);
        return $result->num_rows();
    }


    public function insert_faktur($data, $table)
    {
        $simpan = $this->db2->insert($table, $data);
        return $simpan;
    }

    public function hapusDataFaktur($id, $no_rcv)
    {
        $delete = $this->db2->delete('tb_faktur', ['id_faktur' => $id, 'no_rcv' => $no_rcv]);
        return $delete;
    }


    public function insert_receiving($data)
    {
        $no_fak = $data['no_rcv'];
        $jml_tagihan = $data['jml_tgh'];
        $tgl_rcv = $data['tgl_rcv'];
        $no_btt = $data['no_btt'];

        // $data = array(
        //     'no_rcv' => $no_fak,
        //     'jml_tgh' => $jml_tagihan
        // );

        // var_dump($data); die;

        $sql = "INSERT INTO tb_rcv(no_btt,no_rcv,jml_tgh,tgl_rcv)values('$no_btt','$no_fak','$jml_tagihan',' $tgl_rcv')";
        $simpan = $this->db2->query($sql);

        return $simpan;
    }

    public function insert_faktur1($data)
    {
        $no_faktur = $data['no_faktur'];
        $fak_pjk = $data['fak_pjk'];
        $tagihan = $data['tagihan'];
        $csv = $data['csv'];


        $sql = "INSERT INTO tb_rcv(no_faktur,fak_pjk,tagihan,csv)values('$no_faktur','$fak_pjk','$tagihan','$csv')";
        $simpan = $this->db2->query($sql);

        return $simpan;
    }

    public function getDataFakturCount($dari, $sampai)
    {

        if ($dari != "") {
            $this->db->where('no_faktur >', $dari);
        }

        if ($sampai != "") {
            $this->db->where('no_faktur <', $dari);
        }

        $this->db->select('tb_faktur.no_faktur,tb_faktur.fak_pjk,tb_faktur.tagihan,tb_faktur.csv');
        $this->db->from('tb_faktur');
        return $this->db->get();
    }

    public function insert_nobtt($data, $table)
    {
        $simpan = $this->db2->insert($table, $data);
        return $simpan;
    }

    public function get_nobtt($table)
    {
        $tampil = $this->db2->get($table);
        return $tampil;
    }

    public function noRcv($no_btt)
    {
        $query = "SELECT * FROM tb_rcv WHERE tb_rcv.no_btt = '$no_btt'";

        $result = $this->db2->query($query);

        return $result;
    }

    public function noFaktur($no_rcv)
    {
        $query = "SELECT * FROM tb_faktur WHERE tb_faktur.no_rcv = '$no_rcv'";

        $result = $this->db2->query($query);

        return $result;
    }

    public function cekFaktur($no_rcv)
    {
        $query = "SELECT tb_rcv.no_btt,  tb_rcv.no_rcv, tb_faktur.no_faktur,  tb_faktur.fak_pjk, tb_faktur.tagihan, tb_faktur.csv 
                  FROM tb_rcv LEFT JOIN tb_faktur ON tb_faktur.no_rcv = tb_rcv.no_rcv 
                  WHERE tb_rcv.no_rcv = '$no_rcv'";

        $result = $this->db2->query($query);

        return $result;
    }

    public function cekRcv($no_btt)
    {
        $query = "SELECT tb_nobtt.no_btt, tb_rcv.no_rcv, tb_rcv.jml_tgh
                  FROM tb_nobtt
                  LEFT JOIN tb_rcv ON tb_rcv.no_btt = tb_nobtt.no_btt
                  WHERE tb_nobtt.no_btt = '$no_btt'";

        $result = $this->db2->query($query);

        return $result;
    }

    public function updateConfirm($no_btt, $status)
    {
        $sql = "UPDATE tb_nobtt SET status = '$status' WHERE no_btt = '$no_btt'";
        $result = $this->db2->query($sql);
        return $result;
    }

    public function cetak($no_btt)
    {
        // var_dump($no_btt); die;
        $query = "SELECT tb_faktur.no_fak_pjk, tb_faktur.no_faktur,tb_rcv.tgl_rcv, tb_faktur.tagihan 
                  FROM tb_rcv LEFT JOIN tb_faktur ON tb_faktur.no_rcv = tb_rcv.no_rcv 
                  WHERE tb_rcv.no_btt = '$no_btt'";
        $result = $this->db2->query($query)->result_array();
        
        return $result;
    }

    public function getTotal($no_btt)
    {
        $query = "SELECT SUM(tb_faktur.tagihan) AS tot_tagihan
                  FROM tb_rcv LEFT JOIN tb_faktur ON tb_faktur.no_rcv = tb_rcv.no_rcv 
                  WHERE tb_rcv.no_btt = '$no_btt'";
        $result = $this->db2->query($query)->result_array();                                                                                                                                                                                                                                                   
        return $result[0];
    }
}
