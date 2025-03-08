@extends('layouts.template')
@section('title', 'Edit Pertanyaan Kecerdasan')
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
            @empty($pertanyaan_kecerdasan)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban white"></i> Kesalahan!</h5> Data yang Anda cari tidak ditemukan.
                </div>
                <button type="button" class="btn btn-sm btn-danger" onclick="window.location.href='{{ url('pertanyaan_kecerdasan') }}'"
                    style="background-color: #DC3545; border-color: #DC3545" id="btn-kembali">Kembali</button>
            @else
                <form method="POST" action="{{ url('/pertanyaan_kecerdasan/' . $pertanyaan_kecerdasan->id_pertanyaan_kecerdasan) }}" class="form-horizontal"
                    enctype="multipart/form-data" id="editPertanyaan">
                    @csrf {!! method_field('PUT') !!}
                    <div class=" form-group row">
                            <div class="form-group">
                                <label for="pertanyaan" class="form-label">Pertanyaan</label>
                                <input type="text" class="form-control @error('pertanyaan') is-invalid @enderror" id="pertanyaan"
                                    name="pertanyaan" value="{{ old('pertanyaan_kecerdasan', $pertanyaan_kecerdasan->pertanyaan) }}" placeholder="Masukkan pertanyaan kecerdasan"
                                    required>
                                <p><small class="text-muted">Wajib Diisi!</small></p>
                                @if ($errors->has('pertanyaan'))
                                    <span class="text-danger">{{ $errors->first('pertanyaan_kecerdasan') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="id_kecerdasan_majemuk">Jenis Kecerdasan</label>
                                <select name="id_kecerdasan_majemuk" class="form-control @error('id_kecerdasan_majemuk') is-invalid @enderror" required>
                                    <option value="">-- Pilih Kecerdasan --</option>
                                    @foreach($kecerdasan_majemuk as $item)
                                        <option value="{{ $item->id_kecerdasan_majemuk }}" {{ old('id_kecerdasan_majemuk', $pertanyaan_kecerdasan->id_kecerdasan_majemuk) == $item->id_kecerdasan_majemuk ? 'selected' : '' }}>
                                            {{ $item->nama_kecerdasan }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_kecerdasan_majemuk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>                            
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-sm btn-danger"
                            onclick="window.location.href='{{ url('pertanyaan_kecerdasan') }}'"
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
