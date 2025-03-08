@extends('layouts.template')
@section('title', 'Edit Kasus Lama')
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
            @empty($kasus_lama)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban white"></i> Kesalahan!</h5> Data yang Anda cari tidak ditemukan.
                </div>
                <button type="button" class="btn btn-sm btn-danger" onclick="window.location.href='{{ url('kasus_lama') }}'"
                    style="background-color: #DC3545; border-color: #DC3545" id="btn-kembali">Kembali</button>
            @else
                <form method="POST" action="{{ url('/kasus_lama/' . $kasus_lama->id_kasus_lama) }}" class="form-horizontal"
                    enctype="multipart/form-data" id="editKasus">
                    @csrf {!! method_field('PUT') !!}
                    <div class=" form-group row">
                        
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" name="nama" class="form-control"
                                value="{{ old('nama', $kasus_lama->nama) }}" required>
                        </div>                        
                        
                        <div class="mb-3">
                            <label class="form-label">Jurusan Asal</label>
                            <select name="jurusan_asal" class="form-control" required>
                                @foreach($kriteria['jurusan_asal'] as $nilai => $sub_kriteria)
                                    <option value="{{ $sub_kriteria }}" 
                                        {{ old('jurusan_asal', $kasus_lama->jurusan_asal) == $nilai ? 'selected' : '' }}>
                                        {{ $sub_kriteria }}
                                    </option>
                                @endforeach
                            </select>                
                        </div>
            
                        <div class="mb-3">
                            <label class="form-label">Nilai Rata-Rata Rapor</label>
                            <input type="number" step="0.01" name="nilai_rata_rata_rapor" class="form-control"
                                value="{{ old('nilai_rata_rata_rapor', $kasus_lama->nilai_rata_rata_rapor) }}" required>
                        </div>
            
                        <div class="mb-3">
                            <label class="form-label">Prestasi</label>
                            <select name="prestasi" class="form-control" required>
                                @foreach($kriteria['Prestasi'] as $nilai => $sub_kriteria)
                                    <option value="{{ $sub_kriteria }}" 
                                        {{ old('prestasi', $kasus_lama->prestasi) == $sub_kriteria ? 'selected' : '' }}>
                                        {{ $sub_kriteria }}
                                    </option>
                                @endforeach
                            </select>                            
                        </div>
            
                        <div class="mb-3">
                            <label class="form-label">Organisasi</label>
                            <select name="organisasi" class="form-control" required>
                                @foreach($kriteria['Keaktifan Organisasi'] as $nilai => $sub_kriteria)
                                    <option value="{{ $sub_kriteria }}" 
                                        {{ old('organisasi', $kasus_lama->organisasi) == $sub_kriteria ? 'selected' : '' }}>
                                        {{ $sub_kriteria }}
                                    </option>
                                @endforeach
                            </select>                            
                        </div>
            
                        @foreach(['linguistik', 'musikal', 'logika_matematis', 'spasial', 'kinestetik', 'interpersonal', 'intrapersonal', 'naturalis', 'eksistensial'] as $kecerdasan)
                        <div class="mb-3">
                            <label class="form-label">Kec. {{ ucfirst(str_replace('_', ' ', $kecerdasan)) }}</label>
                            <input type="number" step="0.01" name="kec_{{ $kecerdasan }}" class="form-control"
                                value="{{ old('kec_'.$kecerdasan, $kasus_lama->{'kec_'.$kecerdasan}) }}" required>
                        </div>
                        @endforeach
                        

                        <select name="id_prodi" class="form-control" required>
                            @foreach($list_prodi as $prodi)
                                <option value="{{ $prodi->id_prodi }}" 
                                    {{ old('id_prodi', $kasus_lama->id_prodi) == $prodi->id_prodi ? 'selected' : '' }}>
                                    {{ $prodi->nama_prodi }}
                                </option>
                            @endforeach
                        </select>
                        

                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-sm btn-danger"
                            onclick="window.location.href='{{ url('kasus_lama') }}'"
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
