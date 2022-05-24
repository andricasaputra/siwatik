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
                                    <h2>Auto Responder (BOT)</h2>
                                </div>
                            </div>
                        </div>
                        <?php require('layouts/alert.php') ?>

                        <div class="row">
                            <div class="col">
                                <div class="card">
                                    <div class="card-body">
                                        <h5>Devices</h5>
                                        <div class="text-end mb-3">
                                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add"><i class="material-icons">add</i>Tambah</button>
                                        </div>
                                        <table id="datatable1" class="display" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Sender</th>
                                                    <th>Keyword</th>
                                                    <th>Response</th>
                                                    <th>Media</th>
                                                    <th>#</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($respon->result() as $d) : ?>
                                                    <tr>
                                                        <td></td>
                                                        <td><?= $d->nomor ?></td>
                                                        <td><small><?= $d->keyword ?></small></td>
                                                        <td><small><?= $d->response ?></small></td>
                                                        <td><?= ($d->media == '') ? '<button class="btn btn-secondary btn-sm" disabled>None</button>' : '<button class="btn btn-primary btn-sm" onclick="lihat_gambar(`' . $d->media . '`)">Lihat</button>' ?></td>
                                                        <td><a href="<?= base_url('autoresponder/del/') . $d->id ?>" type="button" class="btn btn-danger btn-sm"><i class="material-icons">delete_outline</i>Delete</a> </td>
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
    <div class="modal fade" id="add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Device</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post">
                    <div class="modal-body">
                        <label class="form-label">Nomor</label>
                        <select name="device" class="form-select" required>
                            <?php foreach ($device->result() as $d) : ?>
                                <option value="<?= $d->nomor ?>"><?= $d->nomor ?></option>
                            <?php endforeach ?>
                        </select>
                        <label class="form-label">Keyword</label>
                        <input type="text" class="form-control" name="keyword" placeholder="ex: /help" autocomplete="off" required>
                        <label class="form-label">Response</label>
                        <textarea class="form-control" name="response" autocomplete="off" required></textarea>
                        <?= _uploadMedia() ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="lihatm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Media</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center" id="preview_lihat">

                </div>
            </div>
        </div>
    </div>
    <!-- Javascripts -->

    <?php require_once('layouts/footer.php') ?>
    
    <script>
        $('#datatable1').DataTable({
            responsive: true,
            // "lengthChange": false
        });
    </script>
    <?php require_once("include_file.php") ?>
</body>

</html>