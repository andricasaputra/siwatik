 <form action="" method="post" class="loadingbtn">
    <input type="hidden" name="submitby" value="pesan-button">
    <div class="row">
        <div class="col-8 offset-2">
            <label>Device</label>
            <select class="js-states form-control" name="device" tabindex="-1">
                <?php foreach ($device->result() as $d) : ?>
                    <option value="<?= $d->nomor ?>"><?= $d->nomor ?></option>
                <?php endforeach ?>
            </select>
            <div class="mt-3">
                <label for="">Nomor Tujuan</label>
                <input type="text" name="nomor" class="form-control tujuan" required autocomplete="off" placeholder="Ketik Nomor cth : 6281238021xxx">
                <div class="d-flex justify-content-end">
                    <a href="#" onclick="event.preventDefault()" data-bs-toggle="modal" data-bs-target="#kontak">Pilih dari kontak</a>
                     &nbsp;&nbsp;
                <a href="#" onclick="event.preventDefault()" data-bs-toggle="modal" data-bs-target="#grup"><b>Kirim ke grup</b></a>
                </div>
            </div>
            <div class="mt-3">
                <label for="">Footer</label>
                <input type="text" name="footer" class="form-control" required>
            </div>
            <div class="mt-3">
                <label for="">Button 1</label>
                <input type="text" name="btn1" class="form-control" required>
            </div>
            <div class="mt-3">
                <label for="">Button 2</label>
                <input type="text" name="btn2" class="form-control" required>
            </div>
        </div>
        <div class="col-8 offset-2">
            <div class="mt-4">
                <textarea name="pesan" class="form-control" rows="10" placeholder="Pesan" required></textarea>
            </div>
        </div>
    </div>
    <div class="text-end btnkirim mt-3">
        <button type="submit" class="btn btn-primary"><i class="material-icons">send</i>Kirim</button>
    </div>
</form>