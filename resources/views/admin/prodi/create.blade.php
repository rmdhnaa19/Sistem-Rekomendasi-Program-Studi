@extends('layouts.template')
@section('title', 'Kelola Program Studi')
@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ url('prodi') }}" class="form-horizontal" enctype="multipart/form-data" id="tambahProdi">
                @csrf
                <div class="row">

                    <!-- Full Width Form -->

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="kd_prodi" class="form-label">Kode Prodi</label>
                            <input type="number" class="form-control" id="kd_prodi" name="kd_prodi"
                                placeholder="Masukkan kode program studi" value="{{ old('kd_prodi') }}" required autofocus>
                            @error('kd_prodi')
                            <div class="invalid-feedback">
                                <i class="bx bx-radio-circle"></i>
                                Kode prodi yang anda masukkan tidak valid
                            </div>
                            @enderror
                        </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="nama_prodi" class="form-label">Nama Prodi</label>
                            <input type="text" class="form-control" id="nama_prodi" name="nama_prodi"
                                placeholder="Masukkan nama program studi" value="{{ old('nama_prodi') }}" required autofocus>
                            @error('nama_prodi')
                            <div class="invalid-feedback">
                                <i class="bx bx-radio-circle"></i>
                                Nama prodi yang anda masukkan tidak valid
                            </div>
                            @enderror
                        </div>

                        {{-- ambil nama jurusan dari tabel jurusan --}}
                        <div class="form-group">
                            <label for="id_jurusan" class="form-label">Nama Jurusan</label>
                            <select class="choices form-select @error('id_jurusan') is-invalid @enderror" name="id_jurusan"
                                id="id_jurusan">
                                <option value="{{ old('id_jurusan') }}">- Pilih Nama Jurusan -</option>
                                @foreach ($jurusan as $item)
                                    <option value="{{ $item->id_jurusan }}">{{ $item->nama_jurusan }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('id_jurusan'))
                                <span class="text-danger">{{ $errors->first('id_jurusan') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="akreditasi" class="form-label">Akreditasi</label>
                            <input type="text" class="form-control" id="akreditasi" name="akreditasi"
                                placeholder="Masukkan akreditasi program studi" value="{{ old('akreditasi') }}" required>
                            @error('akreditasi')
                            <div class="invalid-feedback">
                                <i class="bx bx-radio-circle"></i>
                                Status akreditasi yang anda masukkan tidak valid
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="jenjang" class="form-label">Jenjang</label>
                            <input type="text" class="form-control" id="jenjang" name="jenjang"
                                placeholder="Masukkan jenjang program studi" value="{{ old('jenjang') }}" required>
                            @error('jenjang')
                            <div class="invalid-feedback">
                                <i class="bx bx-radio-circle"></i>
                                Jenjang yang anda masukkan tidak valid
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="durasi_studi" class="form-label">Durasi Studi</label>
                            <textarea class="form-control" id="durasi_studi" name="durasi_studi" rows="3" placeholder="Masukkan durasi studi program studi" required></textarea>
                            @error('durasi_studi')
                            <div class="invalid-feedback">
                                <i class="bx bx-radio-circle"></i>
                                Durasi studi yang anda masukkan tidak valid
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" placeholder="Masukkan deskripsi program studi" required></textarea>
                            @error('deskripsi')
                            <div class="invalid-feedback">
                                <i class="bx bx-radio-circle"></i>
                                Deskripsi yang anda masukkan tidak valid
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-3">
                        <button type="button" class="btn btn-sm btn-danger"
                            onclick="window.location.href='{{ url('prodi') }}'"
                            style="background-color: #DC3545; border-color: #DC3545" id="btn-kembali">Kembali</button>
                        <button type="submit" class="btn btn-primary btn-sm"
                            style="background-color: #007BFF; border-color: #007BFF" id="btn-simpan">Simpan</button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
@endsection
