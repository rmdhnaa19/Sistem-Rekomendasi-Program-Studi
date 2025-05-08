@extends('layouts.template')
@section('title', 'Kelola Profile Kampus')
@section('content')

<div class="container">
    <form action="{{ route('profile_kampus.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('POST')

        {{-- Logo Kampus --}}
        <div class="mb-4 row align-items-center">
            <div class="col-md-6">
                <label class="form-label">Logo Kampus</label>
                <input type="file" name="logo_kampus" class="form-control">
            </div>
            <div class="col-md-6 d-flex align-items-center">
                @if($profile && $profile->logo_kampus)
                    <img src="{{ asset('storage/' . $profile->logo_kampus) }}" alt="Logo Kampus" class="img-fluid rounded border" style="max-width: 150px; height: auto;">
                @else
                    <p class="text-muted">Belum ada logo yang diunggah</p>
                @endif
            </div>
        </div>

        {{-- Logo PMB --}}
        <div class="mb-4 row align-items-center">
            <div class="col-md-6">
                <label class="form-label">Logo PMB</label>
                <input type="file" name="logo_pmb" class="form-control">
            </div>
            <div class="col-md-6 d-flex align-items-center">
                @if($profile && $profile->logo_pmb)
                    <img src="{{ asset('storage/' . $profile->logo_pmb) }}" alt="Logo PMB" class="img-fluid rounded border" style="max-width: 200px; height: auto;">
                @else
                    <p class="text-muted">Belum ada logo yang diunggah</p>
                @endif
            </div>
        </div>

        {{-- Judul --}}
        <div class="mb-3">
            <label class="form-label">Judul</label>
            <input type="text" name="judul" class="form-control" value="{{ old('judul', $profile->judul ?? '') }}">
        </div>

        {{-- Deskripsi --}}
        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="4">{{ old('deskripsi', $profile->deskripsi ?? '') }}</textarea>
        </div>

        {{-- YouTube Link --}}
        <div class="mb-3">
            <label class="form-label">Link YouTube</label>
            <input type="url" name="youtube_link" class="form-control" value="{{ old('youtube_link', $profile->youtube_link ?? '') }}">
        </div>

        {{-- Tombol Submit --}}
        <button type="submit" class="btn btn-primary">Perbarui</button>
    </form>
</div>

@endsection
