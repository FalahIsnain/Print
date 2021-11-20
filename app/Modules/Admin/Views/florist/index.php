<?= $this->extend('layout/templateAdmin'); ?>
<?= $this->section('content'); ?>

<div class="container">
    <div class="row">
        <div class="col">

            <h3>Selamat Datang <?= session()->get('username') ?></h3>

            <a href="<?= base_url('Florist/create') ?>" class="btn btn-primary mt-3 ">Tambah daftar Produk</a>

            <div class="btn-group mt-3">
                <a href="#" class="btn btn-primary" aria-current="page" onclick="return confirm('pilih jenis dan buket');">Kelola data</a>
                <a href="<?= base_url('User/') ?>" class="btn btn-primary">Data Pengguna</a>
                <a href="<?= base_url('Jenis/') ?>" class="btn btn-primary">Jenis</a>
                <a href="<?= base_url('Buket/') ?>" class="btn btn-primary">Buket</a>
            </div>

            <div class="btn-group mt-3">
                <a href="#" class="btn btn-dark" aria-current="page" onclick="return confirm('pilih jenis dokumen yg di Download');">Download data <i class="fas fa-download"></i></a>
                <a href="<?= base_url('CetakPDF/') ?>" class="btn btn-danger">PDF <i class="fas fa-file-pdf"></i></a>
                <a href="<?= base_url('CetakWord/') ?>" class="btn btn-primary">Word <i class="fas fa-file-word"></i></a>
                <a href="<?= base_url('CetakExcell/') ?>" class="btn btn-success">Excell <i class="fas fa-file-excel"></i></a>
            </div>
            <div class="container2">
                <h1 class="mt-2"> Data Produk</h1>
                <?php if (session()->getFlashdata('pesan')) : ?>

                    <div class="alert alert-success" role="alert">
                        <?= session()->getFlashdata('pesan'); ?>
                    </div>

                <?php endif; ?>
                <table class="table" id="table">
                    <thead>
                        <tr>
                            <th scope="col">Gambar</th>
                            <th scope="col">Nama Produk</th>
                            <th scope="col">Jenis Bunga</th>
                            <th scope="col">Tipe Buket</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php foreach ($florist as $f) : ?>
                            <tr>

                                <td><img src="<?= base_url('img/upload/' . $f['gambar'])  ?>" alt="" class="gambar" width="80px"></td>
                                <td><?= $f['nama_produk']; ?></td>
                                <td><?= $f['jenis_bunga']; ?></td>
                                <td><?= $f['tipe_buket']; ?></td>
                                <td><a href="<?= site_url('Detail/' . $f['slug']) ?>" class="btn btn-success"> Detail</a></td>

                            </tr>

                        <?php endforeach; ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>



<?= $this->endSection(); ?>