@extends('layouts.template')
@section('title', 'Kriteria')
@section('content')
    <div class="card">
        <div class="card-header">Kelola Sub Kriteria</div>
        <div class="card-body">
            <table class="table" id="table_sub_kriteria">
                <thead>
                    <tr>
                        <th class="text-center">KRITERIA</th>
                        <th class="text-center">SUB KRITERIA</th>
                        <th class="text-center">NILAI INDEX</th>
                        <th style="width: 120px;" class="text-center">AKSI</th> 
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@push('css')
<style>
    .aksi-buttons {
        display: flex;
        justify-content: center;
        gap: 5px; /* Jarak antara tombol */
    }
    .btn-xs {
        padding: 4px 8px;
        font-size: 12px;
    }
</style>
@endpush

@push('js')
<script>
$(document).ready(function() {
    var datasub_kriteria = $('#table_sub_kriteria').DataTable({
        serverSide: true,
        ajax: {
            "url": "{{ url('sub_kriteria/list') }}",
            "dataType": "json",
            "type": "POST",
            "data": function(d) {
                d.id_kriteria = $('#id_sub_kriteria').val();
            },
            "error": function(xhr, error, thrown) {
                console.error('Error fetching data: ', thrown);
            }
        },
        columns: [
            { data: "kriteria.nama_kriteria", className: "text-center" },
            { data: "nama_sub", className: "text-center"},
            { data: "nilai", className: "text-center"},
            { 
                data: "id_sub_kriteria",
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    var editUrl = '{{ route('admin.sub_kriteria.edit', ':id') }}'.replace(':id', data);
                    var deleteUrl = '{{ route('admin.sub_kriteria.destroy', ':id') }}'.replace(':id', data);
                    return `
                        <div class="aksi-buttons">
                            <a href="${editUrl}" class="btn btn-primary btn-xs">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button class="btn btn-danger btn-xs btn-delete-sub_kriteria" data-id="${data}" data-url="${deleteUrl}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    `;
                }
            }
        ],
        columnDefs: [
            { width: "120px", targets: 2 } 
        ],
        pagingType: "simple_numbers",
        dom: 'frtip',
        language: {
            search: ""
        }
    });

    // Event listener untuk tombol Hapus
    $(document).on('click', '.btn-delete-sub_kriteria', function() {
        var sub_kriteriaId = $(this).data('id');
        var deleteUrl = $(this).data('url');

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Data sub kriteria ini akan dihapus secara permanen!',
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
                                datasub_kriteria.ajax.reload(); // Reload tabel setelah hapus
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
    $("#table_sub_kriteria_filter").append('<button id="btn-tambah" class="btn btn-primary ml-2">Tambah</button>');

    // Event listener untuk tombol "Tambah"
    $("#btn-tambah").on('click', function() {
        window.location.href = "{{ url('sub_kriteria/create') }}";
    });

    // Placeholder untuk input pencarian
    $('input[type="search"]').attr('placeholder', 'Cari data sub kriteria...');
});
</script>
@endpush
