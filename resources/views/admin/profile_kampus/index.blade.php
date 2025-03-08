@extends('layouts.template')

@section('content')
<div class="container">
    <h2>Kelola Profile Kampus</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($hero)
        <div class="card">
            <div class="card-header">
                <h5>Profile Kampus</h5>
            </div>
            <div class="card-body">
                <p><strong>Judul:</strong> {{ $hero->judul }}</p>
                <p><strong>Deskripsi:</strong> {{ $hero->deskripsi }}</p>
                <p><strong>Link YouTube:</strong> <a href="{{ $hero->youtube_link }}" target="_blank">{{ $hero->youtube_link }}</a></p>
                <img src="{{ asset('storage/' . $hero->logo) }}" width="100" alt="Logo Kampus">
                <a href="{{ route('profile_kampus.edit', $hero->id) }}" class="btn btn-primary mt-3">Edit Profile</a>
            </div>
        </div>
    @else
        <p>Tidak ada data profile kampus.</p>
    @endif
</div>
@endsection
