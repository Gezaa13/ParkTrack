<title>Kendaraan</title>
<div class="container-fluid">
    <div class="mt-2">
        <a href="/admin/kendaraan/tambah" class="bg-blue-1 p-2 rounded text-white text-decoration-none">
            <i class="fa-solid fa-plus"></i>
            <span class="fw-bold">Tambah Kendaraan</span>
        </a>
    </div>
    <div class="mt-3">
        <table id="table" class="table table-secondary table-striped">
            <thead>
                <tr>
                    <th class="bg-blue-1 text-white text-center">No</th>
                    <th class="bg-blue-2 text-white text-center">ID</th>
                    <th class="bg-blue-2 text-white text-center">Plat Nomor</th>
                    <th class="bg-blue-1 text-white text-center">Pemilik</th>
                    <th class="bg-blue-2 text-white text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function(){
        $.ajax({
            url: 'kendaraan/get',
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#table').DataTable({
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
                            targets: 1,
                            className: 'text-center',
                        },
                        {
                            targets: 4,
                            searchable: false,
                            orderable: false,
                            className: 'text-center',
                            render: function(data, type, row, meta){
                                if (row.status_aktif == 1) {
                                    var tombolStatus = `<a href="/admin/kendaraan/aktivasi/${row.id_kartu}" class="bg-danger p-2 text-white rounded text-decoration-none fw-bold">Nonaktifkan</a>`;
                                } else {
                                    var tombolStatus = `<a href="/admin/kendaraan/aktivasi/${row.id_kartu}" class="bg-blue-1 p-2 text-white rounded text-decoration-none fw-bold">Aktifkan</a>`;
                                }

                                return `
                                    ${tombolStatus}
                                    <a href="/admin/kendaraan/ubah/${row.id_kartu}" class="p-2 bg-blue-1 text-white rounded"><i class="fa-solid fa-pen"></i></a>
                                `;
                            }
                        }
                    ],
                    columns: [
                        {data: null},
                        {data: 'id_kartu'},
                        {data: 'plat_nomor'},
                        {data: 'pemilik'},
                        {data: null},
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
    })
</script>