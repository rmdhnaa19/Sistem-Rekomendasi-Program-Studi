@extends('layouts.template')
@section('title', 'Kelola Jurusan')
@section('content')
    <div class="card">
        <div class="card-header">Data Jurusan</div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success" id="success-alert">
                    {{ session('success') }}
                </div>
            @endif
            <table class="table mb-3" id="table_jurusan">
                <thead>
                    <tr>
                        <th style="display: none">ID</th>
                        <th class="text-center">NAMA JURUSAN</th>
                        <th class="text-center">DESKRIPSI</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div> 

    {{-- Modal --}}
    <div class="modal fade text-left" id="jurusanDetailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content" style="border-radius: 15px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title white">Detail Jurusan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="jurusan-detail-content" class="container-fluid">
                        <div class="text-center mb-3">
                            <h4 class="mb-4"></h4>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                {{-- Tambahkan gambar jika diperlukan --}}
                            </div>
                            <div class="col-md-7">
                                <div style="max-height: 30vh; overflow-y: auto;">
                                    <p><strong>Nama Jurusan :</strong> <span id="jurusan-nama_jurusan"></span></p>
                                    <p><strong>Deskripsi :</strong> <span id="jurusan-deskripsi"></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="btn-delete-jurusan">Hapus</button>
                    <button type="button" class="btn btn-primary" id="btn-edit-jurusan">Edit</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
<style>
    .text-justify {
        text-align: justify;
    }
</style>
@endpush

@push('js')
<script>
    var currentJurusanId;

    $(document).ready(function() {
        var datajurusan = $('#table_jurusan').DataTable({
            serverSide: true,
            ajax: {
                "url": "{{ url('jurusan/list') }}",
                "type": "POST",
                "error": function(xhr, error, thrown) {
                    console.error('Error fetching data:', thrown);
                }
            },
            columns: [
                { data: "id_jurusan", visible: false },
                { 
                    data: "nama_jurusan", 
                    className: "col-md-3 text-center",
                    orderable: true,
                    render: function(data, type, row) {
                        var url = '{{ route('admin.jurusan.show', ':id') }}'.replace(':id', row.id_jurusan);
                        return '<a href="javascript:void(0);" data-id="' + row.id_jurusan + '" class="view-jurusan-details" data-url="' + url + '" data-toggle="modal" data-target="#jurusanDetailModal">' + data + '</a>';
                    }
                },
                { 
                    data: "deskripsi",
                    className: "col-md-7 text-justify",
                    orderable: true
                },
            ],
            pagingType: "simple_numbers",
            dom: 'frtip',
            language: { search: "" }
        });

        // Event listener untuk menampilkan detail jurusan
        $(document).on('click', '.view-jurusan-details', function() {
            var url = $(this).data('url');
            currentJurusanId = $(this).data('id');

            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    if (response.html) {
                        $('#jurusan-detail-content').html(response.html);
                        $('#jurusanDetailModal').modal('show');
                    } else {
                        alert('Gagal memuat detail jurusan');
                    }
                },
                error: function(xhr) {
                    alert('Gagal memuat detail jurusan');
                }
            });
        });

        // Event listener untuk tombol Edit
        $(document).on('click', '#btn-edit-jurusan', function() {
            if (currentJurusanId) {
                var editUrl = '{{ route('admin.jurusan.edit', ':id') }}'.replace(':id', currentJurusanId);
                window.location.href = editUrl;
            } else {
                alert('ID jurusan tidak ditemukan');
            }
        });

        // Event listener untuk tombol Hapus
        $(document).on('click', '#btn-delete-jurusan', function() {
            if (currentJurusanId) {
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
                        var deleteUrl = '{{ route('admin.jurusan.destroy', ':id') }}'.replace(':id', currentJurusanId);
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
                                        timer: 2000
                                    }).then(() => {
                                        window.location.href = "{{ route('admin.jurusan.index') }}";
                                    });
                                } else {
                                    Swal.fire('Gagal!', 'Gagal menghapus data jurusan.', 'error');
                                }
                            },
                            error: function() {
                                Swal.fire('Error!', 'Terjadi kesalahan saat menghapus data.', 'error');
                            }
                        });
                    }
                });
            } else {
                Swal.fire('Error!', 'ID jurusan tidak ditemukan', 'error');
            }
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
