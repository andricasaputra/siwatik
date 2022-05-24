<form action="" method="post" class="loadingbtn">
                                            
    <div class="row">
        <div class="col-8 offset-2">

            <input type="hidden" name="submitby" value="pesan-media">
            <label>Device</label>
            <select class="js-states form-control" name="device" tabindex="-1">
                <?php foreach ($device->result() as $d) : ?>
                    <option value="<?= $d->nomor ?>"><?= $d->nomor ?></option>
                <?php endforeach ?>
            </select>

            <div class="mt-3">
                <label for="">Nomor Tujuan</label>
                <input type="text" name="nomor" class="form-control tujuan" required autocomplete="off" placeholder="Ketik Nomor cth : 6281238021xxx">
            </div>
            <div class="d-flex justify-content-end">
                <a href="#" onclick="event.preventDefault()" data-bs-toggle="modal" data-bs-target="#kontak">Pilih dari kontak</a>
                 &nbsp;&nbsp;
                <a href="#" onclick="event.preventDefault()" data-bs-toggle="modal" data-bs-target="#grup"><b>Kirim ke grup</b></a>
            </div>
        </div>
        <div class="col-8 offset-2">
            <div class="mt-3 form-group">
                <label for="type">Type File</label>
                <select name="type" class="form-control">
                    <option value="">-- Pilih Type File --</option>
                    <option value="image">Gambar</option>
                    <option value="pdf">PDF</option>
                </select>
                <br>
                <small>Kosongi jika anda sudah mengupload file.</small>
            </div>
            
        </div>
        <div class="col-8 offset-2">
            <div class="mt-3">
                <label for="">Link media ( JPG,JPEG,PNG,PDF )</label>
                <div class="input-group">
                    <input type="text" id="inputmedia" name="media" class="form-control" placeholder="Masukkan URL atau upload file dengan mengklik tombol upload">
                    <span onclick="mediamodal()" class="btn btn-primary"><span class="material-icons pt-1">file_upload</span></span>
                </div>
                <small>Kosongi jika ingin kirim pesan saja.</small>
            </div>
        </div>
        <div class="col-8 offset-2">
            <div class="mt-3">
                <label for="pesan">Pesan/Caption</label>
                <textarea name="pesan" class="form-control" rows="10" placeholder="Pesan/Caption"></textarea>
            </div>
        </div>
    </div>
    <div class="text-end btnkirim mt-3">
        <button type="submit" class="btn btn-primary"><i class="material-icons">send</i>Kirim</button>
    </div>
</form>