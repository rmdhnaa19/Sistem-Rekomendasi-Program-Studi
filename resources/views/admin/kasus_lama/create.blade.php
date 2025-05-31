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

                    {{-- <div class="col-md-12">
                        <div class="form-group">
                            <label for="jurusan_asal" class="form-label">Jurusan Asal</label>
                            <select name="jurusan_asal" class="form-control" required>
                                <option value="">-- Pilih Jurusan Asal --</option>
                                @foreach($jurusan_asal as $jurusan)
                                    <option value="{{ $jurusan->id }}">{{ $jurusan->nama }}</option>
                                @endforeach
                            </select>                        
                        </div>
                    </div> --}}

                    <div class="col-md-12">
                    <div class="form-group">
                        <label for="id_jurusan_asal" class="form-label">Jurusan Asal</label>
                        <select class="choices form-select @error('id_jurusan_asal') is-invalid @enderror" name="id_jurusan_asal"
                            id="id_jurusan_asal">
                            <option value="{{ old('id_jurusan_asal') }}">- Pilih Jurusan Asal -</option>
                            @foreach ($jurusan_asal as $item)
                                <option value="{{ $item->id_jurusan_asal }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('id_jurusan_asal'))
                            <span class="text-danger">{{ $errors->first('id_jurusan_asal') }}</span>
                        @endif
                    </div>
                    
                    {{-- <div class="col-md-12">
                        <div class="form-group">
                            <label for="prestasi" class="form-label">Prestasi</label>
                            <select name="prestasi" class="form-control" required>
                                <option value="">-- Pilih Prestasi --</option>
                                @foreach($prestasi as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div> --}}

                    <div class="col-md-12">
                    <div class="form-group">
                        <label for="id_prestasi" class="form-label">Prestasi</label>
                        <select class="choices form-select @error('id_prestasi') is-invalid @enderror" name="id_prestasi"
                            id="id_prestasi">
                            <option value="{{ old('id_prestasi') }}">- Pilih Prestasi -</option>
                            @foreach ($prestasi as $item)
                                <option value="{{ $item->id_prestasi }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('id_prestasi'))
                            <span class="text-danger">{{ $errors->first('id_prestasi') }}</span>
                        @endif
                    </div>
                    
                    {{-- <div class="col-md-12">
                        <div class="form-group">
                            <label for="organisasi" class="form-label">Organisasi</label>
                            <select name="organisasi" class="form-control" required>
                                <option value="">-- Pilih Organisasi --</option>
                                @foreach($organisasi as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div> --}}
                    
                    <div class="col-md-12">
                    <div class="form-group">
                        <label for="id_organisasi" class="form-label">Organisasi</label>
                        <select class="choices form-select @error('id_organisasi') is-invalid @enderror" name="id_organisasi"
                            id="id_organisasi">
                            <option value="{{ old('id_organisasi') }}">- Pilih Organisasi -</option>
                            @foreach ($organisasi as $item)
                                <option value="{{ $item->id_organisasi }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('id_organisasi'))
                            <span class="text-danger">{{ $errors->first('id_organisasi') }}</span>
                        @endif
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
                                    
                    {{-- <div class="col-md-12">
                    <div class="form-group">
                        <label for="id_prodi" class="form-label">Program Studi</label>
                        <select class="choices form-select @error('id_prodi') is-invalid @enderror" name="id_prodi"
                            id="id_prodi">
                            <option value="{{ old('id_prodi') }}">- Pilih Program Studi -</option>
                            @foreach ($prodi as $item)
                                <option value="{{ $item->id_prodi }}">{{ $item->nama_prodi }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('id_prodi'))
                            <span class="text-danger">{{ $errors->first('id_prodi') }}</span>
                        @endif
                    </div>
                </div> --}}

                <div class="col-md-12">
    <div class="form-group">
        <label for="id_prodi" class="form-label">Program Studi</label>
        <select class="choices form-select @error('id_prodi') is-invalid @enderror" name="id_prodi"
            id="id_prodi" required>
            <option value="">- Pilih Program Studi -</option>
            @foreach ($prodi as $item)
                <option value="{{ $item->id_prodi }}" {{ old('id_prodi') == $item->id_prodi ? 'selected' : '' }}>
                    {{ $item->nama_prodi }}
                </option>
            @endforeach
        </select>
        @if ($errors->has('id_prodi'))
            <span class="text-danger">{{ $errors->first('id_prodi') }}</span>
        @endif
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
