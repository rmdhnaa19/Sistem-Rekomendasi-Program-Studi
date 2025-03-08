@extends('layouts.template')
@section('title', 'Edit Kriteria')
@section('content')
<div class="card">
    <div class="card-body">
         @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        <form method="POST" action="{{ route('admin.kriteria.update', $kriteria->id_kriteria) }}" class="form-horizontal"
            enctype="multipart/form-data" id="editKriteria">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="jenis_kriteria" class="form-label">Jenis Kriteria</label>
                <select class="form-select" name="jenis_kriteria" id="jenis_kriteria" required>
                    <option value="kualitatif" {{ $kriteria->jenis_kriteria == 'kualitatif' ? 'selected' : '' }}>Kualitatif</option>
                    <option value="kuantitatif" {{ $kriteria->jenis_kriteria == 'kuantitatif' ? 'selected' : '' }}>Kuantitatif</option>
                </select>
            </div>

            <div id="nama-kriteria-field" class="form-group">
                <label for="nama_kriteria" class="form-label">Nama Kriteria</label>
                <input type="text" class="form-control" id="nama_kriteria" name="nama_kriteria" 
                    value="{{ $kriteria->nama_kriteria }}" placeholder="Masukkan Nama Kriteria">
            </div>

            <div class="d-flex justify-content-between mt-4">
                <button type="button" class="btn btn-danger btn-sm" onclick="window.location.href='{{ route('admin.kriteria.index') }}'">Kembali</button>
                <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
@push('js')
@endpush
