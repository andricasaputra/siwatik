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
                                    <h2>Group</h2>
                                </div>
                            </div>
                        </div>
                        <?php require('layouts/alert.php') ?>
                        <form action="<?= base_url('groups/del') ?>" method="post">
                            <!-- <div class="card widget widget-action-list">
                                <div class="card-body">
                                    <button class="btn btn-primary m-1" type="button" data-bs-toggle="modal" data-bs-target="#generates_group"><i class="material-icons">groups</i>Generate groups</button>
                                </div>
                            </div> -->
                            <div class="row">
                                <div class="col">
                                    <div class="card">
                                        <div class="card-body">?>
                                            <h5>Daftar Group</h5>
                                            <table id="datatable1" class="display text-center" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Foto</th>
                                                        <th>Group ID</th>
                                                        <th>Name</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($group_wa->result() as $key =>  $d) : ?>


                                                        <tr>
                                                            <td><?= $key + 1  ?></td>
                                                            <td>

                                                                <?php if($d->pp == 'blank.png') : ?>

                                                                    <img class="rounded-circle" src="<?= _assets("images/other/user-group.png") ?>" height="50" alt="">

                                                                <?php else: ?>

                                                                    <img class="rounded-circle" src="<?= $d->pp ?>" height="50" alt="">

                                                                <?php endif; ?>
                                                            </td>
                                                            <td><?= $d->id_group ?></td>
                                                            <td><b><?= $d->nama_group ?></b></td>
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

    <div class="modal fade" id="generates_group" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Generate Nomor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= base_url("getgroups") ?>" method="post">
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