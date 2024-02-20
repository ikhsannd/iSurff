<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form">
    <div class="modal-dialog modal-lg" role="document">
        <form action="" method="post" class="form-horizontal">
            @csrf
            @method('post')

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <div class="col-lg-6">
                        <select name="produk_id" id="produk_id" class="form-control" required>
                            <option value="">Pilih Kategori</option>
                            @foreach ($categoryList as $id => $nama_produk)
                            <option value="{{ $id }}">{{ $nama_produk }}</option>
                            @endforeach
                        </select>
                        <span class="help-block with-errors"></span>
                    </div>
                    <div class="form-group row">
                        <label for="stok_masuk" class="col-lg-2 col-lg-offset-1 control-label">Stok Masuk</label>
                        <div class="col-lg-6">
                            <input type="number" name="stok_masuk" id="stok_masuk" class="form-control" required
                                autofocus>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tanggal" class="col-lg-2 col-lg-offset-1 control-label">Tanggal</label>
                        <div class="col-lg-6">
                            <input type="date" name="tanggal" id="tanggal" class="form-control" required autofocus>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="keterangan" class="col-lg-2 col-lg-offset-1 control-label">Keterangan</label>
                        <div class="col-lg-6">
                            <textarea type="text" name="keterangan" id="keterangan" class="form-control" required
                                autofocus>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-flat btn-primary"><i class="fa fa-save"></i> Simpan</button>
                    <button type="button" class="btn btn-sm btn-flat btn-warning" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i> Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>
