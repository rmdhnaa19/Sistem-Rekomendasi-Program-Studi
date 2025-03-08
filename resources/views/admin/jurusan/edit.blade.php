@extends('layouts.template')
@section('title', 'Edit Jurusan')
@section('content')
<div class="card">
    <div class="card-body">        
        <form method="POST" action="{{ url('/jurusan/' . $jurusan->id_jurusan) }}" class="form-horizontal"
            enctype="multipart/form-data" id="editjurusan">
            @csrf {!! method_field('PUT') !!}

            <div class="form-group">
                <label for="nama_jurusan" class="font-weight-bold">Nama Jurusan:</label>
                <input type="text" name="nama_jurusan" class="form-control @error('nama_jurusan') is-invalid @enderror" 
                    value="{{ old('nama_jurusan', $jurusan->nama_jurusan) }}" required>
                @error('nama_jurusan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="deskripsi" class="font-weight-bold">Deskripsi:</label>
                <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" 
                style="min-height: 200px; width: 100%; resize: none; overflow: hidden; text-align: justify;" 
                oninput="this.style.height = ''; this.style.height = this.scrollHeight + 'px'" required>{{ old('deskripsi', $jurusan->deskripsi) }}</textarea>            
                @error('deskripsi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
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
