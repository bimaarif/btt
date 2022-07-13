<?php

class loginModel extends CI_model
{

    public function cek_login()
    {
        $username = set_value('username');
        $password = sha1(set_value('password'));
       

        $result = $this->db->where('username', $username)
                           ->where('password', $password)
                           ->limit(1)
                           ->get('users');


        return $result;                    
        // var_dump($result->row());
        // die;                       

        // if($result->num_rows() > 0){
        //     // var_dump($result->row());
        //     return $result->row();
        // }else{
        //     return FALSE;
        // }


    }
}
