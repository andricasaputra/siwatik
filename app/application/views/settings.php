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
                                    <h2>SETTINGS</h2>
                                </div>
                            </div>
                        </div>
                        <?php require('layouts/alert.php') ?>
                        <div class="card">
                            <div class="card-body">
                                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Global</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Account</button>
                                    </li>
                                </ul>
                                <br>
                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                        <form action="<?= base_url('settings/global') ?>" method="post" class="loadingbtn">
                                            <div class="mt-3">
                                                <label>BASE NODE</label>
                                                <input type="text" class="form-control" value="<?= $settings->base_node ?>" name="base_node" required>
                                            </div>
                                            <div class="mt-3">
                                                <label for="">Install In</label>
                                                <select class="form-select" name="install_in">
                                                    <option <?= ($settings->install_in == 2) ? 'selected' : '' ?> value="2">Local</option>
                                                    <option <?= ($settings->install_in == 1) ? 'selected' : '' ?> value="1">Hosting</option>
                                                </select>
                                            </div>
                                            <div class="text-end btnkirim mt-3">
                                                <button type="submit" class="btn btn-primary"><i class="material-icons">save</i>Update</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                        <form action="" method="post" class="loadingbtn">
                                            <input type="hidden" name="submitby" value="pesan-text">
                                            <div class="row">
                                                <div class="mt-3">
                                                    <label>Api Key</label>
                                                    <input type="text" class="form-control" value="<?= $user->api_key ?>" name="api" required>
                                                </div>
                                                <div class="mt-3">
                                                    <label>Username</label>
                                                    <input type="text" class="form-control" value="<?= $user->username ?>" name="username" required>
                                                </div>
                                                <div class="mt-3">
                                                    <label>Password</label>
                                                    <input type="text" class="form-control" name="password">
                                                    <small>Kosongi jika tidak ingin merubah password.</small>
                                                </div>
                                            </div>
                                            <input type="hidden" name="old_password" value="<?= $user->password ?>">
                                            <div class="text-end btnkirim mt-3">
                                                <button type="submit" class="btn btn-primary"><i class="material-icons">save</i>Update</button>
                                            </div>
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


    <!-- Javascripts -->
    <?php require_once('layouts/footer.php') ?>
    <script>
        $('select').select2();
    </script>
    <?php require_once('include_file.php') ?>
</body>

</html>