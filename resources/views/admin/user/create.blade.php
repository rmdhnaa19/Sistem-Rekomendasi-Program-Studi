@extends('layouts.template')
@section('title', 'Tambah User')
@section('content')
    <div class="card">
        <div class="card-body">
            <!-- {{-- @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif --}} -->
            <form method="POST" action="{{ url('user') }}" class="form-horizontal" enctype="multipart/form-data"
                id="tambahUser">
                @csrf
                <div class=" form-group row">
                    <div class="col-md-6 mt-3">

                        <div class="form-group">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama"
                                name="nama" placeholder="Masukkan Nama" value="{{ old('nama') }}" required>
                            <p><small class="text-muted">Wajib Diisi!</small></p>
                            @if ($errors->has('nama'))
                                <span class="text-danger">{{ $errors->first('nama') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror"
                                id="username" name="username" placeholder="Masukkan Username"
                                value="{{ old('username') }}" required autofocus>
                            <p><small class="text-muted">Wajib Diisi!</small></p>
                            @if ($errors->has('username'))
                                <span class="text-danger">{{ $errors->first('username') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password" placeholder="Masukkan Password" required>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="toggle-password"
                                        style="cursor: pointer; padding: 0.7rem 0.6rem;">
                                        <i class="fa fa-eye" id="eye-icon"></i>
                                    </span>
                                </div>
                            </div>
                            <p><small class="text-muted">Wajib Diisi!</small></p>
                            @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="nip" class="form-label">NIP</label>
                            <input type="text" class="form-control @error('nip') is-invalid @enderror" id="nip"
                                name="nip" placeholder="Masukkan NIP user" value="{{ old('nip') }}" required>
                            <p><small class="text-muted">Wajib Diisi!</small></p>
                            @if ($errors->has('nip'))
                                <span class="text-danger">{{ $errors->first('nip') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                            <div class="form-group">
                                <select class="choices form-select @error('jenis_kelamin') is-invalid @enderror" name="jenis_kelamin"
                                    id="posisi" required>
                                    <option value="">- Pilih Jenis Kelamin -</option>
                                    <option value="Laki-Laki">Laki-Laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                                <p><small class="text-muted">Wajib Diisi!</small></p>
                            </div>
                            @if ($errors->has('jenis_kelamin'))
                                <span class="text-danger">{{ $errors->first('jenis_kelamin') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir"
                            placeholder="Masukkan tanggal lahir" value="{{ old('tanggal_lahir') }}" required>
                        @error('tanggal_lahir')
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i>
                            Tanggal lahir yang anda masukkan tidak valid
                        </div>
                        @enderror
                        </div>

                        <div class="form-group">
                            <label for="no_hp" class="form-label">Nomor Hp</label>
                            <input type="text" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp"
                                name="no_hp" placeholder="Masukkan No Hp" value="{{ old('no_hp') }}">
                            <p><small class="text-muted">Wajib Diisi!</small></p>
                            @if ($errors->has('no_hp'))
                                <span class="text-danger">{{ $errors->first('no_hp') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3"
                                placeholder="Masukkan Alamat">{{ old('alamat') }}</textarea>
                            <p><small class="text-muted">Wajib Diisi!</small></p>
                            @if ($errors->has('alamat'))
                                <span class="text-danger">{{ $errors->first('alamat') }}</span>
                            @endif
                        </div>
                        
                    </div>
                    <div class="col-md-6 d-flex justify-content-center align-items-center mt-3">
                        <div class="form-group">
                            <div class="col">
                                <div class="row mb-3">
                                    <div class="drop-zone"
                                        style="width: 300px; height: 300px; border: 2px dashed #ccc; border-radius: 5px; display: flex; justify-content: center; align-items: center; cursor: pointer;">
                                        <div class="text-center">
                                            <i class="fa-solid fa-cloud-arrow-up"
                                                style="height: 50px; font-size: 50px"></i>
                                            <p class="mt-2">Seret lalu letakkan file di sini</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <span class="text-center">Atau</span>
                                </div>
                                <div class="row mb-5">
                                    <div class="form-file">
                                        <label class="form-file-label" for="foto">
                                            <span class="form-file-text">Choose file...</span>
                                            <span class="form-file-button">Browse</span>
                                            <input type="file" class="drop-zone__input" id="foto"
                                                name="foto">
                                        </label>
                                    </div>
                                </div>
                                @if ($errors->has('foto'))
                                    <div class="row alert alert-danger">
                                        <span class="text-center">{{ $errors->first('foto') }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-sm btn-danger"
                        onclick="window.location.href='{{ url('user') }}'"
                        style="background-color: #DC3545; border-color: #DC3545" id="btn-kembali">Kembali</button>
                    <button type="submit" class="btn btn-primary btn-sm"
                        style="background-color: #007BFF; border-color: #007BFF" id="btn-simpan">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('css')
@endpush
@push('js')
    <script>
        // Pilih elemen-elemen yang dibutuhkan
        const dropZone = document.querySelector('.drop-zone');
        const dropZoneInput = document.querySelector('.drop-zone__input');
        const browseInput = document.querySelector('#foto');
        const fileNameLabel = document.querySelector('.form-file-text');

        // Fungsi untuk menangani event dragover
        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('drop-zone--over');
        });

        // Fungsi untuk menangani event dragleave
        dropZone.addEventListener('dragleave', () => {
            dropZone.classList.remove('drop-zone--over');
        });

        // Fungsi untuk menangani event drop
        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('drop-zone--over');
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                dropZoneInput.files = files;
                updateFileName(files[0].name);
                previewImage(files[0]);
                uploadFile(files[0]);
            }
        });

        // Fungsi untuk menangani event change pada input file
        browseInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                dropZoneInput.files = this.files; // Sync files dengan drop zone
                updateFileName(this.files[0].name);
                previewImage(this.files[0]);
                uploadFile(this.files[0]);
            }
        });

        // Fungsi untuk mengupdate nama file pada label
        function updateFileName(name) {
            fileNameLabel.textContent = name;
        }

        // Fungsi untuk preview gambar
        function previewImage(file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Buat elemen gambar
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'preview-image';
                img.style.maxWidth = '100%';
                img.style.maxHeight = '100%';
                img.style.objectFit = 'contain';

                // Hapus isi drop zone dan tambahkan gambar
                dropZone.innerHTML = '';
                dropZone.appendChild(img);

                // Ubah style drop zone
                dropZone.style.padding = '0';
                dropZone.style.border = 'none';
            }
            reader.readAsDataURL(file);
        }

        // Fungsi placeholder untuk upload file
        function uploadFile(file) {
            // Implementasi logika upload file di sini
            console.log('Mengupload file:', file.name);
        }

        // Fungsi untuk reset drop zone
        function resetDropZone() {
            dropZone.innerHTML = `
                    <div class="text-center">
                    <i class="fa-solid fa-cloud-arrow-up" style="height: 50px; font-size: 50px"></i>
                    <p>Seret lalu letakkan file di sini</p>
                    </div>`;
            dropZone.style.padding = ''; // Reset ke default
            dropZone.style.border = ''; // Reset ke default
            fileNameLabel.textContent = 'Pilih file...';
        }

        // Tambahkan event click pada preview gambar untuk mengganti gambar
        dropZone.addEventListener('click', () => {
            if (dropZone.querySelector('.preview-image')) {
                if (confirm('Apakah Anda ingin mengganti gambar?')) {
                    resetDropZone();
                    browseInput.click();
                }
            }
        });
    </script>
    <script>
        document.getElementById('toggle-password').addEventListener('click', function(e) {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        });
    </script>
@endpush
