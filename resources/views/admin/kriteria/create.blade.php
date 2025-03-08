@extends('layouts.template')
@section('title', 'Tambah Kriteria')
@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ url('kriteria') }}" class="form-horizontal">
            @csrf
            <div class="row">
                <div class="col-md-12"> 
                    <div class="form-group">
                        <label for="jenis_kriteria" class="form-label">Jenis Kriteria</label>
                        <select class="form-select" name="jenis_kriteria" id="jenis_kriteria" required>
                            <option value="" disabled selected>Pilih Jenis Kriteria</option>
                            @foreach ($enum_values as $value)
                                <option value="{{ $value }}">{{ ucfirst($value) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">        
                        <label for="nama_kriteria" class="form-label">Nama Kriteria</label>
                        <input type="text" class="form-control" id="nama_kriteria" name="nama_kriteria" placeholder="Masukkan Nama Kriteria">
                    </div>
                </div>
            </div>
            
            <div class="d-flex justify-content-between mt-4">
                <button type="button" class="btn btn-danger btn-sm" onclick="window.location.href='{{ url('kriteria') }}'">Kembali</button>
                <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
