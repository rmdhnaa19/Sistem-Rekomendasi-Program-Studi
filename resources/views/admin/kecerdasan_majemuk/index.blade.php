@extends('layouts.template')
@section('title', 'Kelola Kecerdasan Majemuk')
@section('content')
    <div class="card">
        <div class="card-header">Data Kecerdasan Majemuk</div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success" id="success-alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="table-responsive">
            <table class="table mb-3" id="table_kecerdasan_majemuk">
                <thead>
                    <tr>
                        <th style="display: none">ID</th>
                        <th class="text-center">JENIS KECERDASAN</th>
                        <th class="text-center">DESKRIPSI</th>
                    </tr>
                </thead>
            </table>
            </div>
        </div>
    </div> 

    {{-- Modal --}}
    <div class="modal fade text-left" id="kecerdasanDetailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content" style="border-radius: 15px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title white">Detail Kecerdasan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="kecerdasan-detail-content" class="container-fluid">
                        <div class="text-center mb-3">
                            <h4 class="mb-4"></h4>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                {{-- Tambahkan gambar jika diperlukan --}}
                            </div>
                            <div class="col-md-7">
                                <div style="max-height: 30vh; overflow-y: auto;">
                                    <p><strong>Jenis Kecerdasan :</strong> <span id="kecerdasan_majemuk-nama_kecerdasan"></span></p>
                                    <p><strong>Deskripsi :</strong> <span id="kecerdasan_majemuk-deskripsi"></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="btn-delete-kecerdasan_majemuk">Hapus</button>
                    <button type="button" class="btn btn-primary" id="btn-edit-kecerdasan_majemuk">Edit</button>
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
    var currentKecerdasanId;

    $(document).ready(function() {
        var datakecerdasan_majemuk = $('#table_kecerdasan_majemuk').DataTable({
            serverSide: true,
            ajax: {
                "url": "{{ url('kecerdasan_majemuk/list') }}",
                "type": "POST",
                "error": function(xhr, error, thrown) {
                    console.error('Error fetching data:', thrown);
                }
            },
            columns: [
                { data: "id_kecerdasan_majemuk", visible: false },
                { 
                    data: "nama_kecerdasan", 
                    className: "col-md-3 text-center",
                    orderable: true,
                    render: function(data, type, row) {
                        var url = '{{ route('admin.kecerdasan_majemuk.show', ':id') }}'.replace(':id', row.id_kecerdasan_majemuk);
                        return '<a href="javascript:void(0);" data-id="' + row.id_kecerdasan_majemuk + '" class="view-kecerdasan_majemuk-details" data-url="' + url + '" data-toggle="modal" data-target="#kecerdasanDetailModal">' + data + '</a>';
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

        // Event listener untuk menampilkan detail kecerdasan majemuk
        $(document).on('click', '.view-kecerdasan_majemuk-details', function() {
            var url = $(this).data('url');
            currentKecerdasanId = $(this).data('id');

            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    if (response.html) {
                        $('#kecerdasan-detail-content').html(response.html);
                        $('#kecerdasanDetailModal').modal('show');
                    } else {
                        alert('Gagal memuat detail kecerdasan majemuk');
                    }
                },
                error: function(xhr) {
                    alert('Gagal memuat detail kecerdasan majemuk');
                }
            });
        });

        // Event listener untuk tombol Edit
        $(document).on('click', '#btn-edit-kecerdasan_majemuk', function() {
            if (currentKecerdasanId) {
                var editUrl = '{{ route('admin.kecerdasan_majemuk.edit', ':id') }}'.replace(':id', currentKecerdasanId);
                window.location.href = editUrl;
            } else {
                alert('ID kecerdasan majemuk tidak ditemukan');
            }
        });

        // Event listener untuk tombol Hapus
        $(document).on('click', '#btn-delete-kecerdasan_majemuk', function() {
            if (currentKecerdasanId) {
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
                        var deleteUrl = '{{ route('admin.kecerdasan_majemuk.destroy', ':id') }}'.replace(':id', currentKecerdasanId);
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
                                        window.location.href = "{{ route('admin.kecerdasan_majemuk.index') }}";
                                    });
                                } else {
                                    Swal.fire('Gagal!', 'Gagal menghapus data kecerdasan majemuk', 'error');
                                }
                            },
                            error: function() {
                                Swal.fire('Error!', 'Terjadi kesalahan saat menghapus data', 'error');
                            }
                        });
                    }
                });
            } else {
                Swal.fire('Error!', 'ID kecerdasan majemuk tidak ditemukan', 'error');
            }
        });

        // Tambahkan tombol "Tambah"
        $("#table_kecerdasan_majemuk_filter").append('<button id="btn-tambah" class="btn btn-primary ml-2">Tambah</button>');

        // Event listener untuk tombol "Tambah"
        $("#btn-tambah").on('click', function() {
            window.location.href = "{{ url('kecerdasan_majemuk/create') }}";
        });

        // Placeholder untuk input pencarian
        $('input[type="search"]').attr('placeholder', 'Cari data kecerdasan majemuk...');
    });
</script>
@endpush
