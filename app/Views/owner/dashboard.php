<title>Dashboard</title>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center pb-2">
        <div class="d-flex align-items-center">
            <span class="fs-4 fw-bold col-auto">Rekapitulasi Bulan</span>
            <input type="month" name="bulan" id="bulan" class="form-control fs-4 fw-bold" onchange="getData(this.value)">
        </div>
        <a href="#" class="p-3 bg-blue-1 text-white rounded" id="export">
            <i class="fa-solid fa-2xl fa-file-pdf"></i>
        </a>
    </div>
    <div class="d-flex d-none mb-3">
        <div class="px-2 col-6">
            <div class="p-2 bg-blue-1 rounded text-white">
                <div class="border-bottom border-white">
                    <span class="fs-4 fw-bold">Total Pendapatan</span>
                </div>
                <div class="text-center ">
                    <span class="fs-2 fw-bold" id="totalPendapatan"></span>
                </div>
            </div>
        </div>
        <div class="px-2 col-6">
            <div class="p-2 bg-blue-2 rounded text-white">
                <div class="border-bottom border-white">
                    <span class="fs-4 fw-bold">Total Transaksi</span>
                </div>
                <div class="text-center ">
                    <span class="fs-2 fw-bold" id="totalTransaksi"></span>
                </div>
            </div>
        </div>
    </div>
    <div class="d-none">
        <span class="fw-bold fs-4 text-center d-block">Transaksi</span>
        <canvas id="lineChart" width="100%" height="30px"></canvas>
        <span class="fw-bold fs-4 text-center d-block mt-4">Pendapatan</span>
        <canvas id="barChart" width="100%" height="30px"></canvas>
    </div>
    <div class="mt-5 d-none">
        <table id="table" class="table table-secondary table-striped display nowrap">
            <thead>
                <tr>
                    <th class="text-center bg-blue-2 text-white">Tanggal</th>
                    <th class="text-center bg-blue-1 text-white">Total Transaksi</th>
                    <th class="text-center bg-blue-2 text-white">Total Pendapatan</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
    let chartTransaksi;
    let chartPendapatan;
    let table;
    function getData(bulan) {
        $.ajax({
            url: "owner/get-data/pendapatan-card/" + bulan,
            method: 'GET',
            dataType: 'json',
            success: function(data){
                $('#totalPendapatan').html('Rp' + Number(data).toLocaleString('id-ID') + ',00')
            }
        })
        $.ajax({
            url: "owner/get-data/transaksi-card/" + bulan,
            method: 'GET',
            dataType: 'json',
            success: function(data){
                $('#totalTransaksi').html(data)
            }
        })
        $.ajax({
            url: "owner/get-data/transaksi-chart/" + bulan,
            method: 'GET',
            dataType: 'json',
            success: function(data){
                const ctx1 = document.getElementById('lineChart').getContext('2d');

                if (chartTransaksi) {
                    chartTransaksi.destroy();
                }

                chartTransaksi =  new Chart(ctx1, {
                    type: 'line',
                    data: {
                        labels: Object.keys(data),
                        datasets: [{
                            label: 'Total',
                            data: Object.values(data),
                            fill: true,
                            backgroundColor: [
                                '#1e3a8a',
                            ],
                        }]
                    },
                });
            }
        })
        $.ajax({
            url: "owner/get-data/pendapatan-chart/" + bulan,
            method: 'GET',
            dataType: 'json',
            success: function(data){
                const ctx2 = document.getElementById('barChart').getContext('2d');

                if (chartPendapatan) {
                    chartPendapatan.destroy();
                }
                
                chartPendapatan = new Chart(ctx2, {
                    type: 'bar',
                    data: {
                        labels: Object.keys(data),
                        datasets: [{
                            label: 'Total',
                            data: Object.values(data),
                            backgroundColor: [
                                '#1d4ed8',
                            ],
                        }]
                    }
                });
            }
        })
        $.ajax({
            url: "owner/get-data/table/" + bulan,
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                if ($.fn.DataTable.isDataTable('#table')) {
                    table.clear().rows.add(data).draw();
                } else {
                    table = $('#table').DataTable({
                        data: data,
                        columnDefs: [
                            {
                                targets: 0,
                                className: 'text-center',
                            },
                            {
                                targets: 1,
                                className: 'text-center'
                            },
                            {
                                targets: 2,
                                className: 'text-end',
                                render: function(data){
                                    return 'Rp' + Number(data).toLocaleString('id-ID') + ',00';
                                }
                            }
                        ],
                        columns: [
                            {data: 'tanggal'},
                            {data: 'transaksi'},
                            {data: 'pendapatan'},
                        ],
                        language: {
                            search: "<i class='fa-solid fa-magnifying-glass'></i>",
                            lengthMenu: "Tampilkan _MENU_ data",
                            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                            infoEmpty: "data tidak ditemukan",
                            infoFiltered: "(disaring dari total _MAX_ data)",
                            zeroRecords: "Tidak ada data",
                            paginate: {
                                first: "<i class='fa-solid fa-angles-left'></i>",
                                last: "<i class='fa-solid fa-angles-right'></i>",
                                next: "<i class='fa-solid fa-angle-right'></i>",
                                previous: "<i class='fa-solid fa-angle-left'></i>"
                            }
                        }
                    })
                }
            }
        })
        $('.d-none').removeClass('d-none');
        $('#export').attr('href', '/owner/export/' + bulan);
    }
</script>