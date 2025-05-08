@extends('layouts.template')
@section('title', 'Kelola Pertanyaan Kecerdasan')
@section('content')
    <div class="card">
        <div class="card-header">Kelola Pertanyaan Kecerdasan</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" id="table_pertanyaan">
                    <thead>
                        <tr>
                            <th class="text-center">PERTANYAAN</th>
                            <th class="text-center">JENIS KECERDASAN</th>
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
        var datapertanyaan = $('#table_pertanyaan').DataTable({
            serverSide: true,
            ajax: {
                "url": "{{ url('pertanyaan_kecerdasan/list') }}",
                "dataType": "json",
                "type": "POST",
                "data": function(d) {
                    d.id_pertanyaan_kecerdasan = $('#id_pertanyaan_kecerdasan').val();
                },
                "error": function(xhr, error, thrown) {
                    console.error('Error fetching data: ', thrown);
                }
            },
            columns: [
                { data: "pertanyaan" },
                { data: "kecerdasan_majemuk.nama_kecerdasan" },
                {
                    data: "id_pertanyaan_kecerdasan",
                    render: function(data, type, row) {
                        var editUrl = '{{ route('admin.pertanyaan_kecerdasan.edit', ':id') }}'.replace(':id', data);
                        var deleteUrl = '{{ route('admin.pertanyaan_kecerdasan.destroy', ':id') }}'.replace(':id', data);
                        return `
                <div class="aksi-buttons">
                    <a href="${editUrl}" class="btn btn-primary btn-xs">
                        <i class="fas fa-edit"></i>
                    </a>
                    <button class="btn btn-danger btn-xs btn-delete-pertanyaan" data-id="${data}" data-url="${deleteUrl}">
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

        $(document).on('click', '.btn-delete-pertanyaan', function() {
            var pertanyaanId = $(this).data('id');
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Data pertanyaan kecerdasan ini akan dihapus secara permanen!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('admin.pertanyaan_kecerdasan.destroy', ':id') }}'.replace(':id', pertanyaanId),
                        type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "_method": "DELETE"
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire('Berhasil!', response.message, 'success');
                                datapertanyaan.ajax.reload();
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

        // Filter berdasarkan
        $('#id_kecerdasan_majemuk').on('change', function() {
            datapertanyaan.ajax.reload();
        });

        // Placeholder pada search
        $('input[type="search"]').attr('placeholder', 'Cari data pertanyaan kecerdasan...');
    });
</script>
@endpush
