@extends('layouts.template')
@section('title', 'Jurusan Asal')
@section('content')
    <div class="card">
        <div class="card-header">Kelola Jurusan Asal</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" id="table_jurusan_asal">
                    <thead>
                        <tr>
                            <th class="text-center">KRITERIA</th>
                            <th class="text-center">NAMA JURUSAN ASAL</th>
                            <th class="text-center">NILAI INDEX</th>
                            <th style="width: 120px;" class="text-center">AKSI</th> 
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
    var datajurusan_asal = $('#table_jurusan_asal').DataTable({
        serverSide: true,
        responsive: true, // Tambahkan responsif
        ajax: {
            "url": "{{ url('jurusan_asal/list') }}",
            "dataType": "json",
            "type": "POST",
            "data": function(d) {
                d.id_kriteria = $('#id_jurusan_asal').val();
            },
            "error": function(xhr, error, thrown) {
                console.error('Error fetching data: ', thrown);
            }
        },
        columns: [
            { data: "kriteria.nama_kriteria", className: "text-center" },
            { data: "nama", className: "text-center"},
            { data: "nilai", className: "text-center"},
            { 
                data: "id_jurusan_asal",
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    var editUrl = '{{ route('admin.jurusan_asal.edit', ':id') }}'.replace(':id', data);
                    var deleteUrl = '{{ route('admin.jurusan_asal.destroy', ':id') }}'.replace(':id', data);
                    return `
                        <div class="aksi-buttons">
                            <a href="${editUrl}" class="btn btn-primary btn-xs">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button class="btn btn-danger btn-xs btn-delete-jurusan_asal" data-id="${data}" data-url="${deleteUrl}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    `;
                }
            }
        ],
        columnDefs: [
            { width: "120px", targets: 3 } 
        ],
        pagingType: "simple_numbers",
        dom: 'frtip',
        language: {
            search: ""
        }
    });

    // Event listener untuk tombol Hapus
    $(document).on('click', '.btn-delete-jurusan_asal', function() {
        var jurusan_asalId = $(this).data('id');
        var deleteUrl = $(this).data('url');

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Data jurusan asal ini akan dihapus secara permanen!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: deleteUrl,
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "_method": "DELETE"
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: response.message,
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: true
                            }).then(() => {
                                datajurusan_asal.ajax.reload(); // Reload tabel setelah hapus
                            });
                        } else {
                            Swal.fire({
                                title: 'Gagal!',
                                text: response.message,
                                icon: 'error'
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Terjadi kesalahan saat menghapus data.',
                            icon: 'error'
                        });
                    }
                });
            }
        });
    });

    // Tambahkan tombol "Tambah"
    $("#table_jurusan_asal_filter").append('<button id="btn-tambah" class="btn btn-primary ml-2">Tambah</button>');

    // Event listener untuk tombol "Tambah"
    $("#btn-tambah").on('click', function() {
        window.location.href = "{{ url('jurusan_asal/create') }}";
    });

    // Placeholder untuk input pencarian
    $('input[type="search"]').attr('placeholder', 'Cari data jurusan asal...');
});
</script>
@endpush