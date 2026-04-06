<title>Dashboard</title>
<div class="container-fluid">
    <div class="d-flex">
        <div class="px-1 col-3">
            <div class="bg-blue-1 text-white rounded p-2">
                <div class="border-bottom">
                    <span class="fw-bold fs-5">Total User</span>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <span class="fw-bold fs-2"><?= $totalUser ?></span>
                    <i class="fa-solid fa-2xl fa-users text-white-50"></i>
                </div>
            </div>
        </div>
        <div class="px-1 col-3">
            <div class="bg-blue-2 text-white rounded p-2">
                <div class="border-bottom">
                    <span class="fw-bold fs-5">User Aktif</span>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <span class="fw-bold fs-2"><?= $userAktif ?></span>
                    <i class="fa-solid fa-2xl fa-user-check text-white-50"></i>
                </div>
            </div>
        </div>
        <div class="px-1 col-3">
            <div class="bg-blue-1 text-white rounded p-2">
                <div class="border-bottom d-flex justify-content-between align-items-center">
                    <span class="fw-bold fs-5">Kapasitas Area</span>
                    <a href="#" class="text-white text-decoration-none" data-bs-toggle="modal" data-bs-target="#kapasitas">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </a>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <span class="fw-bold fs-2"><?= $area['kapasitas'] ?></span>
                    <i class="fa-solid fa-2xl fa-location-dot text-white-50"></i>
                </div>
            </div>
        </div>
        <div class="px-1 col-3">
            <div class="bg-blue-2 text-white rounded p-2">
                <div class="border-bottom">
                    <span class="fw-bold fs-5">Kendaraan Aktif</span>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <span class="fw-bold fs-2"><?= $kendaraanAktif ?></span>
                    <i class="fa-solid fa-2xl fa-car-side text-white-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-3 d-flex">
        <div class="col-6">
            <span class="fw-bold fs-4 text-center d-block">Rasio Kapasitas</span>
            <canvas id="doughnutChart" width="100%" height="auto"></canvas>
        </div>
        <div class="col-6">
            <span class="fw-bold fs-4 text-center d-block">Rasio User</span>
			<canvas id="pieChart" width="100%" height="auto"></canvas>
		</div>
    </div>
</div>
<div class="modal fade" id="kapasitas" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-black">
                <span class="fs-5 fw-bold">Ubah Kapasitas</span>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="/admin/ubah-kapasitas" method="POST" id="formKapasitas">
                    <input type="number" name="kapasitas" id="kapasitas" class="form-control border-black" value="<?= $area['kapasitas'] ?>">
                </form>
            </div>
            <div class="modal-footer border-black">
                <button type="submit" form="formKapasitas" class="bg-blue-1 p-2 rounded text-white text-decoration-none fw-bold border-0">Simpan</button>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const role = <?= json_encode(array_column($rasioUser, 'role')) ?>;
    const user = <?= json_encode(array_column($rasioUser, 'total')) ?>;
    const ctx1 = document.getElementById('pieChart').getContext('2d');
    new Chart(ctx1, {
        type: 'pie',
        data: {
            labels: role,
            datasets: [{
                label: 'Total',
                data: user,
                backgroundColor: [
                    '#1e3a8a',
                    '#1d4ed8',
                    '#3b82f6',
                ],
            }]
        }
    });
    const kapasitas = [<?= $area['kapasitas'] - $area['terisi'] ?>, <?= $area['terisi'] ?>];
    const ctx2 = document.getElementById('doughnutChart').getContext('2d');
    new Chart(ctx2, {
        type: 'doughnut',
        data: {
            datasets: [{
                data: kapasitas,
                backgroundColor: [
                    '#ffffff',
                    '#1e3a8a',
                ],
            }]
        }
    })
    <?php if(session()->getFlashdata('errorKapasitas')): ?>
    Swal.fire({
        title: 'Kapasitas Tidak Valid',
        text: 'Nilai tidak valid. Angka yang dimasukkan harus lebih dari 0 (tidak boleh 0 atau negatif).',
        icon: 'warning',
        confirmButtonText: 'Mengerti',
    })
    <?php endif ?>
</script>