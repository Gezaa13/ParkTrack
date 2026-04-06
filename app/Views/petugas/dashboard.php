<title>Dashboard</title>
<div class="container-fluid">
    <?php if($area['terisi'] == $area['kapasitas']): ?>
    <div class="bg-danger-subtle p-3 rounded border border-danger">
        <i class="fa-solid fa-xl fa-circle-exclamation text-danger"></i>
        <span>Area Parkir sudah penuh, silahkan arahkan pengendara untuk mencari area parkir lain.</span>
    </div>
    <?php endif ?>
    <div class="d-flex align-items-center mt-2 pb-2 border-bottom border-black">
        <span class="fs-2 fw-bold me-3">MASUK</span>
    </div>
    <div>
        <table id="tableMasuk" class="table table-secondary table-striped">
            <thead>
                <tr>
                    <th class="text-center bg-blue-1 text-white">No</th>
                    <th class="text-center bg-blue-2 text-white">Waktu Masuk</th>
                    <th class="text-center bg-blue-1 text-white">Plat Nomor</th>
                    <th class="text-center bg-blue-2 text-white">Pemilik</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <div class="d-flex align-items-center mt-2 pb-2 border-bottom border-black">
        <span class="fs-2 fw-bold me-3">KELUAR</span>
    </div>
    <div>
        <table id="tableKeluar" class="table table-secondary table-striped display nowrap">
            <thead>
                <tr>
                    <th class="text-center bg-blue-1 text-white">No</th>
                    <th class="text-center bg-blue-2 text-white">Waktu Masuk</th>
                    <th class="text-center bg-blue-1 text-white">Waktu Keluar</th>
                    <th class="text-center bg-blue-2 text-white">Plat Nomor</th>
                    <th class="text-center bg-blue-1 text-white">Durasi</th>
                    <th class="text-center bg-blue-2 text-white">Total</th>
                    <th class="text-center bg-blue-1 text-white">Aksi</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <div class="d-flex align-items-center mt-2 pb-2 border-bottom border-black">
        <span class="fs-2 fw-bold me-3">LOG</span>
    </div>
    <div>
        <table id="tableLog" class="table table-secondary table-striped display nowrap">
            <thead>
                <tr>
                    <th class="text-center bg-blue-1 text-white">No</th>
                    <th class="text-center bg-blue-2 text-white">Waktu Masuk</th>
                    <th class="text-center bg-blue-1 text-white">Waktu Keluar</th>
                    <th class="text-center bg-blue-2 text-white">Plat Nomor</th>
                    <th class="text-center bg-blue-1 text-white">Pemilik</th>
                    <th class="text-center bg-blue-2 text-white">Durasi</th>
                    <th class="text-center bg-blue-1 text-white">Total</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function(){
        $.ajax({
            url: 'petugas/get-masuk',
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#tableMasuk').DataTable({
                    data: data,
                    columnDefs: [
                        {
                            targets: 0,
                            searchable: false,
                            className: 'text-center',
                            render: function(data, type, row, meta){
                                return meta.row + 1;
                            }
                        },
                    ],
                    columns: [
                        {data: null},
                        {data: 'waktu_masuk'},
                        {data: 'plat_nomor'},
                        {data: 'pemilik'},
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
        })
        $.ajax({
            url: 'petugas/get-keluar',
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#tableKeluar').DataTable({
                    data: data,
                    columnDefs: [
                        {
                            targets: 0,
                            searchable: false,
                            className: 'text-center',
                            render: function(data, type, row, meta){
                                return meta.row + 1;
                            }
                        },
                        {
                            targets: 4,
                            className: 'text-center',
                            render: function(data){
                                return `${data} jam`
                            }
                        },
                        {
                            targets: 5,
                            className: 'text-center',
                            render: function(data){
                                return 'Rp' + Number(data).toLocaleString('id-ID') + ',00';
                            }
                        },
                        {
                            targets: 6,
                            orderable: false,
                            searchable: false,
                            className: 'text-center',
                            render: function(data){
                                return `
                                    <a href="/petugas/cetak/${data}" class="px-2 py-1 rounded text-white text-decoration-none fw-bold bg-blue-1">Cetak Struk</i></a>
                                    <a href="/petugas/selesai/${data}" class="px-2 py-1 rounded text-white text-decoration-none fw-bold bg-blue-2">Buka Portal</a>
                                `
                            }
                        }
                    ],
                    columns: [
                        {data: null},
                        {data: 'waktu_masuk'},
                        {data: 'waktu_keluar'},
                        {data: 'plat_nomor'},
                        {data: 'durasi'},
                        {data: 'total'},
                        {data: 'id_transaksi'},
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
        })
        $.ajax({
            url: 'petugas/get-log',
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#tableLog').DataTable({
                    data: data,
                    columnDefs: [
                        {
                            targets: 0,
                            searchable: false,
                            className: 'text-center',
                            render: function(data, type, row, meta){
                                return meta.row + 1;
                            }
                        },
                        {
                            targets: 5,
                            className: 'text-center',
                            render: function(data){
                                return `${data} jam`
                            }
                        },
                        {
                            targets: 6,
                            className: 'text-center',
                            render: function(data){
                                return 'Rp' + Number(data).toLocaleString('id-ID') + ',00';
                            }
                        },
                    ],
                    columns: [
                        {data: null},
                        {data: 'waktu_masuk'},
                        {data: 'waktu_keluar'},
                        {data: 'plat_nomor'},
                        {data: 'pemilik'},
                        {data: 'durasi'},
                        {data: 'total'},
                    ],
                    language: {
                        search: "<i class='fa-solid fa-magnifying-glass'></i>",
                        lengthMenu: "Tampilkan _MENU_ data",
                        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                        infoEmpty: "Data tidak ditemukan",
                        infoFiltered: "(disaring dari total _MAX_ data)",
                        zeroRecords: "Tidak ada Data",
                        paginate: {
                            first: "<i class='fa-solid fa-angles-left'></i>",
                            last: "<i class='fa-solid fa-angles-right'></i>",
                            next: "<i class='fa-solid fa-angle-right'></i>",
                            previous: "<i class='fa-solid fa-angle-left'></i>"
                        }
                    }
                })
            }
        })
    })
</script>