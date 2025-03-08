@extends('layouts.template')
@section('title', 'Tambah Kasus Lama')
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
            <form method="POST" action="{{ url('kasus_lama') }}" class="form-horizontal" enctype="multipart/form-data" id="tambahKasus">
                @csrf
                <div class="form-group row">


                    <!-- Kolom Nama -->
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama"
                                placeholder="Masukkan nama" value="{{ old('nama') }}" required>
                        </div>
                    </div>

                    <!-- Kolom Nilai Rata-rata Rapor -->
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="nilai_rata_rata_rapor" class="form-label">Nilai Rata-rata Rapor</label>
                            <input type="number" step="0.01" name="nilai_rata_rata_rapor" class="form-control" required>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="jurusan_asal" class="form-label">Jurusan Asal</label>
                            <select name="jurusan_asal" class="form-control" required>
                                <option value="">-- Pilih Jurusan Asal --</option>
                                @foreach($sub_kriteria_jurusan as $sub)
                                    <option value="{{ $sub->id_sub_kriteria }}">{{ $sub->nama_sub }}</option>
                                @endforeach
                            </select>                            
                        </div>
                    </div>
                    
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="prestasi" class="form-label">Prestasi</label>
                            <select name="prestasi" class="form-control" required>
                                <option value="">-- Pilih Prestasi --</option>
                                @foreach($sub_kriteria_prestasi as $sub)
                                    <option value="{{ $sub->id_sub_kriteria }}">{{ $sub->nama_sub }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="organisasi" class="form-label">Organisasi</label>
                            <select name="organisasi" class="form-control" required>
                                <option value="">-- Pilih Organisasi --</option>
                                @foreach($sub_kriteria_organisasi as $sub)
                                    <option value="{{ $sub->id_sub_kriteria }}">{{ $sub->nama_sub }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>       

                    <!-- Kolom Poin Kecerdasan Majemuk -->
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">Poin Kecerdasan Majemuk</label>
                            <input type="number" name="kec_linguistik" class="form-control mb-2" placeholder="Linguistik" min="0" max="7">
                            <input type="number" name="kec_musikal" class="form-control mb-2" placeholder="Musikal" min="0" max="7">
                            <input type="number" name="kec_logika_matematis" class="form-control mb-2" placeholder="Logika/Matematis" min="0" max="7">
                            <input type="number" name="kec_spasial" class="form-control mb-2" placeholder="Spasial" min="0" max="7">
                            <input type="number" name="kec_kinestetik" class="form-control mb-2" placeholder="Kinestetik" min="0" max="7">
                            <input type="number" name="kec_interpersonal" class="form-control mb-2" placeholder="Interpersonal" min="0" max="7">
                            <input type="number" name="kec_intrapersonal" class="form-control mb-2" placeholder="Intrapersonal" min="0" max="7">
                            <input type="number" name="kec_naturalis" class="form-control mb-2" placeholder="Naturalis" min="0" max="7">
                            <input type="number" name="kec_eksistensial" class="form-control mb-2" placeholder="Eksistensial" min="0" max="7">
                        </div>
                    </div>              
                                    
                    <!-- Kolom Program Studi -->
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="nama_prodi" class="form-label">Program Studi</label>
                            <select name="nama_prodi" class="form-control" required>
                                <option value="">-- Pilih Program Studi --</option>
                                @foreach($prodi as $p)
                                    <option value="{{ $p->id_prodi }}">{{ $p->nama_prodi }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Tombol Simpan & Kembali -->
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-sm btn-danger"
                            onclick="window.location.href='{{ url('kasus_lama') }}'">Kembali</button>
                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection
