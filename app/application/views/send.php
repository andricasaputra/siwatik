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
                                    <h2>Test Sender</h2>
                                </div>
                            </div>
                        </div>
                        <?php require('layouts/alert.php') ?>
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
                                </ul>
                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="p-text" role="tabpanel" aria-labelledby="pills-home-tab">
                                        <br>
                                        <?php include_once('layouts/messages/text.php') ?>
                                    </div>
                                    <div class="tab-pane fade" id="p-media" role="tabpanel" aria-labelledby="pills-profile-tab">
                                        <br>
                                        <?php include_once('layouts/messages/media.php') ?>
                                    </div>
                                    <div class="tab-pane fade" id="p-tombol" role="tabpanel" aria-labelledby="pills-contact-tab">
                                        <br>
                                       <?php include_once('layouts/messages/button.php') ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<div class="modal fade" id="kontak" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kontak</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                
            </div>
                <div class="modal-body">
                    <div class="alert alert-info">
                    <strong>Untuk mengirim pesan ke banyak nomor silahkan gunakan fitur WA Blasr. <a href="<?= base_url('blast')  ?>" class="text-dark text-sm">Klik link berikut</a></strong>
                    </div>
                     <div class="table-responsive">
                        <table id="datatable1" class="table table-bordered text-center" style="width : 100%">
                        <thead>
                            <th>No</th>
                            <th>Pilih</th>
                            <th>Foto</th>
                            <th>Nama</th>
                            <th>Nomor</th>
                            
                        </thead>
                        <tbody>
                        <?php foreach ($contacts->result() as $key => $contact) : ?>
                            <tr>
                                <td><?= $key + 1 ?></td>
                                <td><input type="checkbox" data-kontak="<?= $contact->number  ?>" name="contact" class="form-check check-kontak"></td>
                                <td>
                                    <?php if($contact->pp == 'blank.png') : ?>

                                        <img class="rounded-circle" src="<?= _assets("images/other/user.png") ?>" height="50" alt="">

                                    <?php else: ?>

                                        <img class="rounded-circle" src="<?= $contact->pp ?>" height="50" alt="">

                                    <?php endif; ?>
                                </td>
                                <td><?= $contact->name  ?></td>
                                <td><?= $contact->number  ?></td>
                                
                            </tr>
                        <?php endforeach ?>
                        </tbody>
                    </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Pilih</button>
                </div>
        </div>
    </div>
</div>

<div class="modal fade" id="grup" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Group</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                
            </div>
                <div class="modal-body">
                    <div class="alert alert-info">
                    <strong>Untuk mengirim pesan ke banyak nomor silahkan gunakan fitur WA Blasr. <a href="<?= base_url('blast')  ?>" class="text-dark text-sm">Klik link berikut</a></strong>
                    </div>
                    <div class="table-responsive">
                        <table id="datatable" class="table table-bordered text-center" style="width: 100%">
                            <thead>
                                <th>No</th>
                                <th>Pilih</th>
                                <th>Foto</th>
                                <th>Nama</th>
                                <th>Group ID</th>
                            </thead>
                            <tbody>
                            <?php foreach ($groups->result() as $key => $group) : ?>
                                <tr>
                                    <td><?= $key + 1 ?></td>
                                    <td><input type="checkbox" data-kontak="<?= $group->id_group  ?>" name="group" class="form-check check-kontak"></td>
                                    <td>
                                        <?php if($group->pp == 'blank.png') : ?>

                                            <img class="rounded-circle" src="<?= _assets("images/other/user.png") ?>" height="50" alt="">

                                        <?php else: ?>

                                            <img class="rounded-circle" src="<?= $group->pp ?>" height="50" alt="">

                                        <?php endif; ?>
                                    </td>
                                    <td style="width=10%"><?= $group->nama_group  ?></td>
                                    <td><?= $group->id_group  ?></td>
                                    
                                </tr>
                            <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Pilih</button>
                </div>
        </div>
    </div>
</div>


    <!-- Javascripts -->
    <?php require_once('layouts/footer.php') ?>
    <script>
        $('#datatable').DataTable({
            responsive: true
        });

        $('#datatable1').DataTable({
            responsive: true
        });

        $(document).on("click", ".check-kontak", function(){

            let nomor = $(this).data('kontak');

            if ($(this).is(":checked")) {

                let group = "input:checkbox[name='" + $(this).attr("name") + "']";

                $(group).prop("checked", false);

                $(this).prop("checked", true);

                $('.tujuan').val(nomor)

              } else {

                $(this).prop("checked", false);
              }
        });


    </script>
    <!-- <script>
        $('select').select2();
    </script> -->
    <?php require_once('include_file.php') ?>

    
</body>

</html>