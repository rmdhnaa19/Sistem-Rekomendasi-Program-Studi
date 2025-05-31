@extends('layouts.template')
@section('title', 'Kelola Kecerdasan Majemuk')
@section('content')
    <div class="card">
        <div class="card-header">Kelola Kecerdasan Majemuk</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" id="table_kecerdasan">
                    <thead>
                        <tr>
                            <th style="width: 200px;" class="text-center">JENIS KECERDASAN</th>
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
        flex-wrap: wrap;
    }

    .btn-xs {
        padding: 4px 8px;
        font-size: 12px;
    }

    @media screen and (max-width: 576px) {
        .aksi-buttons {
            flex-direction: column;
            align-items: center;
        }
    }
</style>
@endpush

@push('js')
<script>
$(document).ready(function() {
    var datakecerdasan = $('#table_kecerdasan').DataTable({
        serverSide: true,
        ajax: {
            url: "{{ url('kecerdasan_majemuk/list') }}",
            dataType: "json",
            type: "POST",
            data: function(d) {
                d.id_kecerdasan_majemuk = $('#id_kecerdasan_majemuk').val();
            },
            error: function(xhr, error, thrown) {
                console.error('Error fetching data: ', thrown);
            }
        },
        columns: [
            { data: "nama_kecerdasan" },
            { 
                data: "deskripsi",
                render: function(data, type, row) {
                    return `<div class="text-justify" style="text-align: justify;">${data}</div>`;
                }
            },
            { 
                data: "id_kecerdasan_majemuk",
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    var editUrl = '{{ route('admin.kecerdasan_majemuk.edit', ':id') }}'.replace(':id', data);
                    var deleteUrl = '{{ route('admin.kecerdasan_majemuk.destroy', ':id') }}'.replace(':id', data);
                    return `
                        <div class="aksi-buttons">
                            <a href="${editUrl}" class="btn btn-primary btn-xs" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button class="btn btn-danger btn-xs btn-delete-kecerdasan" data-id="${data}" data-url="${deleteUrl}" title="Hapus">
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

    // Event listener tombol hapus
    $(document).on('click', '.btn-delete-kecerdasan', function() {
        var kecerdasanId = $(this).data('id');
        var deleteUrl = $(this).data('url');

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Data kecerdasan majemuk ini akan dihapus secara permanen!',
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
                                datakecerdasan.ajax.reload();
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

    // Tombol tambah data
    $("#table_kecerdasan_filter").append('<button id="btn-tambah" class="btn btn-primary ml-2">Tambah</button>');

    $("#btn-tambah").on('click', function() {
        window.location.href = "{{ url('kecerdasan_majemuk/create') }}";
    });

    // Placeholder input pencarian
    $('input[type="search"]').attr('placeholder', 'Cari data kecerdasan majemuk...');
});
</script>
@endpush
