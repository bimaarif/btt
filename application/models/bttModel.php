<?php

class bttModel extends CI_model{
    public function insertData($data){
    
        $db2 = $this->load->database('database2', TRUE);
        
        $simpan = $db2->insert('tb_btt', $data);

        return $simpan;

        // try {
        //     // var_dump($data);die;
        //     $simpan = $db2->insert('tb_btt', $data);
        //     var_dump($simpan);die;
        // } catch (\Throwable $th) {
        //     var_dump($th);die;
        // }

        //  var_dump($db2);

        // if($simpan){
        //     return 1;
        // }else{
        //     return 0;
        // }
    }
}