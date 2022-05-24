<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CNKWA :: <?= $title ?></title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">
    <link href="<?= _assets() ?>/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= _assets() ?>/plugins/perfectscroll/perfect-scrollbar.css" rel="stylesheet">
    <link href="<?= _assets() ?>/plugins/pace/pace.css" rel="stylesheet">
    <link href="<?= _assets() ?>/plugins/select2/css/select2.min.css" rel="stylesheet">
    <link href="<?= _assets() ?>/css/main.min.css" rel="stylesheet">
    <link href="<?= _assets() ?>/css/custom.css" rel="stylesheet">
    <link href="<?= _assets() ?>/plugins/highlight/styles/github-gist.css" rel="stylesheet">
</head>

<body>
    <div class="app align-content-stretch d-flex flex-wrap">

        <div class="app-sidebar">
            <div class="logo">
                <a href="#" class="logo-icon" style="background: url(<?= _assets('images/velixs.png') ?>) no-repeat; background-position: center center;background-size: 35px;"><span class="logo-text">CNKWA</span></a>
                <div class="sidebar-user-switcher user-activity-online">
                    <a href="#">
                        <img src="<?= _assets() ?>/images/avatars/avatar.gif">
                        <span class="activity-indicator"></span>
                        <span class="user-info-text"><?= $user->username ?><br><span class="user-state-info">CNKWA</span></span>
                    </a>
                </div>
            </div>
            <div class="app-menu">
                <ul class="accordion-menu">
                    <li class="sidebar-title">
                        Home
                    </li>
                    <li>
                        <a href="<?= base_url('home') ?>" class="active"><i class="material-icons-two-tone">dashboard</i>Dashboard</a>
                    </li>
                    <li class="sidebar-title">
                        Main Fitur
                    </li>
                    <li>
                        <a href="<?= base_url('autoresponder') ?>" class="active"><i class="material-icons-two-tone">message</i>Auto Responder</a>
                    </li>
                    <li>
                        <a href="<?= base_url('contacts') ?>" class="active"><i class="material-icons-two-tone">contacts</i>Contacts/Number</a>
                    </li>
                    <li>
                        <a href="<?= base_url('blast') ?>" class="active"><i class="material-icons-two-tone">question_answer</i>WA Blast</a>
                    </li>
                    <li>
                        <a href="<?= base_url('schedule') ?>" class="active"><i class="material-icons-two-tone">schedule</i>Pesan Terjadwal</a>
                    </li>
                    <li>
                        <a href="<?= base_url('send') ?>" class="active"><i class="material-icons-two-tone">send</i>Test Sender</a>
                    </li>
                    <!-- <li>
                        <a href="<?= base_url('broadcast') ?>" class="active"><i class="material-icons-two-tone">quickreply</i>Broadcast</a>
                    </li> -->
                    <li class="sidebar-title">
                        Other
                    </li>
                    <li class="active-page">
                        <a href="<?= base_url('api') ?>" class="active"><i class="material-icons-two-tone">api</i>Rest Api</a>
                    </li>
                    <li>
                        <a href="<?= base_url('settings') ?>" class="active"><i class="material-icons-two-tone">settings</i>Settings</a>
                    </li>
                    <li>
                        <a href="<?= base_url('logout') ?>" class="active"><i class="material-icons-two-tone">logout</i>Logout</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="app-container">
            <div class="app-header">
                <nav class="navbar navbar-light navbar-expand-lg">
                    <div class="container-fluid">
                        <div class="navbar-nav" id="navbarNav">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link hide-sidebar-toggle-button" href="#"><i class="material-icons">first_page</i></a>
                                </li>
                                <li class="nav-item dropdown hidden-on-mobile">
                                    <a class="nav-link dropdown-toggle" href="#" id="addDropdownLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="material-icons">add</i>
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="addDropdownLink">
                                        <li><a class="dropdown-item" href="#">Broadcast</a></li>
                                        <li><a class="dropdown-item" href="#">WA Blast</a></li>
                                        <li><a class="dropdown-item" href="#">Auto Responder</a></li>
                                    </ul>
                                </li>
                            </ul>

                        </div>
                        <div class="d-flex">
                            <ul class="navbar-nav">

                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
            <div class="app-content">
                <div class="content-wrapper">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <div class="page-description p-0">
                                    <h2>API</h2>
                                </div>
                            </div>
                        </div>
                        <?= _alert() ?>
                        <div class="card">
                            <div class="card-body">
                                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#p-text" type="button" role="tab" aria-controls="" aria-selected=" true">Pesan Text</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#p-media" type="button" role="tab" aria-controls="" aria-selected="false">Pesan Media</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#p-tombol" type="button" role="tab" aria-controls="" aria-selected="false">Pesan Button</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#webhooksss" type="button" role="tab" aria-controls="" aria-selected="false">Webhook</button>
                                    </li>
                                </ul>

                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="p-text" role="tabpanel" aria-labelledby="pills-home-tab">
                                        <br>
                                        <div class="example-container">
                                            <div class="example-code">
                                                <pre><code class="php">$data = [
    'api_key' => '<?= $user->api_key ?>',
    'sender'  => 'Nomor pengirim (pastikan sudah scan)',
    'number'  => 'Nomor tujuan kirim pesan',
    'message' => 'Pesan nya'
];

