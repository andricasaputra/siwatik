<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Dashboards extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    if (!is_login()) {
      redirect(base_url('login'));
    }
    
    date_default_timezone_set('Asia/Makassar');
  }

  //device and home

  public function index()
  {
    if ($this->input->post()) {
      $nomor = _POST('nomor');
      $webhook = _POST('webhook');
      if ($this->db->get_where('device', ['nomor' => $nomor])->num_rows() == 0) {
        $this->db->insert('device', [
          'pemilik' => $this->session->userdata('id_login'),
          'nomor' => $nomor,
          'link_webhook' => $webhook,
          'chunk' => 100
        ]);
        $this->session->set_flashdata('success', 'Device berhasil di tambah.');
        redirect(base_url('home'));
      } else {
        $this->session->set_flashdata('error', 'Nomor sudah terdaftar.');
        redirect(base_url('home'));
      }
    } else {
      $data = [
        'title' => 'HOME',
        'device' => $this->db->get_where('device', ['pemilik' => $this->session->userdata('id_login')]),
        'contacts' => $this->db->get_where('nomor', ['make_by' => $this->session->userdata('id_login')])->num_rows(),
        'pending' => $this->db->get_where('pesan', ['status' => 'MENUNGGU JADWAL', 'make_by' => $this->session->userdata('id_login')])->num_rows(),
        'gagal' => $this->db->get_where('pesan', ['status' => 'GAGAL', 'make_by' => $this->session->userdata('id_login')])->num_rows(),
        'terkirim' => $this->db->get_where('pesan', ['status' => 'TERKIRIM', 'make_by' => $this->session->userdata('id_login')])->num_rows()
      ];
      view("home", $data);
    }
  }

  public function device()
  {
    $nomor = htmlspecialchars(str_replace("'", "", $this->uri->segment(2)));
    if ($this->input->post()) {
      $webhook = _POST('webhook');
      $chunk = _POST('chunk');
      $this->db->update('device', ['link_webhook' => $webhook, 'chunk' => $chunk], ['nomor' => $nomor]);
      $this->session->set_flashdata('success', 'Berhasil memperbarui device.');
      redirect(base_url('device/') . $nomor);
    } else {
      $query = $this->db->get_where('device', ['nomor' => $nomor]);
      if ($query->num_rows() != 1) {
        $this->session->set_flashdata('error', 'Device tidak ada.');
        redirect(base_url('home'));
      }
      $data = [
        'title' => 'DEVICE',
        'row' => $query->row(),
        'settings' => $this->db->get_where('settings', ['id' => 1])->row()
      ];
      view('device', $data);
    }
  }

  public function updateStatus()
  {
    $data = $this->db->update('device', [
        'status' => _POST('status')
      ], ['nomor' => $this->uri->segment(3)]);

    $response = [
      'message' => 'success update date',
      'data' => $data
    ];

    return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($response));
  }

  public function device_delete()
  {
    $nomor = htmlspecialchars(str_replace("'", "", $this->uri->segment(3)));
    $this->db->delete('device', ['nomor' => $nomor]);
    $this->session->set_flashdata('success', 'Device berhasil di hapus.');
    redirect(base_url());
  }

  // auto responder
  public function autoresponder()
  {
    if ($this->input->post()) {
      $device = _POST('device');
      $keyword = _POST('keyword');
      $response = _POST('response');
      $media = _POST('media');
      $this->db->insert('autoreply', [
        'keyword' => $keyword,
        'response' => str_replace("&amp;", "&", $response),
        'media' => $media,
        'nomor' => $device,
        'make_by' => $this->session->userdata('id_login')
      ]);
      $this->session->set_flashdata('success', 'Berhasil menambah AutoReplay.');
      redirect(base_url('autoresponder'));
    } else {
      $data = [
        'title' => 'AUTO RESPONDER',
        'respon' => $this->db->get_where('autoreply', ['make_by' => $this->session->userdata('id_login')]),
        'device' =>  $this->db->get_where('device', ['pemilik' => $this->session->userdata('id_login')])
      ];
      view('autoresponder', $data);
    }
  }

  public function autoresponder_del()
  {
    $id = htmlspecialchars(str_replace("'", "", $this->uri->segment(3)));
    $this->db->delete('autoreply', ['id' => $id]);
    $this->session->set_flashdata('success', 'Autoreply berhasil di hapus.');
    redirect(base_url('autoresponder'));
  }

  // contacts number 
  public function contacts()
  {
    if ($this->input->post()) {
      $nama = _POST('nama');
      $nomor = _POST('nomor');
      $label = _POST('label');
      if ($this->db->get_where('nomor', ['nomor' => $nomor])->num_rows() == 0) {
        $this->db->insert('nomor', [
          'nama' => $nama,
          'nomor' => $nomor,
          'label' => $label,
          'make_by' => $this->session->userdata('id_login')
        ]);
        $this->session->set_flashdata('success', 'Berhasil menambah Nomor.');
        redirect(base_url('contacts'));
      } else {
        $this->session->set_flashdata('error', 'Nomer sudah ada.');
        redirect(base_url('contacts'));
      }
    } else {
      $data = [
        'title' => 'CONTACTS',
        'nomor' => $this->db->order_by('nama', 'ASC')->get_where('nomor', ['make_by' => $this->session->userdata('id_login')]),
        'device' =>  $this->db->get_where('device', ['pemilik' => $this->session->userdata('id_login')]),
        'label' => $this->db->query('SELECT * FROM nomor WHERE label!="" GROUP BY label ORDER BY nama ASC')
      ];
      view('contacts', $data);
    }
  }

  public function get_contacts()
  {
    if ($this->input->post()) {

      $device = _POST('device');
      $by = $this->session->userdata('id_login');
      $all_contacts = $this->db->order_by('name', 'ASC')->get_where('all_contacts', ['sender' => $device]);
      foreach ($all_contacts->result() as $c) {
        $a = $this->db->get_where('nomor', ['nomor' => $c->number, 'make_by' => $by]);
        if ($a->num_rows() == 0) {
          $this->db->insert('nomor', [
            'nama' => $c->name,
            'pp' => $c->pp,
            'nomor' => $c->number,
            'label' => '',
            'make_by' => $by
          ]);
        }
      }
      $this->session->set_flashdata('success', 'Berhasil mengambil contacts.');
      redirect(base_url('contacts'));
    }
  }

  public function contacts_del()
  {
    if (isset($_POST['id'])) {
      $id = $_POST['id'];
      $this->db->query("DELETE FROM nomor WHERE id IN(" . implode(",", $id) . ")");
      $this->session->set_flashdata('success', 'Berhasil Hapus nomor yang di checklist.');
      redirect(base_url('contacts'));
    } else {
      $this->session->set_flashdata('error', 'checklist yang ingin di hapus.');
      redirect(base_url('contacts'));
    }
  }

  // wa blast
  public function blast()
  {
    if ($this->input->post()) {
      $device = _POST('device');
      $pesan = _POST('pesan');
      $media = _POST('media');
      if ($this->input->post('all_number')) {
        $arr = [];
        foreach ($this->db->order_by('nama', 'ASC')->get_where('nomor', ['make_by' => $this->session->userdata('id_login')])->result() as $nomor) {
          array_push($arr, $nomor->nomor);
        }
        $target = $arr;
      } else {
        $target = $this->input->post('listnumber');
      }
      foreach ($target as $t) {
        $label = $this->db->order_by('nama', 'ASC')->get_where('nomor', ['label' => $t, 'make_by' => $this->session->userdata('id_login')]);
        if ($label->num_rows() != 0) {
          $nolabel = $label->result();
          foreach ($nolabel as $nl) {

            $qarr = [
              'sender' => $device,
              'tujuan' => $nl->nomor,
              'pesan' => str_replace("{name}", $nl->nama, $pesan),
              'media' => $media,
              'make_by' => $this->session->userdata('id_login')
            ];
            $cek =  $this->db->get_where('blast', $qarr);
            if ($cek->num_rows() == 0) {
              $this->db->insert('blast', $qarr);
            }
          }
        } else {
          $row = $this->db->order_by('nama', 'ASC')->get_where('nomor', ['nomor' => $t, 'make_by' => $this->session->userdata('id_login')])->row();
          $qarr = [
            'sender' => $device,
            'tujuan' => $t,
            'pesan' => str_replace("{name}", $row->nama, $pesan),
            'media' => $media,
            'make_by' => $this->session->userdata('id_login')
          ];
          $cek =  $this->db->get_where('blast', $qarr);
          if ($cek->num_rows() == 0) {
            $this->db->insert('blast', $qarr);
          }
        }
      }
      $res = ['status' => true];
      if ($res['status'] == true) {
        $this->session->set_flashdata('success', 'Kirim pesan berhasil, Status pesan bisa dilihat di tabel bawah halaman ini.');
        redirect(base_url('blast'));
      } else {
        $this->session->set_flashdata('error', 'Scan QR Terlebih dahulu.');
        redirect(base_url('blast'));
      }
    } else {
      $id_login = $this->session->userdata('id_login');
      $data = [
        'title' => 'BLASt',
        'device' =>  $this->db->get_where('device', ['pemilik' => $id_login]),
        'nomor' => $this->db->order_by('nama', 'ASC')->get_where('nomor', ['make_by' => $id_login]),
        'blast' => $this->db->query("SELECT * FROM blast WHERE make_by='$id_login' ORDER BY id DESC"),
        'label' => $this->db->query('SELECT * FROM nomor WHERE label!="" GROUP BY label ORDER BY nama ASC'),
        'groups' => $this->db->query('SELECT * FROM group_wa WHERE user_id="$id_login" ORDER BY nama_group ASC')
      ];
      view('blast', $data);
    }
  }

  public function blast_del()
  {
    if (isset($_POST['id'])) {
      $id = $_POST['id'];
      $this->db->query("DELETE FROM blast WHERE id IN(" . implode(",", $id) . ")");
      $this->session->set_flashdata('success', 'Berhasil Hapus blast yang di checklist.');
      redirect(base_url('blast'));
    } else {
      $this->session->set_flashdata('error', 'checklist yang ingin di hapus.');
      redirect(base_url('blast'));
    }
  }

  public function schedule()
  {
    $id_login = $this->session->userdata('id_login');
    if ($this->input->post()) {
      $pesan = _POST("pesan");
      $sender = _POST("device");
      $jadwal = date("Y-m-d H:i:s", strtotime(_POST("tgl") . " " . _POST("jam")));
      if ($this->input->post('media') == '') {
        $media = null;
      } else {
        $media = $this->input->post('media');
      }

      if ($this->input->post('all_number')) {
        foreach ($this->db->get_where('nomor', ['make_by' => $this->session->userdata('id_login')])->result() as $nomor) {
          $this->db->insert('pesan', [
            'sender' => $sender,
            'nomor' => $nomor->nomor,
            'pesan' => str_replace('{name}', $nomor->nama, $pesan),
            'jadwal' => $jadwal,
            'make_by' => $id_login,
            'media' => $media
          ]);
        }
      } else {
        $target = $this->input->post('target');
        foreach ($target as $t) {
          $label = $this->db->get_where('nomor', ['label' => $t, 'make_by' => $this->session->userdata('id_login')]);
          if ($label->num_rows() != 0) {
            $nolabel = $label->result();
            foreach ($nolabel as $nl) {
              $qarr = [
                'sender' => $sender,
                'nomor' => $nl->nomor,
                'pesan' => str_replace('{name}', $nl->nama, $pesan),
                'jadwal' => $jadwal,
                'make_by' => $id_login,
                'media' => $media
              ];
              $cek =  $this->db->get_where('pesan', $qarr);
              if ($cek->num_rows() == 0) {
                $this->db->insert('pesan', $qarr);
              }
            }
          } else {
            $row = $this->db->get_where('nomor', ['nomor' => $t, 'make_by' => $this->session->userdata('id_login')])->row();
            $qarr = [
              'sender' => $sender,
              'nomor' => $t,
              'pesan' => str_replace('{name}', $row->nama, $pesan),
              'jadwal' => $jadwal,
              'make_by' => $id_login,
              'media' => $media
            ];
            $cek =  $this->db->get_where('pesan', $qarr);
            if ($cek->num_rows() == 0) {
              $this->db->insert('pesan', $qarr);
            }
          }
        }
      }
      $this->session->set_flashdata('success', 'Berhasil submit pesan terjadwal.');
      redirect(base_url('schedule'));
    } else {
      $data = [
        'title' => 'PESAN JADWAL',
        'device' =>  $this->db->get_where('device', ['pemilik' => $id_login]),
        'nomor' => $this->db->get_where('nomor', ['make_by' => $id_login]),
        'pesan' => $this->db->get_where('pesan', ['make_by' => $id_login]),
        'label' => $this->db->query('SELECT * FROM nomor WHERE label!="" GROUP BY label ORDER BY id DESC')
      ];
      view("pesan_jadwal", $data);
    }
  }

  public function schedule_del()
  {
    if (isset($_POST['id'])) {
      $id = $_POST['id'];
      $this->db->query("DELETE FROM pesan WHERE id IN(" . implode(",", $id) . ")");
      $this->session->set_flashdata('success', 'Berhasil Hapus schedule yang di checklist.');
      redirect(base_url('schedule'));
    } else {
      $this->session->set_flashdata('error', 'checklist yang ingin di hapus.');
      redirect(base_url('schedule'));
    }
  }


  public function send()
  {
    if ($this->input->post()) {
      $submitby = $this->input->post('submitby');
      if ($submitby == 'pesan-text') {
        $device = _POST('device');
        $nomor = _POST('nomor');
        $pesan = _POST('pesan');
        $res = sendMSG($nomor, $pesan, $device);

        if ($res['status'] === true) {
          $this->session->set_flashdata('success', 'Pesan text terkirim.');
          redirect(base_url('send'));
        } else {
          $this->session->set_flashdata('error', 'Gagal mengirim pesan dengan error : ' . $res['response']);
          redirect(base_url('send'));
        }
      } else if ($submitby == 'pesan-media') {
        $device = $this->input->post('device');
        $nomor = $this->input->post('nomor');
        $pesan = $this->input->post('pesan');
        $type  = $this->input->post('type');
        $media = $this->input->post('media');
        $a = explode('/', $media);
        $filename = $a[count($a) - 1];
        $a2 = explode('.', $filename);
        $namefile = $a2[count($a2) - 2];
        $filetype = $a2[count($a2) - 1];

        if ($type == "") {

          $getstorage = $this->db->get_where('storage', ['namafile' => $filename])->row();
          $res = sendMedia($nomor, $pesan, $device, $filetype, explode('.', $getstorage->nama_original)[0], $media);

        } else {

          if ($type == 'image') {
            $type = explode(".", $media);
            $type = end($type);

            if ($type != 'png' && $type != 'jpg' && $type != 'jpeg') {
              $type = 'jpg';
            }
          }

          $res = sendMedia($nomor, $pesan, $device, $filetype, $media, $media, $type);
        }

        if ($res['status'] == true) {
          $this->session->set_flashdata('success', 'Pesan media terkirim.');
          redirect(base_url('send'));
        } else {
          $this->session->set_flashdata('error', 'Gagal mengirim pesan dengan error :' . $res['response']);
          redirect(base_url('send'));
        }
      } else if ($submitby == 'pesan-button') {
        $device = $this->input->post('device');
        $nomor = $this->input->post('nomor');
        $pesan = $this->input->post('pesan');
        $footer = $this->input->post('footer');
        $btn1 = $this->input->post('btn1');
        $btn2 = $this->input->post('btn2');
        $res = sendBTN($nomor, $device, $pesan, $footer, $btn1, $btn2);
        if ($res['status'] == true) {
          $this->session->set_flashdata('success', 'Pesan text terkirim.');
          redirect(base_url('send'));
        } else {
          $this->session->set_flashdata('error', 'gagal mengirim pesan dengan error ' . $res['message']);
          redirect(base_url('send'));
        }
      }
    } else {

      $id = $this->session->userdata('id_login');
 
      $data = [
        'title' => 'TEST SEND',
        'device' => $this->db->get_where('device', ['pemilik' => $this->session->userdata('id_login'), 'status' => 'Connected']),
        'contacts' =>  $this->db->query("SELECT all_contacts.*, device.*  FROM all_contacts JOIN device ON all_contacts.sender = device.nomor WHERE device.pemilik = '$id' AND device.status = 'Connected' ORDER BY all_contacts.name ASC"),
        'groups' => $this->db->query('SELECT group_wa.*, device.nomor FROM group_wa JOIN device ON group_wa.user_id = device.nomor WHERE device.pemilik = "'.$id.'" ')
      ];
      // $this->db->get_where('device', ['pemilik' => $this->session->userdata('id_login'), 'status' => 'Connected'])
      view('send', $data);
    }
  }

  // tungu versu 2 nya guys
  public function broadcast()
  {
    $id_login = $this->session->userdata('id_login');
    if ($this->input->post()) {
      $device = $this->input->post('device');
      $pesan = $this->input->post('pesan');
      $media = $this->input->post('media');
      if ($media == '') {
        $filename = '';
        $filetype = '';
      } else {
        $a = explode('/', $media);
        $filename = $a[count($a) - 1];
        $a2 = explode('.', $filename);
        $namefile = $a2[count($a2) - 2];
        $filetype = $a2[count($a2) - 1];
      }
      if ($this->input->post('savebroadcast') == 'on') {
        $this->db->insert('broadcast', [
          'pesan' => $pesan,
          'media' => $media,
          'make_by' => $id_login
        ]);
      }
      SendBC($device, $pesan, $filetype, $filename, $media);
    } else {
      $data = [
        'title' => 'BROADCAST',
        'device' =>  $this->db->get_where('device', ['pemilik' => $id_login]),
        'broadcast' => $this->db->query("SELECT * FROM broadcast WHERE make_by='$id_login' ORDER BY id DESC")
      ];
      view('broadcast', $data);
    }
  }


  public function api()
  {
    $data = [
      'title' => 'API'
    ];
    view('api', $data);
  }

  public function settings()
  {
    if ($this->input->post()) {
      $username = _POST('username');
      $password = md5(_POST('password'));
      $api = $this->input->post('api');
      $chunk = $this->input->post('chunk');
      if ($password == '') {
        $pw = $this->input->post('old_password');
      } else {
        $pw = $password;
      }
      $this->db->update('account', [
        'username' => $username,
        'password' => $pw,
        'api_key' => $api,
        'chunk' => $chunk
      ], ['id' => $this->session->userdata('id_login')]);
      $this->session->set_flashdata('success', 'Account telah di update.');
      redirect(base_url('settings'));
    } else {
      $data = [
        'title' => 'SETTINGS',
        'settings' => $this->db->get_where('settings', ['id' => 1])->row()
      ];
      view('settings', $data);
    }
  }

  public function users()
  {
    $uw = $this->db->get_where('account', ['id' => $this->session->userdata('id_login')])->row();
    if ($uw->level == 2) {
      $this->session->set_flashdata('error', 'Hanyak untuk level admin.');
      redirect(base_url());
    }
    if ($this->input->post()) {
      $username = _POST('username');
      $password = md5(_POST('password'));
      $level = $this->input->post('level');
      $this->db->insert('account', [
        'username' => $username,
        'password' => $password,
        'level' => $level,
        'chunk' => 10,
        'api_key' => md5(date('H:i'))
      ]);
      $this->session->set_flashdata('success', 'Account telah di tambahkan.');
      redirect(base_url('users'));
    } else {
      $data = [
        'title' => 'USERS',
        'users' => $this->db->get('account')
      ];
      view('users', $data);
    }
  }

  public function settings_post()
  {
    if ($this->input->post()) {
      $this->db->update('settings', ['base_node' => $this->input->post('base_node'), 'install_in' => $this->input->post('install_in')], ['id' => 1]);
      $this->session->set_flashdata('success', 'Global settings telah di update.');
      redirect(base_url('settings'));
    }
  }

  public function users_del()
  {
    $uw = $this->db->get_where('account', ['id' => $this->session->userdata('id_login')])->row();
    if ($uw->level == 2) {
      $this->session->set_flashdata('error', 'Hanyak untuk level admin.');
      redirect(base_url());
    }
    $id = $this->uri->segment(3);
    $this->db->delete('account', ['id' => $id]);
    $this->session->set_flashdata('success', 'Account telah di hapus.');
    redirect(base_url('users'));
  }

  // public function __destruct()
  // {
  //   if(isset($_SESSION['success'])){
  //   unset($_SESSION['success']);
  //   }
  //   if(isset($_SESSION['error'])){
  //   unset($_SESSION['error']);
  //   }
  // }
}
