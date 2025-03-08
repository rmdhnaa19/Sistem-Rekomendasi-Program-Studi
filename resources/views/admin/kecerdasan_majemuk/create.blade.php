@extends('layouts.template')
@section('title', 'Tambah Kecerdasan Majemuk')
@section('content')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ url('kecerdasan_majemuk') }}" class="form-horizontal" enctype="multipart/form-data" id="tambahkecerdasan_majemuk">
                @csrf
                <div class="form-group row">
                        <div class="form-group">
                            <label for="nama_kecerdasan" class="form-label">Jenis Kecerdasan</label>
                            <input type="text" class="form-control @error('nama_keecrdasan') is-invalid @enderror" id="nama_kecerdasan"
                                name="nama_kecerdasan" placeholder="Masukkan Nama Kecerdasan" value="{{ old('nama_kecerdasan') }}" required>
                            <p><small class="text-muted">Wajib Diisi!</small></p>
                            @if ($errors->has('nama_kecerdasan'))
                                <span class="text-danger">{{ $errors->first('nama_kecerdasan') }}</span>
                            @endif
                        </div>

                    <!-- Kolom Deskripsi -->
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi"
                                name="deskripsi" placeholder="Masukkan Deskripsi Kecerdasan" style="min-height: 150px; resize: vertical;" required>{{ old('deskripsi') }}</textarea>
                            <p><small class="text-muted">Wajib Diisi!</small></p>
                            @if ($errors->has('deskripsi'))
                                <span class="text-danger">{{ $errors->first('deskripsi') }}</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-sm btn-danger"
                        onclick="window.location.href='{{ url('kecerdasan_majemuk') }}'"
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
