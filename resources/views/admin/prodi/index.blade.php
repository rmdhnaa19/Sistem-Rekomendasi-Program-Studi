@extends('layouts.template')
@section('title', 'Kelola Program Studi')
@section('content')
    <div class="card">
        <div class="card-header">Kelola Program Studi</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" id="table_prodi">
                    <thead>
                        <tr>
                            <th class="text-center">KODE PRODI</th>
                            <th class="text-center">NAMA PRODI</th>
                            <th class="text-center">JURUSAN</th>
                            <th class="text-center">AKREDITASI</th>
                            <th class="text-center">JENJANG</th>
                            <th class="text-center">DURASI STUDI</th>
                            <th class="text-center">DESKRIPSI</th>
                            <th class="text-center">AKSI</th>
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
        var dataProdi = $('#table_prodi').DataTable({
            serverSide: true,
            ajax: {
                "url": "{{ url('prodi/list') }}",
                "dataType": "json",
                "type": "POST",
                "data": function(d) {
                    d.id_prodi = $('#id_prodi').val();
                },
                "error": function(xhr, error, thrown) {
                    console.error('Error fetching data: ', thrown);
                }
            },
            columns: [
                { data: "kd_prodi" },
                { data: "nama_prodi" },
                { data: "jurusan.nama_jurusan" },
                { data: "akreditasi" },
                { data: "jenjang" },
                { data: "durasi_studi" },
                { 
        data: "deskripsi",
        render: function(data, type, row) {
            return `<div class="text-justify" style="text-align: justify;">${data}</div>`;
        }
    },
                {
                    data: "id_prodi",
                    render: function(data, type, row) {
                        var editUrl = '{{ route('admin.prodi.edit', ':id') }}'.replace(':id', data);
                        var deleteUrl = '{{ route('admin.prodi.destroy', ':id') }}'.replace(':id', data);
                        return `
                <div class="aksi-buttons">
                    <a href="${editUrl}" class="btn btn-primary btn-xs">
                        <i class="fas fa-edit"></i>
                    </a>
                    <button class="btn btn-danger btn-xs btn-delete-prodi" data-id="${data}" data-url="${deleteUrl}">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `;
        }
    }
],
            pagingType: "simple_numbers",
            dom: 'frtip',
            language: {
                search: ""
            }
        });

        $(document).on('click', '.btn-delete-prodi', function() {
            var prodiId = $(this).data('id');
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
                    $.ajax({
                        // url: '{{ url('prodi/destroy') }}/' + prodiId,
                        url: '{{ route('admin.prodi.destroy', ':id') }}'.replace(':id', prodiId),
                        type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "_method": "DELETE"
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire('Berhasil!', response.message, 'success');
                                dataProdi.ajax.reload();
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
