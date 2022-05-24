<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Group extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    if (!is_login()) {
      redirect(base_url('login'));
    }
    date_default_timezone_set('Asia/Makassar');
  }

  // contacts groups 
  public function get_groups_page()
  {
  	$id = $this->session->userdata('id_login');

      $data = [
        'title' => 'GROUPS',
        'group_wa' => $this->db->query('SELECT group_wa.*, device.nomor FROM group_wa JOIN device ON group_wa.user_id = device.nomor WHERE device.pemilik = "'.$id.'" '),
        'device' =>  $this->db->get_where('device', ['pemilik' => $id])
      ];
      view('groups', $data);
    
  }

 
}