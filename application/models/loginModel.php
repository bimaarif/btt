<?php

class loginModel extends CI_model
{

    function __construct()
    {
        parent::__construct();
        //load our second db
        $this->db2 = $this->load->database('database2', true);
    }

    public function cek_login()
    {
       
        $username = set_value('username');
        $password = sha1(set_value('password'));
        
        // $query = "SELECT * from users WHERE username = '$username' AND password = '$password'";

        // var_dump($query); die;

        $result = $this->db2->where('username', $username)
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
