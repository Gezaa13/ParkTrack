<title>Tambah Kendaraan</title>
<div class="container-fluid">
    <div class="mb-2">
        <a href="/admin/kendaraan" class="text-reset">
            <i class="fa-solid fa-chevron-left"></i>
            <span>Kembali</span>
        </a>
    </div>
    <form action="/admin/kendaraan/tambah/send" method="post">
        <div>
            <div class="form-floating">
                <input type="text" class="form-control border border-black" id="idKartu" placeholder="test" name="id_kartu" required>
                <label for="idKartu">ID Kartu</label>
            </div>
            <div class="form-floating my-2">
                <input type="text" class="form-control border border-black" id="platNomor" placeholder="test" name="plat_nomor" required>
                <label for="platNomor">Plat Nomor</label>
            </div>
            <div class="form-floating">
                <input type="text" class="form-control border border-black" id="pemilik" placeholder="test" name="pemilik" required>
                <label for="pemilik">Pemilik</label>
            </div>
        </div>
        <div class="d-flex justify-content-center mt-2">
            <input type="submit" value="Tambah" class="bg-blue-1 rounded border-0 py-2 px-5 fw-bold">
        </div>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    <?php if(session()->getFlashdata('error')): ?>
    Swal.fire({
        title: 'Kendaraan dengan Plat Nomor atau ID Kartu tersebut sudah terdaftar',
        text: 'Silakan periksa apakah kendaraan sudah terdaftar. Jika belum, pastikan ID uang digunakan belum pernah digunakan sebelumnya.',
        icon: 'warning',
        confirmButtonText: 'Oke',
    })
    <?php endif ?>
</script>