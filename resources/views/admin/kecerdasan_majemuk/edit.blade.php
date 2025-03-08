@extends('layouts.template')
@section('title', 'Edit Kecerdasan Majemuk')
@section('content')
<div class="card">
    <div class="card-body">        
        <form method="POST" action="{{ url('/kecerdasan_majemuk/' . $kecerdasan_majemuk->id_kecerdasan_majemuk) }}" class="form-horizontal"
            enctype="multipart/form-data" id="editkecerdasan_majemuk">
            @csrf {!! method_field('PUT') !!}

            <div class="form-group">
                <label for="nama_kecerdasan" class="font-weight-bold">Jenis Kecerdasan:</label>
                <input type="text" name="nama_kecerdasan" class="form-control @error('nama_kecerdasan') is-invalid @enderror" 
                    value="{{ old('nama_kecerdasan', $kecerdasan_majemuk->nama_kecerdasan) }}" required>
                @error('nama_kecerdasan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="deskripsi" class="font-weight-bold">Deskripsi:</label>
                <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" 
                style="min-height: 200px; width: 100%; resize: none; overflow: hidden; text-align: justify;" 
                oninput="this.style.height = ''; this.style.height = this.scrollHeight + 'px'" required>{{ old('deskripsi', $kecerdasan_majemuk->deskripsi) }}</textarea>            
                @error('deskripsi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
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
