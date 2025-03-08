@extends('layouts.template')
@section('title', 'Kelola Program Studi')
@section('content')
    <div class="card">
        <div class="card-header">Kelola Program Studi</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" id="table_prodi">
                    <thead>
                        <tr class="text-center">
                            <th>NAMA PRODI</th>
                            <th>JURUSAN</th>
                            <th>AKREDITASI</th>
                            <th>JENJANG</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal --}}
    <div class="modal fade text-left" id="prodiDetailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content" style="border-radius: 15px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title white">Detail Program Studi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="prodi-detail-content" class="container-fluid">
                        <div class="text-center mb-3">
                            <h4 class="mb-4"></h4>
                        </div>
                        <div class="row">
                            <div class="col-md-7">
                                <div style="max-height: 30vh; overflow-y: auto;">
                                    <p><strong>Nama Program Studi :</strong> <span id="prodi-nama_prodi"></span></p>
                                    <p><strong>Jurusan :</strong> <span id="prodi-jurusan"></span></p>
                                    <p><strong>Akreditasi :</strong> <span id="prodi-akreditasi"></span></p>
                                    <p><strong>Jenjang :</strong> <span id="prodi-jenjang"></span></p>
                                    <p><strong>Durasi Studi :</strong> <span id="prodi-durasi_studi"></span></p>
                                    <p><strong>Deskripsi :</strong> <span id="prodi-deskripsi"></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <div class="modal-footer" style="border-bottom-left-radius: 15px; border-bottom-right-radius: 15px;">
                <button type="button" class="btn btn-danger" id="btn-delete-prodi">Hapus</button>
                <button type="button" class="btn btn-primary" id="btn-edit-prodi">Edit</button>
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
        var currentProdiId = null; // Variabel global untuk menyimpan ID prodi saat ini

        var dataProdi = $('#table_prodi').DataTable({
            serverSide: true,
            ajax: {
                "url": "{{ url('prodi/list') }}",
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
                {
                    data: "nama_prodi",
                    render: function(data, type, row) {
                        var url = '{{ route('admin.prodi.show', ':id') }}';
                        url = url.replace(':id', row.id_prodi);
                        return '<a href="javascript:void(0);" data-id="' + row.id_prodi +
                            '" class="view-prodi-details" data-url="' + url +
                            '" data-toggle="modal" data-target="#prodiDetailModal">' + data + '</a>';
                    }
                },
                { data: "jurusan.nama_jurusan" },
                { data: "akreditasi" },
                { data: "jenjang" },
            ],
            pagingType: "simple_numbers",
            dom: 'frtip',
            language: {
                search: ""
            }
        });

        // Event listener untuk menampilkan detail prodi
        $(document).on('click', '.view-prodi-details', function() {
            var url = $(this).data('url');
            currentProdiId = $(this).data('id'); // Simpan ID prodi saat ini
            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    if (response.html) {
                        $('#prodi-detail-content').html(response.html);
                        $('#prodiDetailModal').modal('show');
                    } else {
                        alert('Gagal memuat detail program studi');
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    alert('Gagal memuat detail program studi');
                }
            });
        });

        // Tombol Edit
        $(document).on('click', '#btn-edit-prodi', function() {
            if (currentProdiId) {
                const editUrl = '{{ route('admin.prodi.edit', ':id') }}'.replace(':id', currentProdiId);
                window.location.href = editUrl; // Redirect ke halaman edit
            } else {
                alert('ID program studi tidak ditemukan');
            }
        });

        // Delete button
    $(document).on('click', '#btn-delete-prodi', function() {
        if (currentProdiId) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Data Program Studi ini akan dihapus secara permanen!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    var deleteUrl = '{{ route('admin.prodi.destroy', ':id') }}'
                        .replace(':id', currentProdiId);
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
                                    window.location.href = "{{ route('admin.prodi.index') }}";
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
                text: 'ID program studi tidak ditemukan',
                icon: 'error'
            });
        }
    });

        // Tambahkan tombol "Tambah" setelah kolom pencarian
        $("#table_prodi_filter").append(
            '<select class="form-control" name="id_jurusan" id="id_jurusan" style="margin-left: 30px; width: 150px;">' +
            '<option value="">- SEMUA -</option>' +
            '@foreach ($jurusan as $item)' +
            '<option value="{{ $item->id_jurusan }}">{{ $item->nama_jurusan }}</option>' +
            '@endforeach' +
            '</select>' +
            '<button id="btn-tambah" class="btn btn-primary ml-2">Tambah</button>'
        );

        // Event listener untuk tombol tambah
        $("#btn-tambah").on('click', function() {
            window.location.href = "{{ url('prodi/create') }}";
        });

        // Filter berdasarkan jurusan
        $('#id_jurusan').on('change', function() {
            dataProdi.ajax.reload();
        });

        // Placeholder pada search
        $('input[type="search"]').attr('placeholder', 'Cari data Program Studi...');
    });
</script>
@endpush
