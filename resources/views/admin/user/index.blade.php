@extends('layouts.template')
@section('title', 'Kelola User')
@section('content')
    <div class="card">
        <div class="card-header">Data User</div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success" id="success-alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="table-responsive">
                <table class="table mb-3" id="table_user">
                    <thead>
                        <tr>
                            <th style="display: none">ID</th>
                            <th class="text-center">NAMA</th>
                            <th class="text-center">NIP</th>
                            <th class="text-center">NO HP</th>
                            <th class="text-center">ALAMAT</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal --}}
    <div class="modal fade text-left" id="userDetailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content" style="border-radius: 15px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
                <div class="modal-header bg-primary" style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
                    <h5 class="modal-title white" id="myModalLabel17">Detail User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body px-3 py-2" style="max-height: 75vh; overflow-y: auto;">
                    <div id="user-detail-content" class="container-fluid">
                        <div class="text-center mb-3">
                            <h4 class="mb-4"></h4>
                        </div>
                        <div class="row">
                            <div class="col-md-5 col-12 mb-3 mb-md-0">
                                <div class="image-container text-center">
                                    <img src="" alt="Foto User" class="img-fluid rounded" style="width: auto; height: 30vh;">
                                </div>
                            </div>
                            <div class="col-md-7 col-12">
                                <div style="max-height: 30vh; overflow-y: auto; padding-right: 15px;">
                                    <p><strong>Username : </strong><span id="user-username"></span></p>
                                    <p><strong>Jenis Kelamin : </strong><span id="user-gender"></span></p>
                                    <p><strong>Tanggal Lahir : </strong><span id="user-dob"></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between flex-wrap" style="border-bottom-left-radius: 15px; border-bottom-right-radius: 15px;">
                    <button type="button" class="btn btn-danger mb-2 mb-md-0" id="btn-delete-user">Hapus</button>
                    <button type="button" class="btn btn-primary mb-2 mb-md-0" id="btn-edit-user">Edit</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
<script>
    var currentUserId;
    $(document).ready(function() {
        var datauser = $('#table_user').DataTable({
            serverSide: true,
            ajax: {
                "url": "{{ url('user/list') }}",
                "dataType": "json",
                "type": "POST",
                "error": function(xhr, error, thrown) {
                    console.error('Error fetching data: ', thrown);
                }
            },
            columns: [
                { data: "id_user", visible: false },
                {
                    data: "nama",
                    className: "col-md-4",
                    orderable: true,
                    searchable: true,
                    render: function(data, type, row) {
                        var url = '{{ route('admin.user.show', ':id') }}';
                        url = url.replace(':id', row.id_user);
                        return '<a href="javascript:void(0);" data-id="' + row.id_user + '" class="view-user-details" data-url="' + url + '" data-toggle="modal" data-target="#userDetailModal">' + data + '</a>';
                    }
                },
                { data: "nip", className: "col-md-3 text-center", orderable: true, searchable: true },
                { data: "no_hp", className: "col-md-2 text-center", orderable: true, searchable: false },
                { data: "alamat", className: "col-md-2 text-center", orderable: true, searchable: false }
            ],
            pagingType: "simple_numbers",
            dom: 'frtip',
            language: {
                search: ""
            }
        });

        $(document).on('click', '.view-user-details', function() {
            var url = $(this).data('url');
            currentUserId = $(this).data('id');

            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    if (response.html) {
                        $('#user-detail-content').html(response.html);
                        $('#userDetailModal').modal('show');
                    } else {
                        alert('Gagal memuat detail user');
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    alert('Gagal memuat detail user');
                }
            });
        });

        $(document).on('click', '#btn-edit-user', function() {
            if (currentUserId) {
                var editUrl = '{{ route('admin.user.edit', ':id') }}'.replace(':id', currentUserId);
                window.location.href = editUrl;
            } else {
                alert('ID user tidak ditemukan');
            }
        });

        $(document).on('click', '#btn-delete-user', function() {
            if (currentUserId) {
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Data user ini akan dihapus secara permanen!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var deleteUrl = '{{ route('admin.user.destroy', ':id') }}'.replace(':id', currentUserId);
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
                                        window.location.href = "{{ route('admin.user.index') }}";
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Gagal!',
                                        text: 'Gagal menghapus data user: ' + response.message,
                                        icon: 'error'
                                    });
                                }
                            },
                            error: function(xhr) {
                                let errorMsg = 'Gagal menghapus data user.';
                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    errorMsg += ' ' + xhr.responseJSON.message;
                                }
                                Swal.fire({
                                    title: 'Error!',
                                    text: errorMsg,
                                    icon: 'error'
                                });
                            }
                        });
                    }
                });
            } else {
                Swal.fire({
                    title: 'Error!',
                    text: 'ID user tidak ditemukan',
                    icon: 'error'
                });
            }
        });

        $("#table_user_filter").append('<button id="btn-tambah" class="btn btn-primary ml-2">Tambah</button>');
        $("#btn-tambah").on('click', function() {
            window.location.href = "{{ url('user/create') }}";
        });

        $('input[type="search"]').attr('placeholder', 'Cari data user...');
    });
</script>
@endpush
