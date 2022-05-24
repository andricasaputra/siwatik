<?php if($this->session->flashdata('success')) : ?>

	<div class="alert alert-success alert-style-light" role="alert">
		<?= $this->session->flashdata('success') ?>
	</div>

<?php elseif($this->session->flashdata('error')) : ?>

	<div class="alert alert-danger alert-style-light" role="alert">
		<b><?= $this->session->flashdata('error') ?></b>
	</div>

<?php endif; ?>

<?php 

if(isset($_SESSION['success'])){
	
    unset($_SESSION['success']);
    }
    if(isset($_SESSION['error'])){
    unset($_SESSION['error']);
    }

?>