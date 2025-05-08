@extends('layouts.template')
@section('title', 'Edit Kasus Baru')
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
            @empty($revise)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban white"></i> Kesalahan!</h5> Data yang Anda cari tidak ditemukan.
                </div>
                <button type="button" class="btn btn-sm btn-danger" onclick="window.location.href='{{ url('revise') }}'"
                    style="background-color: #DC3545; border-color: #DC3545" id="btn-kembali">Kembali</button>
            @else
                <form method="POST" action="{{ url('/revise/' . $revise->id_revise) }}" class="form-horizontal"
                    enctype="multipart/form-data" id="editRevise">
                    @csrf {!! method_field('PUT') !!}
                    <div class=" form-group row">
                        
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" name="nama" class="form-control"
                                value="{{ old('nama', $revise->nama) }}" required>
                        </div>                        
                        
                        <div class="mb-3">
                            <label class="form-label">Jurusan Asal</label>
                            <select name="jurusan_asal" class="form-control" required>
                                @foreach($sub_kriteria_jurusan as $jurusan)
                                    <option value="{{ $jurusan->id_sub_kriteria }}" 
                                        {{ old('jurusan_asal', $revise->jurusan_asal) == $jurusan->id_sub_kriteria ? 'selected' : '' }}>
                                        {{ $jurusan->nama_sub }}
                                    </option>
                                @endforeach
                            </select>                
                        </div>
            
                        <div class="mb-3">
                            <label class="form-label">Nilai Rata-Rata Rapor</label>
                            <input type="number" step="0.01" name="nilai_rata_rata_rapor" class="form-control"
                                value="{{ old('nilai_rata_rata_rapor', $revise->nilai_rata_rata_rapor) }}" required>
                        </div>
            
                        <div class="mb-3">
                            <label class="form-label">Prestasi</label>
                            <select name="prestasi" class="form-control" required>
                                @foreach($sub_kriteria_prestasi as $prestasi)
                                    <option value="{{ $prestasi->id_sub_kriteria }}" 
                                        {{ old('prestasi', $revise->prestasi) == $prestasi->id_sub_kriteria ? 'selected' : '' }}>
                                        {{ $prestasi->nama_sub }}
                                    </option>
                                @endforeach
                            </select>                            
                        </div>
            
                        <div class="mb-3">
                            <label class="form-label">Organisasi</label>
                            <select name="organisasi" class="form-control" required>
                                @foreach($sub_kriteria_organisasi as $organisasi)
                                    <option value="{{ $organisasi->id_sub_kriteria }}" 
                                        {{ old('organisasi', $revise->organisasi) == $organisasi->id_sub_kriteria ? 'selected' : '' }}>
                                        {{ $organisasi->nama_sub }}
                                    </option>
                                @endforeach
                            </select>                            
                        </div>
            
                        @foreach(['linguistik', 'musikal', 'logika_matematis', 'spasial', 'kinestetik', 'interpersonal', 'intrapersonal', 'naturalis', 'eksistensial'] as $kecerdasan)
                        <div class="mb-3">
                            <label class="form-label">Kec. {{ ucfirst(str_replace('_', ' ', $kecerdasan)) }}</label>
                            <input type="number" step="0.01" name="kec_{{ $kecerdasan }}" class="form-control"
                                value="{{ old('kec_'.$kecerdasan, $revise->{'kec_'.$kecerdasan}) }}" required>
                        </div>
                        @endforeach
                        
                    <div class="mb-3">
                        <label class="form-label">Program Studi</label>
                        <select name="id_prodi" class="form-control" required>
                            @foreach($list_prodi as $prodi)
                                <option value="{{ $prodi->id_prodi }}" 
                                    {{ old('id_prodi', $revise->id_prodi) == $prodi->id_prodi ? 'selected' : '' }}>
                                    {{ $prodi->nama_prodi }}
                                </option>
                            @endforeach
                        </select>                            
                    </div>
                        

                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-sm btn-danger"
                            onclick="window.location.href='{{ url('revise') }}'"
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