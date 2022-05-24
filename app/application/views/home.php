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
                                    <h2>Dashboard</h2>
                                </div>
                            </div>
                        </div>
                        <?php require('layouts/alert.php') ?>
                        <div class="row">
                            <div class="col-xl-4">
                                <div class="card widget widget-stats">
                                    <div class="card-body">
                                        <div class="widget-stats-container d-flex">
                                            <div class="widget-stats-icon widget-stats-icon-primary">
                                                <i class="material-icons-outlined">contacts</i>
                                            </div>
                                            <div class="widget-stats-content flex-fill">
                                                <span class="widget-stats-title">Contacts Number</span>
                                                <span class="widget-stats-amount"><?= $contacts ?></span>
                                                <span>Nomor tersimpan.</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="card widget widget-stats">
                                    <div class="card-body">
                                        <div class="widget-stats-container d-flex">
                                            <div class="widget-stats-icon widget-stats-icon-warning">
                                                <i class="material-icons-outlined">phone_iphone</i>
                                            </div>
                                            <div class="widget-stats-content flex-fill">
                                                <span class="widget-stats-title">Devices</span>
                                                <span class="widget-stats-amount"><?= $device->num_rows() ?></span>
                                                <span>Device terdaftar.</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="card widget widget-stats">
                                    <div class="card-body">
                                        <div class="widget-stats-container d-flex">
                                            <div class="widget-stats-icon widget-stats-icon-info">
                                                <i class="material-icons-outlined">pending_actions</i>
                                            </div>
                                            <div class="widget-stats-content flex-fill">
                                                <span class="widget-stats-title">Pesan Jadwal</span>
                                                <span class=""><small>Pending : <?= $pending ?> <br> Gagal : <?= $gagal ?> <br> Terkirim : <?= $terkirim ?></small></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="card">
                                    <div class="card-body">
                                        <h5>Devices</h5>
                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#devices"><i class="material-icons">add</i>Add New Device</button>
                                        <table id="datatable1" class="display text-center" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Number</th>
                                                    <th>Status</th>
                                                    <th>#</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($device->result() as $d) : ?>
                                                    <tr>
                                                        <td><?= $d->nomor ?></td>
                                                        <td>
                                                             <?php if($d->status == 'Disconnected') : ?>  
                                                            '<div class="badge badge-danger">
                                                              Disconnected from whatsapp
                                                            </div> 

                                                        <?php else : ?>

                                                            <div class="badge badge-success">
                                                              Connected in whatsapp
                                                            </div>

                                                        <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <a href="<?= base_url('device/') . $d->nomor ?>" class="btn btn-primary btn-burger"><i class="material-icons">qr_code_scanner</i></a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="devices" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Device</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post">
                    <div class="modal-body">
                        <label class="form-label">Nomor</label>
                        <input type="number" name="nomor" class="form-control" required placeholder="62xxxx">
                        <label class="form-label">Webhook Url</label>
                        <input type="text" name="webhook" class="form-control" autocomplete="off">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Javascripts -->
    <?php require_once('layouts/footer.php') ?>
    
    <script>
        $('#datatable1').DataTable({
            "scrollY": "300px",
            "scrollCollapse": true,
            "paging": false,
            "searching": false
        });
    </script>
</body>

</html>