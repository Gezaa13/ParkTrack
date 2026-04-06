<title>Ubah User</title>
<div class="container-fluid">
    <div class="mb-2">
        <a href="/admin/user" class="text-reset">
            <i class="fa-solid fa-chevron-left"></i>
            <span>Kembali</span>
        </a>
    </div>
    <form action="/admin/user/ubah/send/<?= $user['id_user'] ?>" method="post">
        <div>
            <div class="form-floating">
                <input type="text" class="form-control border border-black" id="namaLengkap" placeholder="test" name="nama_lengkap" required value="<?= $user['nama_lengkap'] ?>">
                <label for="namaLengkap">Nama Lengkap</label>
            </div>
            <div class="form-floating mt-2">
                <input type="text" class="form-control border border-black" id="username" placeholder="test" name="username" required value="<?= $user['username'] ?>">
                <label for="username">Username</label>
            </div>
        </div>
        <div class="d-flex justify-content-center mt-2">
            <input type="submit" value="Ubah" class="bg-blue-1 rounded border-0 py-2 px-5 fw-bold">
        </div>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    <?php if(session()->getFlashdata('errorUsername')): ?>
    Swal.fire({
        title: 'Username sudah dipakai',
        text: 'Username yang Anda masukkan sudah digunakan. Silakan gunakan username lain.',
        icon: 'warning',
        confirmButtonText: 'Oke',
    })
    <?php endif ?>
</script>