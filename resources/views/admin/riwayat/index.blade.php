@extends('layouts.template')
@section('title', 'Riwayat Konsultasi')
@section('content')
    <div class="card">
        <div class="card-header">Riwayat User Konsultasi</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" id="table_riwayat">
                    <thead>
                        <tr>
                            <th class="text-center">KODE</th>
                            <th class="text-center">NAMA</th>
                            <th class="text-center">SIMILARITY</th>
                            <th class="text-center">REKOMENDASI PRODI</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('css')
<style>
    .aksi-buttons {
        display: flex;
        justify-content: center;
        gap: 5px;
    }
    .btn-xs {
        padding: 4px 8px;
        font-size: 12px;
    }

    /* Responsif agar scroll horizontal di mobile */
    .dataTables_wrapper {
        overflow-x: auto;
    }

    table.dataTable {
        width: 100% !important;
    }
</style>
@endpush

@push('js')
<script>
$(document).ready(function() {
    var datariwayat = $('#table_riwayat').DataTable({
        serverSide: true,
        responsive: true,
        ajax: {
            url: "{{ url('riwayat-konsultasi/list') }}",
            dataType: "json",
            type: "POST",
            data: function(d) {
                d.id_kriteria = $('#id_riwayat').val();
            },
            error: function(xhr, error, thrown) {
                console.error('Error fetching data: ', thrown);
            }
        },
        columns: [
            { data: "kd_kasus_lama", className: "text-center" },
            { data: "nama", className: "text-center" },
            { data: "similarity", className: "text-center" },
            { data: "nama_prodi", className: "text-center" },
        ],
        pagingType: "simple_numbers",
        dom: 'frtip',
        language: {
            search: ""
        }
    });

    // Placeholder untuk input pencarian
    $('input[type="search"]').attr('placeholder', 'Cari data riwayat konsultasi...');
});
</script>
@endpush