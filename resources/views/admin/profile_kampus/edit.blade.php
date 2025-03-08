@extends('layouts.template')
@section('title', 'Kelola Profile Kampus')
@section('content')
<div class="container">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form action="{{ route('profile_kampus.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('POST')

        <div class="mb-3">
            <label class="form-label">Logo</label>
            <input type="file" name="logo" class="form-control">
            @if($profile && $profile->logo)
                <img src="{{ asset('storage/' . $profile->logo) }}" width="100" alt="Logo">
            @endif
        </div>

        <div class="mb-3">
            <label class="form-label">Judul</label>
            <input type="text" name="judul" class="form-control" value="{{ $profile->judul ?? '' }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="deskripsi" class="form-control">{{ $profile->deskripsi ?? '' }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Link YouTube</label>
            <input type="url" name="youtube_link" class="form-control" value="{{ $profile->youtube_link ?? '' }}">
        </div>

        <button type="submit" class="btn btn-primary">Perbarui</button>
    </form>
</div>

{{-- Tambahkan SweetAlert --}}
@if (session('success'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            title: 'Berhasil!',
            text: '{{ session("success") }}',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    </script>
@endif

@endsection
