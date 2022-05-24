<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
    }

    public function send_message()
    {
        if ($this->input->post()) {
            $data = json_decode(file_get_contents('php://input'), true);
            $sender = $data['sender'];
            $nomor = $data['number'];
            $pesan = $data['message'];
            $key = $data['api_key'];
            header('Content-Type: application/json');

            if (!isset($nomor) && !isset($pesan) && !isset($sender) && !isset($key)) {
                $ret['status'] = false;
                $ret['msg'] = "Parameter salah!";
                echo json_encode($ret, true);
                exit;
            }

            $cek = $this->db->get_where('account', ['api_key' => $key]);
            if ($cek->num_rows() == 0) {
                $ret['status'] = false;
                $ret['msg'] = "Api Key salah/tidak ditemukan!";
                echo json_encode($ret, true);
                exit;
            }
            $id_users = $cek->row()->id;
            $cek2 = $this->db->get_where('device', ['nomor' => $sender, 'pemilik' => $id_users]);
            if ($cek2->num_rows() == 0) {
                $ret['status'] = false;
                $ret['msg'] = "Api Key salah/tidak ditemukan!";
                echo json_encode($ret, true);
                exit;
            }
            $res = sendMSG($nomor, $pesan, $sender);
            if ($res['status'] == "true") {
                $ret['status'] = true;
                $ret['msg'] = "Pesan berhasil dikirim";
                echo json_encode($ret, true);
                exit;
            } else {
                $ret['status'] = false;
                $ret['msg'] = $res['message'];
                echo json_encode($ret, true);
                exit;
            }
        }
    }

    public function send_media()
    {
        if ($this->input->post()) {
            // Takes raw data from the request
            $data = json_decode(file_get_contents('php://input'), true);
            $sender = $data['sender'];
            $nomor = $data['number'];
            $caption = $data['message'];
            //$filetype = $data['filetype'];
            $key = $data['api_key'];
            $url = $data['url'];
            header('Content-Type: application/json');


            if (!isset($nomor) ||  !isset($sender) || !isset($key)  || !isset($url)) {
                $ret['status'] = false;
                $ret['msg'] = "Parameter salah!";
                echo json_encode($ret, true);
                exit;
            }

            $a = explode('/', $url);
            $filename = $a[count($a) - 1];
            $a2 = explode('.', $filename);
            $namefile = $a2[count($a2) - 2];
            $ext = $a2[count($a2) - 1];

            if ($ext != 'jpg' && $ext != 'pdf') {
                $ret['status'] = false;
                $ret['msg'] = "Hanya support jpg dan pdf";
                echo json_encode($ret, true);
                exit;
            }

            $cek = $this->db->get_where('account', ['api_key' => $key]);
            if ($cek->num_rows() == 0) {
                $ret['status'] = false;
                $ret['msg'] = "Api Key salah/tidak ditemukan!";
                echo json_encode($ret, true);
                exit;
            }
            $id_users = $cek->row()->id;
            $cek2 = $this->db->get_where('device', ['nomor' => $sender, 'pemilik' => $id_users]);
            if ($cek2->num_rows() == 0) {
                $ret['status'] = false;
                $ret['msg'] = "Api Key salah/tidak ditemukan!";
                echo json_encode($ret, true);
                exit;
            }
            $res = sendMedia($nomor, $caption, $sender, $ext, $namefile, $url);
            if ($res['status'] == "true") {
                $ret['status'] = true;
                $ret['msg'] = "Pesan berhasil dikirim";
                echo json_encode($ret, true);
                exit;
            } else {
                $ret['status'] = false;
                $ret['msg'] = $res['message'];
                echo json_encode($ret, true);
                exit;
            }
        }
    }

    public function send_button()
    {
        if ($this->input->post()) {
            $data = json_decode(file_get_contents('php://input'), true);
            $sender = $data['sender'];
            $nomor = $data['number'];
            $pesan = $data['message'];
            $footer = $data['footer'];
            $button1 = $data['button1'];
            $button2 = $data['button2'];
            $key = $data['api_key'];
            header('Content-Type: application/json');

            if (!isset($nomor) && !isset($pesan) && !isset($sender) && !isset($key) && !isset($button1) && !isset($button2)) {
                $ret['status'] = false;
                $ret['msg'] = "Parameter salah!";
                echo json_encode($ret, true);
                exit;
            }

            $cek = $this->db->get_where('account', ['api_key' => $key]);
            if ($cek->num_rows() == 0) {
                $ret['status'] = false;
                $ret['msg'] = "Api Key salah/tidak ditemukan!";
                echo json_encode($ret, true);
                exit;
            }
            $id_users = $cek->row()->id;
            $cek2 = $this->db->get_where('device', ['nomor' => $sender, 'pemilik' => $id_users]);
            if ($cek2->num_rows() == 0) {
                $ret['status'] = false;
                $ret['msg'] = "Api Key salah/tidak ditemukan!";
                echo json_encode($ret, true);
                exit;
            }
            $res = sendBTN($nomor, $sender, $pesan, $footer, $button1, $button2);
            if ($res['status'] == "true") {
                $ret['status'] = true;
                $ret['msg'] = "Pesan berhasil dikirim";
                echo json_encode($ret, true);
                exit;
            } else {
                $ret['status'] = false;
                $ret['msg'] = $res['message'];
                echo json_encode($ret, true);
                exit;
            }
        }
    }

    public function get_contacts()
    {
        header('content-type: application/json');
        $data = json_decode(file_get_contents('php://input'), true);
        $sender =  preg_replace("/\D/", "", $data['id']);
        foreach ($data['data'] as $d) {
			$number = str_replace("@s.whatsapp.net","",$d['id']);
			$nama = $d['name'];
            $pp = $d['pp'];
            $cek = $this->db->get_where('all_contacts', ['sender' => $sender, 'number' => $number]);
            if ($cek->num_rows() == 0) {
                $insert = $this->db->query("INSERT INTO all_contacts VALUES(null,'$sender','$number','$nama','Personal', '$pp')");
            }
        }
    }

    public function get_groups()
    {
        header('content-type: application/json');
        $data = json_decode(file_get_contents('php://input'), true);
        $user_id =  preg_replace("/\D/", "", $data['id']);

        // return $this->output
        //     ->set_content_type('application/json')
        //     ->set_status_header(200)
        //     ->set_output(json_encode($data));
        foreach ($data['data'] as $d) {
            $id_group = $d['id'];
            $nama = str_replace("'", "", $d['name']);
            $nama = (string) $nama;
            $pp = $d['pp'];
            $cek = $this->db->get_where('group_wa', ['user_id' => $user_id, 'id_group' => $id_group]);
            if ($cek->num_rows() == 0) {
                $insert = $this->db->query("INSERT INTO group_wa VALUES(null, '$id_group', '$user_id', '$nama', '$pp')");
            }
        }
    }
}
