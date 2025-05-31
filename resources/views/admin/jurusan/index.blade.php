@extends('layouts.template')
@section('title', 'Jurusan')
@section('content')
    <div class="card">
        <div class="card-header">Kelola Jurusan</div>
        <div class="card-body">
            <div class="table-responsive"> <!-- Tambahkan wrapper responsif -->
                <table class="table" id="table_jurusan">
                    <thead>
                        <tr>
                            <th style="width: 300px;" class="text-center">NAMA JURUSAN</th>
                            <th class="text-center">DESKRIPSI</th>
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
</style>
@endpush

@push('js')
<script>
$(document).ready(function() {
    var datajurusan = $('#table_jurusan').DataTable({
        serverSide: true,
        ajax: {
            "url": "{{ url('jurusan/list') }}",
            "type": "POST",
            "dataType": "json",
            "data": function(d) {
                d.id_jurusan = $('#id_jurusan').val(); // placeholder, bisa dihapus jika tidak dipakai
            },
            "error": function(xhr, error, thrown) {
                console.error('Error fetching data:', thrown);
            }
        },
        columns: [
            { data: "nama_jurusan", className: "text-center" },
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
            { width: "120px", targets: 2 }
        ],
        pagingType: "simple_numbers",
        dom: 'frtip',
        language: {
            search: ""
        }
    });

    // Event tombol hapus
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
                            Swal.fire('Berhasil!', response.message, 'success').then(() => {
                                datajurusan.ajax.reload();
                            });
                        } else {
                            Swal.fire('Gagal!', response.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        Swal.fire('Error!', 'Terjadi kesalahan saat menghapus data.', 'error');
                    }
                });
            }
        });
    });

    // Tambahkan tombol Tambah
    $("#table_jurusan_filter").append(
        '<button id="btn-tambah" class="btn btn-primary ml-2">Tambah</button>'
    );

    $('#btn-tambah').on('click', function() {
        window.location.href = "{{ url('jurusan/create') }}";
    });

    // Placeholder pencarian
    $('input[type="search"]').attr('placeholder', 'Cari data jurusan...');
});
</script>
@endpush
