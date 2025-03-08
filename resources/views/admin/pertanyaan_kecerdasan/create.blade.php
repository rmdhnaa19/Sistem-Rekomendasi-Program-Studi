@extends('layouts.template')
@section('title', 'Kelola Pertanyaan')
@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ url('pertanyaan_kecerdasan') }}" class="form-horizontal" enctype="multipart/form-data" id="tambahPertanyaan">
                @csrf
                <div class="row">

                    <!-- Full Width Form -->
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="pertanyaan" class="form-label">Pertanyaan</label>
                            <input type="text" class="form-control" id="pertanyaan" name="pertanyaan"
                                placeholder="Masukkan pertanyaan kecerdasan majemuk" value="{{ old('pertanyaan') }}" required autofocus>
                            @error('pertanyaan')
                            <div class="invalid-feedback">
                                <i class="bx bx-radio-circle"></i>
                                Pertanyaan yang anda masukkan tidak valid
                            </div>
                            @enderror
                        </div>

                        {{-- ambil jenis kecerdasan dari tabel kecerdasan majemuk --}}
                        <div class="form-group">
                            <label for="id_kecerdasan_majemuk" class="form-label">Jenis Kecerdasan</label>
                            <select class="choices form-select @error('id_kecerdasan_majemuk') is-invalid @enderror" name="id_kecerdasan_majemuk"
                                id="id_kecerdasan_majemuk">
                                <option value="{{ old('id_kecerdasan_majemuk') }}">- Pilih Jenis Kecerdasan -</option>
                                @foreach ($kecerdasan_majemuk as $item)
                                    <option value="{{ $item->id_kecerdasan_majemuk }}">{{ $item->nama_kecerdasan }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('id_kecerdasan_majemuk'))
                                <span class="text-danger">{{ $errors->first('id_kecerdasan_majemuk') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-3">
                        <button type="button" class="btn btn-sm btn-danger"
                            onclick="window.location.href='{{ url('pertanyaan_kecerdasan') }}'"
                            style="background-color: #DC3545; border-color: #DC3545" id="btn-kembali">Kembali</button>
                        <button type="submit" class="btn btn-primary btn-sm"
                            style="background-color: #007BFF; border-color: #007BFF" id="btn-simpan">Simpan</button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
@endsection
