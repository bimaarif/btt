<?php

function checklog(){
  $CI = &get_instance();
  $level = $CI->session->userdata('username');
  if (!empty($level)) {
  	redirect('admin/tambah_btt');
  }
}

function checklogin(){
  $CI = &get_instance();
  $level = $CI->session->userdata('username');
  if (empty($level)) {
  	redirect('login');
  }
}
