<title>Tambah User</title>
<div class="container-fluid">
    <div class="mb-2">
        <a href="/admin/user" class="text-reset">
            <i class="fa-solid fa-chevron-left"></i>
            <span>Kembali</span>
        </a>
    </div>
    <form action="/admin/user/tambah/send" method="post">
        <div class="d-flex">
            <div class="p-1 col-6">
                <div class="form-floating">
                    <input type="text" class="form-control border border-black" id="namaLengkap" placeholder="test" name="nama_lengkap" required>
                    <label for="namaLengkap">Nama Lengkap</label>
                </div>
            </div>
            <div class="p-1 col-6 d-flex flex-column">
                <select name="role" id="role" class="form-select border border-black h-100" required>
                    <option value="">>-- Pilih Role --<</option>
                    <option value="Petugas">Petugas</option>
                    <option value="Admin">Admin</option>
                    <option value="Owner">Owner</option>
                </select>
            </div>
        </div>
        <div class="d-flex">
            <div class="p-1 col-6">
                <div class="form-floating">
                    <input type="text" class="form-control border border-black" id="username" placeholder="test" name="username" required>
                    <label for="username">Username</label>
                </div>
            </div>
            <div class="p-1 col-6">
                <div class="input-group"> 
                    <div class="form-floating">
                        <input type="password" class="form-control border border-black" id="password" name="password" placeholder="password" required>
                        <label for="password">Password</label>
                    </div>
                    <a href="#" class="input-group-text text-decoration-none border border-black">
                        <i id="visiblily" class="fa-solid fa-eye-slash"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center mt-2">
            <input type="submit" value="Tambah" class="bg-blue-1 rounded border-0 py-2 px-5 fw-bold">
        </div>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
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
    $('#visiblily').on('click', function(e) {
        if ($(this).attr('class') == 'fa-solid fa-eye-slash') {
            $(this).addClass('fa-eye').removeClass('fa-eye-slash');
            $('#password').attr('type', 'text');
        } else {
            $(this).addClass('fa-eye-slash').removeClass('fa-eye');
            $('#password').attr('type', 'password');
        }
    })
</script>