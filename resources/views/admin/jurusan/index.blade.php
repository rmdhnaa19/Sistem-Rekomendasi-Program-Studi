@extends('layouts.template')
@section('title', 'Jurusan')
@section('content')
    <div class="card">
        <div class="card-header">Kelola Jurusan</div>
        <div class="card-body">
            <table class="table" id="table_jurusan">
                <thead>
                    <tr>
                        <th style="width: 300px;" class="text-center">NAMA JURUSAN</th>
                        <th class="text-center">DESKRIPSI</th>
                        <th style="width: 120px;" class="text-center">AKSI</th> <!-- Lebar kolom dipersempit -->
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
    var datajurusan = $('#table_jurusan').DataTable({
        serverSide: true,
        ajax: {
            "url": "{{ url('jurusan/list') }}",
            "dataType": "json",
            "type": "POST",
            "data": function(d) {
                d.id_jurusan = $('#id_jurusan').val();
            },
            "error": function(xhr, error, thrown) {
                console.error('Error fetching data: ', thrown);
            }
        },
        columns: [
    { data: "nama_jurusan" },
    { 
        data: "deskripsi",
        render: function(data, type, row) {
            return `<div class="text-justify" style="text-align: justify;">${data}</div>`;
        }
    },
    { 
        data: "id_jurusan",
        orderable: false,
        searchable: false,
        render: function(data, type, row) {
            var editUrl = '{{ route('admin.jurusan.edit', ':id') }}'.replace(':id', data);
            var deleteUrl = '{{ route('admin.jurusan.destroy', ':id') }}'.replace(':id', data);
            return `
                <div class="aksi-buttons">
                    <a href="${editUrl}" class="btn btn-primary btn-xs">
                        <i class="fas fa-edit"></i>
                    </a>
                    <button class="btn btn-danger btn-xs btn-delete-jurusan" data-id="${data}" data-url="${deleteUrl}">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `;
        }
    }
],
        columnDefs: [
            { width: "120px", targets: 2 } // Mempersempit kolom aksi
        ],
        pagingType: "simple_numbers",
        dom: 'frtip',
        language: {
            search: ""
        }
    });

    // Event listener untuk tombol Hapus
    $(document).on('click', '.btn-delete-jurusan', function() {
        var jurusanId = $(this).data('id');
        var deleteUrl = $(this).data('url');

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Data jurusan ini akan dihapus secara permanen!',
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
                                datajurusan.ajax.reload(); // Reload tabel setelah hapus
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
    $("#table_jurusan_filter").append('<button id="btn-tambah" class="btn btn-primary ml-2">Tambah</button>');

    // Event listener untuk tombol "Tambah"
    $("#btn-tambah").on('click', function() {
        window.location.href = "{{ url('jurusan/create') }}";
    });

    // Placeholder untuk input pencarian
    $('input[type="search"]').attr('placeholder', 'Cari data jurusan...');
});
</script>
@endpush
