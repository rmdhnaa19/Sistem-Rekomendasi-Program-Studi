@extends('layouts.template')
@section('title', 'Edit Program Studi')
@section('content')
    <div class="card">
        <div class="card-body">
            @empty($prodi)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban white"></i> Kesalahan!</h5> Data yang Anda cari tidak ditemukan.
                </div>
                <button type="button" class="btn btn-sm btn-danger" onclick="window.location.href='{{ url('prodi') }}'"
                    style="background-color: #DC3545; border-color: #DC3545" id="btn-kembali">Kembali</button>
            @else
                <form method="POST" action="{{ url('/prodi/' . $prodi->id_prodi) }}" class="form-horizontal"
                    enctype="multipart/form-data" id="editProdi">
                    @csrf {!! method_field('PUT') !!}
                    <div class=" form-group row">
                        
                            <div class="form-group">
                                <label for="kd_kolam">Kode Prodi</label>
                                <input type="number" name="kd_prodi" id="kd_prodi"
                                    class="form-control @error('kd_prodi') is-invalid @enderror"
                                    value="{{ old('kd_prodi', $prodi->kd_prodi) }}" required>
                                @error('kd_prodi')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="nama_prodi" class="form-label">Nama Program Studi</label>
                                <input type="text" class="form-control @error('nama_prodi') is-invalid @enderror" id="nama_prodi"
                                    name="nama_prodi" value="{{ old('nama_prodi', $prodi->nama_prodi) }}" placeholder="Masukkan Nama Program Studi"
                                    required>
                                <p><small class="text-muted">Wajib Diisi!</small></p>
                                @if ($errors->has('nama_prodi'))
                                    <span class="text-danger">{{ $errors->first('nama_prodi') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="id_jurusan">Jurusan</label>
                                <select name="id_jurusan" class="form-control @error('id_jurusan') is-invalid @enderror" required>
                                    <option value="">-- Pilih Jurusan --</option>
                                    @foreach($jurusan as $item)
                                        <option value="{{ $item->id_jurusan }}" {{ old('id_jurusan', $prodi->id_jurusan) == $item->id_jurusan ? 'selected' : '' }}>
                                            {{ $item->nama_jurusan }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_jurusan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="akreditasi" class="form-label">Akreditasi</label>
                                <input type="text" class="form-control @error('akreditasi') is-invalid @enderror" id="akreditasi"
                                    name="akreditasi" value="{{ old('akreditasi', $prodi->akreditasi) }}" placeholder="Masukkan akreditasi program studi"
                                    required>
                                <p><small class="text-muted">Wajib Diisi!</small></p>
                                @if ($errors->has('akreditasi'))
                                    <span class="text-danger">{{ $errors->first('akreditasi') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="jenjang" class="form-label">Jenjang</label>
                                <input type="text" class="form-control @error('jenjang') is-invalid @enderror" id="jenjang"
                                    name="jenjang" value="{{ old('jenjang', $prodi->jenjang) }}" placeholder="Masukkan jenjang program studi"
                                    required>
                                <p><small class="text-muted">Wajib Diisi!</small></p>
                                @if ($errors->has('jenjang'))
                                    <span class="text-danger">{{ $errors->first('jenjang') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="durasi_studi" class="form-label">Durasi Studi</label>
                                <input type="text" class="form-control @error('durasi_studi') is-invalid @enderror" id="durasi_studi"
                                    name="durasi_studi" value="{{ old('durasi_studi', $prodi->durasi_studi) }}" placeholder="Masukkan durasi studi"
                                    required>
                                <p><small class="text-muted">Wajib Diisi!</small></p>
                                @if ($errors->has('durasi_studi'))
                                    <span class="text-danger">{{ $errors->first('durasi_studi') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="deskripsi" class="font-weight-bold">Deskripsi:</label>
                                <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" 
                                    style="min-height: 200px; width: 100%; resize: none; text-align: justify; overflow-y: auto;" 
                                    required>{{ old('deskripsi', $prodi->deskripsi) }}</textarea>            
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-sm btn-danger"
                            onclick="window.location.href='{{ url('prodi') }}'"
                            style="background-color: #DC3545; border-color: #DC3545" id="btn-kembali">Kembali</button>
                        <button type="submit" class="btn btn-primary btn-sm"
                            style="background-color: #007BFF; border-color: #007BFF" id="btn-simpan">Simpan</button>
                    </div>
                </form>
            @endempty
        </div>
    </div>
@endsection
@push('css')
@endpush
