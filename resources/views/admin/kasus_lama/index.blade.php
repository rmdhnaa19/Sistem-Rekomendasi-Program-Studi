@extends('layouts.template')
@section('title', 'Kelola Kasus Lama')
@section('content')
    <div class="card">
        <div class="card-header">Data Kasus Lama</div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success" id="success-alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table mb-3" id="table_kasus_lama">
                    <thead>
                        <tr>
                            <th style="display: none">ID</th>
                            <th class="text-center">KODE</th>
                            <th class="text-center">NAMA</th>                
                            <th class="text-center">JURUSAN ASAL</th>
                            <th class="text-center">NILAI RAPORT</th>
                            <th class="text-center">PRESTASI</th>
                            <th class="text-center">ORGANISASI</th>
                            <th class="text-center">LINGUISTIK</th>
                            <th class="text-center">MUSIKAL</th>
                            <th class="text-center">LOGIK</th>
                            <th class="text-center">SPASIAL</th>
                            <th class="text-center">KINESTETIK</th>
                            <th class="text-center">INTERPERSONAL</th>
                            <th class="text-center">INTRAPERSONAL</th>
                            <th class="text-center">NATURALIS</th>
                            <th class="text-center">EKSISTENSIAL</th>
                            <th class="text-center">PRODI</th>
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
        var datakasus_lama = $('#table_kasus_lama').DataTable({
            serverSide: true,
            processing: true,
            ajax: {
                url: "{{ url('kasus_lama/list') }}",
                type: "POST",
                data: function(d) {
                    d._token = "{{ csrf_token() }}"; // Tambahkan token CSRF
                },
                error: function(xhr, error, thrown) {
                    console.error('Error fetching data: ', thrown);
                }
            },
            columns: [
                { data: "id_kasus_lama", visible: false }, // ID disembunyikan
                { data: "kd_kasus_lama" },
                { data: "nama"},
                { data: "jurusan_asal"},
                { data: "nilai_rata_rata_rapor"},
                { data: "prestasi"},
                { data: "organisasi"},
                { data: "kec_linguistik"},
                { data: "kec_musikal"},
                { data: "kec_logika_matematis"},
                { data: "kec_spasial"},
                { data: "kec_kinestetik"},
                { data: "kec_interpersonal"},
                { data: "kec_intrapersonal"},
                { data: "kec_naturalis"},
                { data: "kec_eksistensial"},
                { data: "nama_prodi"},
                { 
                    data: "id_kasus_lama",
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        var editUrl = '{{ route('admin.kasus_lama.edit', ':id') }}'.replace(':id', data);
                        var deleteUrl = '{{ route('admin.kasus_lama.destroy', ':id') }}'.replace(':id', data);
                        return `
                            <div class="aksi-buttons">
                                <a href="${editUrl}" class="btn btn-primary btn-xs" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-danger btn-xs btn-delete-kasus_lama" data-id="${data}" data-url="${deleteUrl}" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        `;
                    }
                }
            ],
            columnDefs: [
                { targets: 0, visible: false } // Menyembunyikan ID jika tidak diperlukan
            ],
            pagingType: "simple_numbers",
            dom: '<"top"f>rt<"bottom"lp><"clear">',
            language: {
                search: "",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoFiltered: "(disaring dari _MAX_ data)",
                zeroRecords: "Tidak ada data yang ditemukan",
                emptyTable: "Data tidak tersedia"
            }
        });
    
        // Event listener untuk tombol Hapus
        $(document).on('click', '.btn-delete-kasus_lama', function() {
            var kasus_lamaId = $(this).data('id');
            var deleteUrl = $(this).data('url');
    
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Data kasus lama ini akan dihapus secara permanen!',
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
                        type: 'DELETE',
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: response.message,
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: true
                            }).then(() => {
                                datakasus_lama.ajax.reload();
                            });
                        },
                        error: function(xhr) {
                            var errorMessage = xhr.responseJSON?.message || 'Terjadi kesalahan saat menghapus data.';
                            Swal.fire({
                                title: 'Error!',
                                text: errorMessage,
                                icon: 'error'
                            });
                        }
                    });
                }
            });
        });
    
        // Tambahkan tombol "Tambah" ke dalam DataTables
        $("#table_kasus_lama_filter").append('<button id="btn-tambah" class="btn btn-primary ml-2">Tambah</button>');
    
        // Event listener untuk tombol "Tambah"
        $("#btn-tambah").on('click', function() {
            window.location.href = "{{ url('kasus_lama/create') }}";
        });
    
        // Placeholder untuk input pencarian
        $('input[type="search"]').attr('placeholder', 'Cari data kasus lama...');
    });
    </script>    
@endpush