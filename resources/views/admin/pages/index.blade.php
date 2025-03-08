@extends('layouts.template')
@section('title', 'Kelola Halaman')
@section('content')
    <div class="card">
        <div class="card-header">Kelola Halaman</div>
        <div class="card-body">
            <table class="table" id="table_pages">
                <thead>
                    <tr>
                        <th style="width: 180px;" class="text-center">JUDUL</th>
                        <th style="width: 120px;" class="text-center">SLUG</th>
                        <th style="width: 300px;" class="text-center">KONTEN</th>
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
    var dataPages = $('#table_pages').DataTable({
        serverSide: true,
        ajax: {
            "url": "{{ url('pages/list') }}",
            "dataType": "json",
            "type": "POST",
            "error": function(xhr, error, thrown) {
                console.error('Error fetching data: ', thrown);
            }
        },
        columns: [
            { data: "title", className: "text-center" },
            { data: "slug", className: "text-center" },
            { data: "content", className: "text-center" },
            { 
                data: "id_pages",
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    var showUrl = '{{ route('admin.pages.show', ':id') }}'.replace(':id', data);
                    var editUrl = '{{ route('admin.pages.edit', ':id') }}'.replace(':id', data);
                    var deleteUrl = '{{ route('admin.pages.destroy', ':id') }}'.replace(':id', data);
                    return `
                        <div class="aksi-buttons">
                            <a href="${showUrl}" class="btn btn-info btn-xs">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="${editUrl}" class="btn btn-warning btn-xs">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button class="btn btn-danger btn-xs btn-delete-page" data-id="${data}" data-url="${deleteUrl}">
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

    $(document).on('click', '.btn-delete-page', function() {
        var pageId = $(this).data('id');
        var deleteUrl = $(this).data('url');

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Halaman ini akan dihapus secara permanen!',
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
                                dataPages.ajax.reload();
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

    $("#table_pages_filter").append('<button id="btn-tambah" class="btn btn-primary ml-2">Tambah</button>');

    $("#btn-tambah").on('click', function() {
        window.location.href = "{{ route('admin.pages.create') }}";
    });

    $('input[type="search"]').attr('placeholder', 'Cari halaman...');
});
</script>
@endpush