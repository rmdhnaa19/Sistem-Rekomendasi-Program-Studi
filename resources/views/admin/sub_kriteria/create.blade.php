@extends('layouts.template')
@section('title', 'Tambah Sub Kriteria')
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
        <form method="POST" action="{{ url('sub_kriteria') }}" class="form-horizontal">
            @csrf
            <div class="row">

                <div class="col-md-12"> 
                    <div class="form-group">
                        <label for="id_kriteria" class="form-label">Nama Kriteria</label>
                        <select class="form-select" name="id_kriteria" id="id_kriteria" required>
                            <option value="" disabled selected>-- Pilih Nama Kriteria --</option>
                            @foreach ($kriteria as $item)
                                <option value="{{ $item->id_kriteria }}">{{ $item->nama_kriteria }}</option>
                            @endforeach
                        </select>
                    </div>
                    

                    <div class="form-group">        
                        <label for="nama_sub" class="form-label">Nama Sub Kriteria</label>
                        <input type="text" class="form-control" id="nama_sub" name="nama_sub" placeholder="Masukkan Nama Sub Kriteria">
                    </div>

                    <div class="form-group">        
                        <label for="nilai" class="form-label">Nilai Index</label>
                        <input type="number" class="form-control" id="nilai" name="nilai" placeholder="Masukkan Nilai Index">
                    </div>
                </div>
            </div>
            
            <div class="d-flex justify-content-between mt-4">
                <button type="button" class="btn btn-danger btn-sm" onclick="window.location.href='{{ url('sub_kriteria') }}'">Kembali</button>
                <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
