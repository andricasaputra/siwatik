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
                                    <h2>Users Manager</h2>
                                </div>
                            </div>
                        </div>
                        <?php require('layouts/alert.php') ?>

                        <div class="row">
                            <div class="col">
                                <div class="card">
                                    <div class="card-body">
                                        <h5>Users List</h5>
                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#devices"><i class="material-icons">add</i>Add Users</button>
                                        <table id="datatable1" class="display" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Username</th>
                                                    <th>Role</th>
                                                    <th>#</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($users->result() as $d) : ?>
                                                    <tr>
                                                        <td></td>
                                                        <td><?= $d->username ?></td>
                                                        <td><?= ($d->level == 1) ? 'ADMIN' : 'CS' ?></td>
                                                        <td>
                                                            <a href="<?= base_url('users/del/' . $d->id) ?>" class="btn btn-danger">Hapus</a>
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
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Users</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post">
                    <div class="modal-body">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" required>
                        <label class="form-label">Password</label>
                        <input type="text" name="password" class="form-control" autocomplete="off">
                        <label class="form-label">Level</label>
                        <select name="level" class="form-select" aria-label="Default select example">
                            <option value="1">ADMIN</option>
                            <option value="2">CS</option>
                        </select>
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
    <script src="<?= _assets() ?>/js/pages/dashboard.js"></script>
    <script>
        $('#datatable1').DataTable({
            responsive: true,
            "lengthChange": false,
            "paging": false,
            "searching": false
        });
    </script>
</body>

</html>