@extends('layouts.template')
@section('title', 'Hasil Normalisasi')
@section('content')
    <div class="card">
        <div class="card-header">Hasil Normalisasi</div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success" id="success-alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table mb-3" id="table_normalisasi">
                    <thead>
                        <tr>
                            <th class="text-center">KODE KASUS</th>              
                            <th class="text-center">JURUSAN ASAL</th>
                            <th class="text-center">NILAI RAPORT</th>
                            <th class="text-center">PRESTASI</th>
                            <th class="text-center">ORGANISASI</th>
                            <th class="text-center">LINGUISTIK</th>
                            <th class="text-center">MUSIKAL</th>
                            <th class="text-center">LOGIK</th>
                            <th class="text-center">SPASIAL</th>
                            <th class="text-center">KINESTETIK</th>
                            <th class="text-center">INTERPERSONAL</th>
                            <th class="text-center">INTRAPERSONAL</th>
                            <th class="text-center">NATURALIS</th>
                            <th class="text-center">EKSISTENSIAL</th>
                            <th class="text-center">ID PRODI</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script>
    $(document).ready(function() {
        $('#table_normalisasi').DataTable({
            serverSide: true,
            processing: true,
            ajax: {
                url: "{{ url('normalisasi/list') }}",
                type: "POST",
                data: function(d) {
                    d._token = "{{ csrf_token() }}";
                },
                error: function(xhr, error, thrown) {
                    console.error('Error fetching data: ', thrown);
                }
            },
            columns: [
                { data: "kd_kasus_lama" },
                { data: "jurusan_asal"},
                { data: "nilai_rata_rata_rapor"},
                { data: "prestasi"},
                { data: "organisasi"},
                { data: "kec_linguistik"},
                { data: "kec_musikal"},
                { data: "kec_logika_matematis"},
                { data: "kec_spasial"},
                { data: "kec_kinestetik"},
                { data: "kec_interpersonal"},
                { data: "kec_intrapersonal"},
                { data: "kec_naturalis"},
                { data: "kec_eksistensial"},
                { data: "id_prodi"}
            ],
            pagingType: "simple_numbers",
            dom: '<"top"f>rt<"bottom"lp><"clear">',
            language: {
                search: "",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoFiltered: "(disaring dari _MAX_ data)",
                zeroRecords: "Tidak ada data yang ditemukan",
                emptyTable: "Data tidak tersedia"
            }
        });

        // Placeholder untuk input pencarian
        $('input[type="search"]').attr('placeholder', 'Cari data normalisasi...');
    });
</script>    
@endpush