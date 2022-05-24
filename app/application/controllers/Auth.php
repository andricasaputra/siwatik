<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Auth extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    date_default_timezone_set('Asia/Jakarta');
  }

  public function index()
  {
    show_404();
  }

  public function login()
  {
    if ($this->input->post()) {
      $username = _POST('username');
      $passworda = md5(_POST('password'));
      $password = _POST('password');
      $rembemr = _POST('remember');
      $query = $this->db->select("*")->where('username', $username,'password',$passworda)->get("account");
      if ($query->num_rows() == 1) {
        $row = $query->row();
        // if (password_verify($password, $row->password)) {
          if ($rembemr == 'on') {
            setcookie('walix_id', $row->id, time() + (10 * 365 * 24 * 60 * 60), '/');
            setcookie('walix_token', hash('ripemd160', $row->password), time() + (10 * 365 * 24 * 60 * 60), '/');
          }
          $this->session->set_userdata(array('id_login' => $row->id, 'status_login' => true));
          redirect(base_url(''));
        // } else {
          // $this->session->set_flashdata('error', 'Password anda salah.');
          // redirect(base_url('login'));
        // }
      } else {
        $this->session->set_flashdata('error', 'Username tidak terdaftar.');
        redirect(base_url('login'));
      }
    } else {
      $this->load->view('login');
      if (is_login(false)) {
        redirect(base_url('home'));
      }
    }
  }

  public function logout()
  {
    $this->session->sess_destroy();
    unset($_COOKIE['walix_token']);
    unset($_COOKIE['walix_id']);
    setcookie('walix_token', NULL, -1, '/');
    setcookie('walix_id', NULL, -1, '/');
    $this->session->set_flashdata('success', 'Account logged out successfully.');
    redirect(base_url("auth/login"));
  }
}
