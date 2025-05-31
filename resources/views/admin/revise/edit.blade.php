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
                    <div class="form-group row">
                        
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input disabled type="text" class="form-control"
                                value="{{ old('nama', $revise->nama) }}">
                            <!-- Hidden input untuk mengirim nilai -->
                            <input type="hidden" name="nama" value="{{ old('nama', $revise->nama) }}">
                        </div>                        
                        
                        <div class="mb-3">
                            <label class="form-label">Jurusan Asal</label>
                            <select disabled class="form-control">
                                @foreach($jurusanAsal as $jurusan)
                                    <option value="{{ $jurusan->nama }}" 
                                        {{ old('jurusan_asal', $revise->jurusan_asal) == $jurusan->nama ? 'selected' : '' }}>
                                        {{ $jurusan->nama }}
                                    </option>
                                @endforeach
                            </select>
                            <!-- Hidden input untuk mengirim nilai -->
                            <input type="hidden" name="jurusan_asal" value="{{ old('jurusan_asal', $revise->jurusan_asal) }}">                
                        </div>
            
                        <div class="mb-3">
                            <label class="form-label">Nilai Rata-Rata Rapor</label>
                            <input disabled type="number" step="0.01" class="form-control"
                                value="{{ old('nilai_rata_rata_rapor', $revise->nilai_rata_rata_rapor) }}">
                            <!-- Hidden input untuk mengirim nilai -->
                            <input type="hidden" name="nilai_rata_rata_rapor" value="{{ old('nilai_rata_rata_rapor', $revise->nilai_rata_rata_rapor) }}">
                        </div>
            
                        <div class="mb-3">
                            <label class="form-label">Prestasi</label>
                            <select disabled class="form-control">
                                @foreach($prestasi as $pre)
                                    <option value="{{ $pre->nama }}" 
                                        {{ old('prestasi', $revise->prestasi) == $pre->nama ? 'selected' : '' }}>
                                        {{ $pre->nama }}
                                    </option>
                                @endforeach
                            </select>
                            <!-- Hidden input untuk mengirim nilai -->
                            <input type="hidden" name="prestasi" value="{{ old('prestasi', $revise->prestasi) }}">                            
                        </div>
            
                        <div class="mb-3">
                            <label class="form-label">Organisasi</label>
                            <select disabled class="form-control">
                                @foreach($organisasi as $org)
                                    <option value="{{ $org->nama }}" 
                                        {{ old('organisasi', $revise->organisasi) == $org->nama ? 'selected' : '' }}>
                                        {{ $org->nama }}
                                    </option>
                                @endforeach
                            </select>
                            <!-- Hidden input untuk mengirim nilai -->
                            <input type="hidden" name="organisasi" value="{{ old('organisasi', $revise->organisasi) }}">                            
                        </div>
            
                        @foreach(['linguistik', 'musikal', 'logika_matematis', 'spasial', 'kinestetik', 'interpersonal', 'intrapersonal', 'naturalis', 'eksistensial'] as $kecerdasan)
                        <div class="mb-3">
                            <label class="form-label">Kec. {{ ucfirst(str_replace('_', ' ', $kecerdasan)) }}</label>
                            <input disabled type="number" step="0.01" class="form-control"
                                value="{{ old('kec_'.$kecerdasan, $revise->{'kec_'.$kecerdasan}) }}">
                            <!-- Hidden input untuk mengirim nilai -->
                            <input type="hidden" name="kec_{{ $kecerdasan }}" value="{{ old('kec_'.$kecerdasan, $revise->{'kec_'.$kecerdasan}) }}">
                        </div>
                        @endforeach
                        
                        <div class="mb-3">
                            <label class="form-label">Program Studi</label>
                            <select name="nama_prodi" class="form-control" required>
                                @foreach($list_prodi as $prodi)
                                    <option value="{{ $prodi->nama_prodi }}" 
                                        {{ old('nama_prodi', $revise->nama_prodi) == $prodi->nama_prodi ? 'selected' : '' }}>
                                        {{ $prodi->nama_prodi }}
                                    </option>
                                @endforeach
                            </select>                            
                        </div>
                    
                        <div class="mb-3">
                            <label class="form-label">Similarity</label>
                            <input disabled type="number" step="0.01" class="form-control"
                                value="{{ old('similarity', $revise->similarity) }}">
                            <!-- Hidden input untuk mengirim nilai -->
                            <input type="hidden" name="similarity" value="{{ old('similarity', $revise->similarity) }}">
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