<div class="app-sidebar">
    <div class="logo">
        <a href="#" class="logo-icon" style="background: url(<?= _assets('images/avatars/logobarantan.png') ?>) no-repeat; background-position: center center;background-size: 35px;"><span class="logo-text">SIWATIK</span></a>
        <div class="sidebar-user-switcher user-activity-online">
            <a href="#">
                <img src="<?= _assets() ?>/images/avatars/blogger.png">
                <span class="activity-indicator"></span>
                <span class="user-info-text"><?= $user->username ?><br><span class="user-state-info">SIWATIK</span></span>
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
            <li class="active-page">
                <a href="<?= base_url('autoresponder') ?>" class="active"><i class="material-icons-two-tone">message</i>Auto Responder</a>
            </li>
            <li>
                <a href="<?= base_url('contacts') ?>" class="active"><i class="material-icons-two-tone">contacts</i>Contacts/Number</a>
            </li>
            <li>
                <a href="<?= base_url('groups') ?>" class="active"><i class="material-icons-two-tone">group</i>Groups</a>
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
            <li>
                <a href="<?= base_url('api') ?>" class="active"><i class="material-icons-two-tone">api</i>Rest Api</a>
            </li>
            <?php if ($user->level == 1) { ?>
                <li>
                    <a href="<?= base_url('users') ?>" class="active"><i class="material-icons-two-tone">account_circle</i>Users Manager</a>
                </li>
            <?php } ?>
            <li>
                <a href="<?= base_url('settings') ?>" class="active"><i class="material-icons-two-tone">settings</i>Settings</a>
            </li>
            <li>
                <a href="<?= base_url('logout') ?>" class="active"><i class="material-icons-two-tone">logout</i>Logout</a>
            </li>
        </ul>
    </div>
</div>