$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "<?= base_url('api/send-message') ?>",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => json_encode($data))
);

$response = curl_exec($curl);

curl_close($curl);
echo $response;
                                                </code></pre>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="p-media" role="tabpanel" aria-labelledby="pills-profile-tab">
                                        <br>
                                        <div class="example-container">
                                            <div class="example-code">
                                                <pre><code class="php">$data = [
    'api_key' => '<?= $user->api_key ?>',
    'sender'  => 'nomor sender (Pastikan sudah scan)',
    'number'  => 'nomor tujuan kirim pesan',
    'message' => 'caption ( isi jika kirim gambar)',
    
    'url' => 'Link gambar/pdf'
];

$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "<?= base_url('api/send-media') ?>",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => json_encode($data))
);

$response = curl_exec($curl);

curl_close($curl);
echo $response;
                                                </code></pre>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="p-tombol" role="tabpanel" aria-labelledby="pills-contact-tab">
                                        <br>
                                        <div class="example-container">
                                            <div class="example-code">
                                                <pre><code class="php">$data = [
    'api_key' => '<?= $user->api_key ?>',
    'sender'  => 'nomor sender (Pastikan sudah scan)',
    'number'  => 'nomor tujuan kirim pesan',
    'message' => 'pesan',
    'footer' => 'pesan di bawah button',
    'button1' => 'nama tombol pertama',
    'button2' => 'nama tombol kedua',
];

$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "<?= base_url('api/send-button') ?>",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => json_encode($data))
);

$response = curl_exec($curl);

curl_close($curl);
echo $response;
                                                </code></pre>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="webhooksss" role="tabpanel" aria-labelledby="pills-contact-tab">
                                        <br>
                                        <div class="example-container">
                                            <div class="example-code">
                                                <pre><code class="php">header('content-type: application/json');
$data = json_decode(file_get_contents('php://input'), true);
file_put_contents('whatsapp.txt', '[' . date('Y-m-d H:i:s') . "]\n" . json_encode($data) . "\n\n", FILE_APPEND);
$message = $data['message']; // ini menangkap pesan masuk
$from = $data['from']; // ini menangkap nomor pengirim pesan


if (strtolower($message) == 'hai') {
    $result = [
        'mode' => 'chat', // mode chat = chat biasa
        'pesan' => 'Hai juga'
    ];
} else if (strtolower($message) == 'hallo') {
    $result = [
        'mode' => 'reply', // mode reply = reply pessan
        'pesan' => 'Halo juga'
    ];
} else if (strtolower($message) == 'gambar') {
    $result = [
        'mode' => 'picture', // type picture = kirim pesan gambar
        'data' => [
            'caption' => '*webhook picture*',
            'url' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRZ2Ox4zgP799q86H56GbPMNWAdQQrfIWD-Mw&usqp=CAU'
        ]
    ];
}

print json_encode($result);
                                                </code></pre>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Javascripts -->
    <script src="<?= _assets() ?>/plugins/jquery/jquery-3.5.1.min.js"></script>
    <script src="<?= _assets() ?>/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?= _assets() ?>/plugins/perfectscroll/perfect-scrollbar.min.js"></script>
    <script src="<?= _assets() ?>/plugins/pace/pace.min.js"></script>
    <script src="<?= _assets() ?>/plugins/select2/js/select2.full.min.js"></script>
    <script src="<?= _assets() ?>/plugins/highlight/highlight.pack.js"></script>
    <script src="<?= _assets() ?>/js/main.min.js"></script>
    <script src="<?= _assets() ?>/js/custom.js"></script>
    <script>
        $('select').select2();
    </script>
    <?php require_once('include_file.php') ?>
</body>

</html>