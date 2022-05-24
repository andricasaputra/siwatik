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
                                    <h2>WA Blast</h2>
                                </div>
                            </div>
                        </div>
                        <?php require('layouts/alert.php') ?>
                        <div class="card">
                            <div class="card-body">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#tab_input" type="button" role="tab" aria-controls="home" aria-selected="true">Input</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#tab_datatable" type="button" role="tab" aria-controls="profile" aria-selected="false">Datatable</button>
                                    </li>
                                </ul>
                                <br>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="tab_input" role="tabpanel" aria-labelledby="home-tab">
                                        <form action="" method="post" class="loadingbtn">
                                            <label>Device</label>
                                            <select class="js-states form-control" name="device" tabindex="-1" style="display: none; width: 100%">
                                                <?php foreach ($device->result() as $d) : ?>
                                                    <option value="<?= $d->nomor ?>"><?= $d->nomor ?></option>
                                                <?php endforeach ?>
                                            </select>

                                            <div class="row">
                                                <div class="col-12 col-xl-6">
                                                    <div class="mt-3">
                                                        <label for="">Nomor Tujuan</label>
                                                        <div id="input_tujuan">
                                                            <select class="js-states form-control" name="listnumber[]" id="listnumber" tabindex="-1" style="display: none; width: 100%" multiple="multiple" required>
                                                                <optgroup label="By Label">
                                                                    <?php foreach ($label->result() as $l) : ?>
                                                                        <option value="<?= $l->label ?>"><?= "$l->label" ?></option>
                                                                    <?php endforeach ?>
                                                                </optgroup>
                                                                <optgroup label="Nomor">
                                                                    <?php foreach ($nomor->result() as $n) : ?>
                                                                        <option value="<?= $n->nomor ?>">
                                                                            <?= "$n->nama ($n->nomor)" ?>
                                                                        </option>
                                                                    <?php endforeach ?>
                                                                </optgroup>
                                                            </select>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" id="allcheck" type="checkbox" name="all_number">
                                                            <label class="form-check-label" for="flexCheckDefault">
                                                                Kirim ke semua nomor (di data contacts).
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="mt-3">
                                                        <label for="">Link media ( JPG,JPEG,PDF )</label>
                                                        <div class="input-group">
                                                            <input type="text" id="inputmedia" name="media" class="form-control" placeholder="Link media">
                                                            <span onclick="mediamodal()" class="btn btn-primary"><span class="material-icons pt-1">file_upload</span></span>
                                                        </div>
                                                        <small>Kosongi jika ingin kirim pesan saja.</small>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-xl-6">
                                                    <div class="mt-3">
                                                        <label for="">Pesan</label>
                                                        <textarea name="pesan" class="form-control" rows="7" placeholder="Contoh : Hai {name}" required></textarea>
                                                        <small>note : {name} menulis nama sesuai penerima. <br> Ketika kamu kirim file pdf input pesan akan di gunakan untuk nama file pdf.</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-end btnkirim mt-3">
                                                <button type="submit" class="btn btn-primary"><i class="material-icons">send</i>Kirim</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade" id="tab_datatable" role="tabpanel" aria-labelledby="profile-tab">
                                        <form action="<?= base_url("blast/del") ?>" method="post">
                                            <button type="submit" class="btn btn-danger m-1"><i class="material-icons">delete</i>Hapus</button>
                                            <table id="datatable1" class="display" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th><input class="form-check-input" onchange="checkAll(this)" name="chk[]" type="checkbox"></th>
                                                        <th>Sender</th>
                                                        <th>To</th>
                                                        <th>Pesan</th>
                                                        <th>Media</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($blast->result() as $b) : ?>
                                                        <tr>
                                                            <td><input class="form-check-input checkdel" name="id[]" value="<?= $b->id ?>" type="checkbox"></td>
                                                            <td><?= $b->sender ?></td>
                                                            <td><?= $b->tujuan ?></td>
                                                            <td><?= $b->pesan ?></td>
                                                            <td><?= ($b->media == '') ? '<button class="btn btn-secondary btn-sm" disabled>None</button>' : '<button type="button" class="btn btn-primary btn-sm" onclick="lihat_gambar(`' . $b->media . '`)">Lihat</button>' ?></td>
                                                            <td>
                                                                <?php
                                                                if ($b->status == 'pending') {
                                                                    echo '<span class="badge badge-style-light rounded-pill badge-warning">Pending</span>';
                                                                } else if ($b->status == 'terkirim') {
                                                                    echo '<span class="badge badge-style-light rounded-pill badge-success">Terkirim</span>';
                                                                } else if ($b->status == 'gagal') {
                                                                    echo '<span class="badge badge-style-light rounded-pill badge-danger">Gagal</span>';
                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach ?>
                                                </tbody>
                                            </table>
                                        </form>
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
        $('select').select2();
        $('#datatable1').DataTable({
            responsive: true
        });

        $("#allcheck").change(function() {
            if (this.checked == true) {
                $("#listnumber").val('')
                $("#input_tujuan").hide()
                $("#listnumber").attr('required', false)
            } else {
                $("#listnumber").attr('required', true)
                $("#input_tujuan").show()
            }
        })

        function checkAll(ele) {
            var checkboxes = document.getElementsByClassName('checkdel');
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
    <?php require_once('include_file.php') ?>
</body>

</html>