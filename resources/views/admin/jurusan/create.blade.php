@extends('layouts.template')
@section('title', 'Tambah Jurusan')
@section('content')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ url('jurusan') }}" class="form-horizontal" enctype="multipart/form-data" id="tambahJurusan">
                @csrf
                <div class="form-group row">
                    
                    <!-- Kolom Nama Jurusan -->
                    <div class="col-md-6 mt-3">
                        <div class="form-group">
                            <label for="nama_jurusan" class="form-label">Nama Jurusan</label>
                            <input type="text" class="form-control @error('nama_jurusan') is-invalid @enderror" id="nama_jurusan"
                                name="nama_jurusan" placeholder="Masukkan Nama Jurusan" value="{{ old('nama_jurusan') }}" required>
                            <p><small class="text-muted">Wajib Diisi!</small></p>
                            @if ($errors->has('nama_jurusan'))
                                <span class="text-danger">{{ $errors->first('nama_jurusan') }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- Kolom Deskripsi -->
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi"
                                name="deskripsi" placeholder="Masukkan Deskripsi Jurusan" style="min-height: 150px; resize: vertical;" required>{{ old('deskripsi') }}</textarea>
                            <p><small class="text-muted">Wajib Diisi!</small></p>
                            @if ($errors->has('deskripsi'))
                                <span class="text-danger">{{ $errors->first('deskripsi') }}</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-sm btn-danger"
                        onclick="window.location.href='{{ url('jurusan') }}'"
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
