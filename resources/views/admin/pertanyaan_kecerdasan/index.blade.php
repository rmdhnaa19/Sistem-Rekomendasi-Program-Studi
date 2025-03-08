@extends('layouts.template')
@section('title', 'Kelola Pertanyaan Kecerdasan')
@section('content')
    <div class="card">
        <div class="card-header">Kelola Pertanyaan Kecerdasan</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" id="table_pertanyaan">
                    <thead>
                        <tr class="text-center">
                            <th style="width: 70%;">PERTANYAAN</th>
                            <th style="width: 30%;">JENIS KECERDASAN</th>
                        </tr>
                    </thead>
                </table>
        </div>
        </div>
    </div>

    {{-- Modal --}}
    <div class="modal fade text-left" id="pertanyaanDetailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content" style="border-radius: 15px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title white">Detail Pertanyaan Kecerdasan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="pertanyaan-detail-content" class="container-fluid">
                        <div class="text-center mb-3">
                            <h4 class="mb-4"></h4>
                        </div>
                        <div class="row">
                            <div class="col-md-7">
                                <div style="max-height: 30vh; overflow-y: auto;">
                                    <p><strong>Pertanyaan :</strong> <span id="pertanyaan_kecerdasan-pertanyaan"></span></p>
                                    <p><strong>Jenis Kecerdasan :</strong> <span id="pertanyaan_kecerdasan-kecerdasan_majemuk"></span></p>
                                    <p><strong>Deskripsi :</strong> <span id="pertanyaan_kecerdasan-deskripsi"></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <div class="modal-footer" style="border-bottom-left-radius: 15px; border-bottom-right-radius: 15px;">
                <button type="button" class="btn btn-danger" id="btn-delete-pertanyaan">Hapus</button>
                <button type="button" class="btn btn-primary" id="btn-edit-pertanyaan">Edit</button>
            </div>     
        </div>
    </div>
    </div>
@endsection
@push('css')
@endpush
@push('js')
    <script>
    $(document).ready(function() {
        var currentPertanyaanId = null; // Variabel global untuk menyimpan ID pertanyaan saat ini

        var dataPertanyaan = $('#table_pertanyaan').DataTable({
            serverSide: true,
            ajax: {
                "url": "{{ url('pertanyaan_kecerdasan/list') }}",
                "dataType": "json",
                "type": "POST",
                "data": function(d) {
                    d.id_kecerdasan_majemuk = $('#id_kecerdasan_majemuk').val();
                },
                "error": function(xhr, error, thrown) {
                    console.error('Error fetching data: ', thrown);
                }
            },
            columns: [
                {
                    data: "pertanyaan",
                    render: function(data, type, row) {
                        var url = '{{ route('admin.pertanyaan_kecerdasan.show', ':id') }}';
                        url = url.replace(':id', row.id_pertanyaan_kecerdasan);
                        return '<a href="javascript:void(0);" data-id="' + row.id_pertanyaan_kecerdasan +
                            '" class="view-pertanyaan-details" data-url="' + url +
                            '" data-toggle="modal" data-target="#pertanyaanDetailModal">' + data + '</a>';
                    }
                },
                { data: "kecerdasan_majemuk.nama_kecerdasan" },
            ],
            pagingType: "simple_numbers",
            dom: 'frtip',
            language: {
                search: ""
            }
        });

        // Event listener untuk menampilkan detail pertanyaan
        $(document).on('click', '.view-pertanyaan-details', function() {
            var url = $(this).data('url');
            currentPertanyaanId = $(this).data('id'); // Simpan ID pertanyaan saat ini
            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    if (response.html) {
                        $('#pertanyaan-detail-content').html(response.html);
                        $('#pertanyaanDetailModal').modal('show');
                    } else {
                        alert('Gagal memuat detail pertanyaan');
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    alert('Gagal memuat detail pertanyaan');
                }
            });
        });

        // Tombol Edit
        $(document).on('click', '#btn-edit-pertanyaan', function() {
            if (currentPertanyaanId) {
                const editUrl = '{{ route('admin.pertanyaan_kecerdasan.edit', ':id') }}'.replace(':id', currentPertanyaanId);
                window.location.href = editUrl; // Redirect ke halaman edit
            } else {
                alert('ID pertanyaan tidak ditemukan');
            }
        });

        // Delete button
    $(document).on('click', '#btn-delete-pertanyaan', function() {
        if (currentPertanyaanId) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Data pertanyaan ini akan dihapus secara permanen!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    var deleteUrl = '{{ route('admin.pertanyaan_kecerdasan.destroy', ':id') }}'
                        .replace(':id', currentPertanyaanId);
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
                                    window.location.href = "{{ route('admin.pertanyaan_kecerdasan.index') }}";
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
        } else {
            Swal.fire({
                title: 'Error!',
                text: 'ID pertanyaan tidak ditemukan',
                icon: 'error'
            });
        }
    });

        // Tambahkan tombol "Tambah" setelah kolom pencarian
        $("#table_pertanyaan_filter").append(
            '<select class="form-control" name="id_kecerdasan_majemuk" id="id_kecerdasan_majemuk" style="margin-left: 30px; width: 150px;">' +
            '<option value="">- SEMUA -</option>' +
            '@foreach ($kecerdasan_majemuk as $item)' +
            '<option value="{{ $item->id_kecerdasan_majemuk }}">{{ $item->nama_kecerdasan }}</option>' +
            '@endforeach' +
            '</select>' +
            '<button id="btn-tambah" class="btn btn-primary ml-2">Tambah</button>'
        );

        // Event listener untuk tombol tambah
        $("#btn-tambah").on('click', function() {
            window.location.href = "{{ url('pertanyaan_kecerdasan/create') }}";
        });

        // Filter berdasarkan jenis kecerdasan
        $('#id_kecerdasan_majemuk').on('change', function() {
            dataPertanyaan.ajax.reload();
        });

        // Placeholder pada search
        $('input[type="search"]').attr('placeholder', 'Cari data pertanyaan...');
    });
</script>
@endpush
