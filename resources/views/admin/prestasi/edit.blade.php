@extends('layouts.template')
@section('title', 'Edit Prestasi')
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
        <form method="POST" action="{{ route('admin.prestasi.update', $prestasi->id_prestasi) }}" class="form-horizontal"
            enctype="multipart/form-data" id="editPrestasi">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="id_kriteria">Nama Kriteria</label>
                <select name="id_kriteria" class="form-control @error('id_kriteria') is-invalid @enderror" required>
                    <option value="">-- Pilih Kriteria --</option>
                    @foreach($kriteria as $item)
                        <option value="{{ $item->id_kriteria }}" {{ old('id_kriteria', $prestasi->id_kriteria) == $item->id_kriteria ? 'selected' : '' }}>
                            {{ $item->nama_kriteria }}
                        </option>
                    @endforeach
                </select>
                @error('id_kriteria')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="nama" class="form-label">Nama Prestasi</label>
                <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama"
                    name="nama" value="{{ old('nama', $prestasi->nama) }}" placeholder="Masukkan nama prestasi"
                    required>
                <p><small class="text-muted">Wajib Diisi!</small></p>
                @if ($errors->has('nama'))
                    <span class="text-danger">{{ $errors->first('nama') }}</span>
                @endif
            </div>

            <div class="form-group">
                <label for="nilai" class="form-label">Nilai Index</label>
                <input type="number" class="form-control @error('nilai') is-invalid @enderror" id="nilai"
                    name="nilai" value="{{ old('nilai', $prestasi->nilai) }}" placeholder="Masukkan nilai index"
                    required>
                <p><small class="text-muted">Wajib Diisi!</small></p>
                @if ($errors->has('nilai'))
                    <span class="text-danger">{{ $errors->first('nilai') }}</span>
                @endif
            </div>

            <div class="d-flex justify-content-between mt-4">
                <button type="button" class="btn btn-danger btn-sm" onclick="window.location.href='{{ route('admin.prestasi.index') }}'">Kembali</button>
                <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
@push('js')
@endpush
