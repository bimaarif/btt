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



    public function insert_faktur($data, $table)
    {

        $simpan = $this->db2->insert($table, $data);
        return $simpan;
    }

    public function hapusDataFaktur($id)
    {
        $delete = $this->db2->delete('tb_faktur', ['id_faktur' => $id]);
        return $delete;
    }


    public function insert_receiving($data)
    {
        $no_fak = $data['no_rcv'];
        $jml_tagihan = $data['jml_tgh'];

        // $data = array(
        //     'no_rcv' => $no_fak,
        //     'jml_tgh' => $jml_tagihan
        // );

        // var_dump($data); die;

        $sql = "INSERT INTO tb_rcv(no_rcv,jml_tgh)values('$no_fak','$jml_tagihan')";
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

    public function createCode()
    {
        $batas = date('Ym') . '.' . date('dHis');
        $kodetampil = "BTTT" . '.' . $batas;
        return $kodetampil;
    }
}
