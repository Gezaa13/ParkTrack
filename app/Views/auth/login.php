<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/sweetAlert.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
</head>

<body>
    <div class=" full-screen d-flex">
        <img src="/assets/images/logo1.svg" class="col-7">
        <div class="bg-blue-1 d-flex flex-column justify-content-center rounded-start-5 col-5 px-5">
            <span class="fw-bold fs-3 text-white text-center mb-4">Selamat datang kembali!</span>
            <form action="/login" method="post" class="d-flex flex-column gap-3">
                <div class="form-floating">
                    <input type="text" class="form-control bg-white-opacity-25 text-white border-top-0 border-start-0 border-end-0" id="floatingUsername" placeholder="test" name="username" required>
                    <label for="floatingUsername" class="text-white">Username</label>
                </div>
                <div class="input-group">
                    <div class="form-floating">
                        <input type="password" class="form-control bg-white-opacity-25 text-white border-top-0 border-start-0 border-end-0" id="password" name="password" placeholder="password" required>
                        <label for="password" class="text-white">Password</label>
                    </div>
                    <a href="#" class="input-group-text bg-white-opacity-25 text-white border-top-0 border-start-0 border-end-0 text-decoration-none">
                        <i id="visiblily" class="fa-solid fa-eye-slash"></i>
                    </a>
                </div>
                <input type="submit" value="Login" class="btn-hover-white rounded-2 p-2 text-center fw-bold fs-5 border-0">
            </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $('#visiblily').on('click', function(e) {
            if ($(this).attr('class') == 'fa-solid fa-eye-slash') {
                $(this).addClass('fa-eye').removeClass('fa-eye-slash');
                $('#password').attr('type', 'text');
            } else {
                $(this).addClass('fa-eye-slash').removeClass('fa-eye');
                $('#password').attr('type', 'password');
            }
        })
        <?php if(session()->getFlashdata('errorAktif')): ?>
        Swal.fire({
            title: 'User belum diaktivasi',
            text: 'Akun Anda belum diaktivasi. Silakan hubungi admin untuk proses aktivasi.',
            icon: 'warning',
            confirmButtonText: 'Oke',
        })
        <?php endif ?>
        <?php if(session()->getFlashdata('errorPassword')): ?>
        Swal.fire({
            title: 'Password salah',
            text: 'password yang Anda masukkan salah. Silakan coba kembali.',
            icon: 'warning',
            confirmButtonText: 'Oke',
        })
        <?php endif ?>
        <?php if(session()->getFlashdata('errorUsername')): ?>
        Swal.fire({
            title: 'Username tidak ditemukan',
            text: 'Username yang Anda masukkan tidak ditemukan. Silakan coba kembali.',
            icon: 'warning',
            confirmButtonText: 'Oke',
        })
        <?php endif ?>
    </script>
</body>

</html>