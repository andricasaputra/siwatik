<script src="<?= _assets() ?>/plugins/jquery/jquery-3.5.1.min.js"></script>
<script src="<?= _assets() ?>/plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="<?= _assets() ?>/plugins/perfectscroll/perfect-scrollbar.min.js"></script>
<script src="<?= _assets() ?>/plugins/pace/pace.min.js"></script>
<script src="<?= _assets() ?>/plugins/datatables/datatables.min.js"></script>
<script src="<?= _assets() ?>/plugins/select2/js/select2.full.min.js"></script>
<script src="<?= _assets() ?>/js/main.min.js"></script>
<script src="<?= _assets() ?>/js/custom.js"></script>
<script>
	const removeAlert = setInterval(() => {

		$('.alert-success').remove()
		clearInterval(removeAlert);

	}, 5000);
	
</script>