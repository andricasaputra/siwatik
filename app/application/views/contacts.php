<!DOCTYPE html>
<html lang="en">

<?php require_once('layouts/header.php') ?>

<style>
    .form-check-input{
        border: 1px solid  black
    }
</style>

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
                                    <h2>Contacts</h2>
                                </div>
                            </div>
                        </div>
                        <?php require('layouts/alert.php') ?>
                        <form action="<?= base_url('contacts/del') ?>" method="post">
                            <div class="card widget widget-action-list">
                                <div class="card-body text-center">
                                    <button class="btn btn-danger m-1" type="submit"><i class=" material-icons">delete</i>Hapus</button>
                                    <button class="btn btn-primary m-1" type="button" data-bs-toggle="modal" data-bs-target="#generates"><i class="material-icons">contacts</i>Generate Contacts</button>
                                    <button class="btn btn-primary m-1" type="button" data-bs-toggle="modal" data-bs-target="#importexcel"><i class="material-icons">file_upload</i>Import xlsx</button>
                                    <a href="<?= base_url('excel/export') ?>" class="btn btn-warning m-1"><i class="material-icons">download</i>Export xlsx</a>
                                    <button class="btn btn-primary m-1" type="button" data-bs-toggle="modal" data-bs-target="#add"><i class="material-icons">add</i>Tambah</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5>Contacts Nomor</h5>
                                            <table id="datatable1" class="display text-center" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th><input class="form-check-input" onchange="checkAll(this)" name="chk[]" type="checkbox"></th>
                                                        <th>Foto</th>
                                                        <th>Name</th>
                                                        <th>Nomor</th>
                                                        <th>Label</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($nomor->result() as $d) : ?>
                                                        <tr>
                                                            <td><input class="form-check-input" name="id[]" value="<?= $d->id ?>" type="checkbox"></td>
                                                            <td>
                                                                <?php if($d->pp == 'blank.png') : ?>

                                                                    <img class="rounded-circle" src="<?= _assets("images/other/user.png") ?>" height="50" alt="">

                                                                <?php else: ?>

                                                                    <img class="rounded-circle" src="<?= $d->pp ?>" height="50" alt="">

                                                                <?php endif; ?>
                                                            </td>
                                                            
                                                            <td><?= $d->nama ?></td>
                                                            <td><?= $d->nomor ?></td>
                                                            <td><small class="btn btn-primary btn-style-light btn-sm"><i class="material-icons">label</i> <?= $d->label ?></small></td>
                                                        </tr>
                                                    <?php endforeach ?>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

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
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Nomor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post">
                    <div class="modal-body">
                        <label class="form-label">Nama</label>
                        <input type="text" name="nama" class="form-control" required>
                        <label class="form-label">Nomor</label>
                        <input type="number" name="nomor" class="form-control" required placeholder="62xxxx">
                        <label class="form-label">Label</label>
                        <input type="text" name="label" list="lab" class="form-control" autocomplete="off">
                        <datalist id="lab">
                            <?php foreach ($label->result() as $r) : ?>
                                <option value="<?= $r->label ?>"><?= $r->label ?></option>
                            <?php endforeach ?>
                        </datalist>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="importexcel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import xlsx</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= base_url("excel/import") ?>" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="mb-1">
                            <label for="formFile" class="form-label">File Excel <small style="font-size: 9px;">(.xlsx)</small></label>
                            <input class="form-control" type="file" name="file" id="formFile" required />
                        </div>
                        <div class="text-center">
                            <a class="btn btn-primary btn-sm me-1" data-bs-toggle="collapse" href="#advance" role="button" aria-expanded="false" aria-controls="collapseExample">
                                Advance
                            </a>
                        </div>
                        <div class="collapse" id="advance">
                            <div class="mb-1">
                                <label class="form-label" for="basicInput">Mulai Dari baris</label>
                                <input type="text" name="a" class="form-control" id="basicInput" value="2" required />
                            </div>
                            <div class="mb-1">
                                <label class="form-label" for="basicInput">Kolom Nama ke</label>
                                <input type="text" name="b" class="form-control" id="basicInput" value="1" required />
                            </div>
                            <div class="mb-1">
                                <label class="form-label" for="basicInput">Kolom Nomor ke</label>
                                <input type="text" name="c" class="form-control" id="basicInput" value="2" required />
                            </div>
                            <div class="mb-1">
                                <label class="form-label" for="basicInput">Kolom Label ke</label>
                                <input type="text" name="d" class="form-control" id="basicInput" value="3" required />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="generates" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Generate Nomor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= base_url("getcontacts") ?>" method="post">
                    <div class="modal-body">
                        <label class="form-label">Device</label>
                        <select name="device" class="form-select" required>
                            <?php foreach ($device->result() as $d) : ?>
                                <option value="<?= $d->nomor ?>"><?= $d->nomor ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Generate</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Javascripts -->
  <?php require_once('layouts/footer.php') ?>
    <script>
        $('#datatable1').DataTable({
            responsive: true
        });

        function checkAll(ele) {
            var checkboxes = document.getElementsByTagName('input');
            if (ele.checked) {
                for (var i = 0; i < checkboxes.length; i++) {
                    if (checkboxes[i].type == 'checkbox') {
                        checkboxes[i].checked = true;
                    }
                }
            } else {
                for (var i = 0; i < checkboxes.length; i++) {
                    if (checkboxes[i].type == 'checkbox') {
                        checkboxes[i].checked = false;
                    }
                }
            }
        }
    </script>
</body>

</html>