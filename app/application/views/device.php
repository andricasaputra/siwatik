<!DOCTYPE html>
<html lang="en">

<?php require_once('layouts/header.php') ?>

<body>
    <div class="app align-content-stretch d-flex flex-wrap">

         <?php require_once('layouts/sidebar.php') ?>

        <div class="app-container">
            <?php include_once('layouts/navbar.php') ?>
            <div class="app-content">
                <div class="content-wrapper">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <div class="page-description p-0">
                                    <h2>Device</h2>
                                </div>
                            </div>
                        </div>
                        <?php require('layouts/alert.php') ?>
                        <div class="alert alert-info">Scan this QR using whatsapp multi device.</div>
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card widget widget-stats-large">
                                    <div class="row">
                                        <div class="col-xl-8">
                                            <div class="widget-stats-large-chart-container">
                                                <div class="card-header" id="logoutbutton">
                                                    <button onclick="logoutqr()" class="btn btn-danger scanbutton"><i class="material-icons">logout</i>Logout</button>
                                                </div>
                                                <div class="card-body">
                                                    <div id="apex-earnings"></div>
                                                    <div class="imageee text-center mb-3" id="area-image-<?= $row->nomor ?>">
                                                        <!-- <img src="<?= _assets("images/other/whatsapp.png") ?>" height="300px" alt=""> -->
                                                        <h4>Connectiong...</h4>
                                                        <p>Refresh halaman Jika QR Code tidak muncul</p>
                                                    </div>
                                                    <div class="text-center" id="statusss-<?= $row->nomor ?>">
                                                        <button class="btn btn-primary" type="button" disabled>
                                                            <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                                            Menunggu respon dari server
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="widget-stats-large-info-container">
                                                <div class="card-header">
                                                    <h5 class="card-title">Account</h5>
                                                </div>
                                                <div class="card-body account">
                                                    <ul class="list-group account list-group-flush">
                                                        <li class="list-group-item">Nama : <span id="anama-<?= $row->nomor ?>"></span></li>
                                                        <li class="list-group-item">Nomor : <span id="anomor-<?= $row->nomor ?>"><?= $row->nomor ?></span></li>
                                                        <li class="list-group-item">Device : <span id="adevice-<?= $row->nomor ?>"></span></li>
                                                    </ul>
                                                    <div class="text-center mt-4">
                                                        <button type="button" data-bs-toggle="modal" data-bs-target="#webhooks" class="btn btn-primary mb-1"><i class="material-icons">code</i>Settings</button>
                                                        <a href="<?= base_url('device/delete/') . $row->nomor ?>" onclick="logoutqr()" class="btn btn-danger mb-1"><i class="material-icons">delete_outline</i>Remove</a>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="card">
                                    <div class="card-body">
                                        <h6>Logs: </h6>
                                        <span id="logs">

                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="webhooks" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Settings</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post">
                    <div class="modal-body">
                        <label class="form-label">Webhook Url</label>
                        <input type="text" name="webhook" class="form-control" value="<?= $row->link_webhook ?>" autocomplete="off">
                        <br>
                        <label class="form-label">Pengiriman per menit</label>
                        <input type="number" name="chunk" class="form-control" value="<?= $row->chunk ?>" autocomplete="off">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Javascripts -->
   <?php require_once('layouts/footer.php') ?>
    <script src="<?= base_url() ?>../node_modules/socket.io/client-dist/socket.io.js"></script>
    <!-- <script src="https://cdn.socket.io/4.4.1/socket.io.min.js" integrity="sha384-fKnu0iswBIqkjxrhQCTZ7qlLHOFEgNkRmK2vaO/LbTZSXdJfAu6ewRBdwHPhBo/H" crossorigin="anonymous"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/3.1.0/socket.io.js" integrity="sha512-+l9L4lMTFNy3dEglQpprf7jQBhQsQ3/WvOnjaN/+/L4i0jOstgScV0q2TjfvRF4V+ZePMDuZYIQtg5T4MKr+MQ==" crossorigin="anonymous"></script> -->
    <script>
        var nomorbase = <?= $row->nomor ?>

        const updateDeviceStatus = (status) => {
            $.ajax({
                url : "<?=site_url('device/updateStatus/')?>" + nomorbase,
                method : 'POST',
                headers : {
                    'Accept' : 'application/json'
                },
                data : {
                    status : status
                },
                success : function(res) {
                    //console.log(res)
                }
            });
        }

        <?php if ($settings->install_in == 1) { ?>
            var socket = io();
        <?php } else { ?>
            var socket = io('<?= $settings->base_node ?>', {
                transports: ['websocket',
                    'polling',
                    'flashsocket'
                ]
            });
        <?php } ?>

        socket.emit('create-session', {
            id: nomorbase
        });

        socket.on('message', function(msg) {
            $('#logs').append(`+ ` + msg.text + ` <hr class="p-0 m-0">`);
        })

        socket.on('qr', function(src) {
            $(`#area-image-${src.id}`).html(`<img src="` + src.src + `" alt="cardimg" id="qrcode" height="300px">`);
            $(`#statusss-${src.id}`).html(`<button class="btn btn-warning" type="button" disabled><i class="material-icons">qr_code_scanner</i>SCAN QR.</button>`);
        });

        // ketika terhubung
        socket.on('authenticated', function(src) {
            const nomors = src.data.id;
            //  const nomor = src.id
            const nomor = nomors.replace(/\D/g, '');
            $(`#anama-${src.id}`).html(src.data.name)
            $(`#anomor-${src.id}`).html(nomor)
            $(`#adevice-${src.id}`).html('Unknown')
            // $("#logoutbutton").html('')
            $(`#area-image-${src.id}`).html(`<img src="<?= _assets("images/other/whatsapp.png") ?>" alt="cardimg" id="qrcode" height="300px" style="max-height: 100%">`);
            $(`#statusss-${src.id}`).html(`<button disabled class="btn btn-success"><i class="material-icons">done</i>Connected.</button>`);

            updateDeviceStatus('Connected');
        });

        /// function ini untuk logouot
        function logoutqr() {
            socket.emit('logout', {
                id: nomorbase
            });
            $(`#statusss-${src.id}`).html(`Device Logout.<br><a href="" class="btn btn-danger"><i class="material-icons">restart_alt</i>QR SCAN REPEAT.</a>`);

            
            updateDeviceStatus('Disconnected');
        }

        socket.on('isdelete', function(src) {

            updateDeviceStatus('Disconnected');

            $(`#statusss-${src.id}`).html(`Device Logout.<br><a href="" class="btn btn-danger"><i class="material-icons">restart_alt</i>QR SCAN REPEAT.</a>`);
            $(`#area-image-${src.id}`).html(src.text);
        });

        socket.on(`logout-${nomorbase}`, function(data) {

            updateDeviceStatus('Disconnected');

            $(`#statusss-${data.id}`).html(`Device Logout.<br><a href="" class="btn btn-danger"><i class="material-icons">restart_alt</i>Connecting...</a>`);
            $(`#area-image-${data.id}`).html(data.text);
        });

        socket.on('close', function(src) {
            console.log(src);
            $(`#statusss-${src.id}`).html(`<button disabled class="btn btn-danger"><i class="material-icons">error_outline</i>` + src.text + `</button>`);
        });
    </script>

</body>

</html>