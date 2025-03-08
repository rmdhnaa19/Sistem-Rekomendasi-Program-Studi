@extends('layouts.template')
@section('title', 'Tambah Halaman')
@section('content')
    <div class="card">
        <div class="card-header">Tambah Halaman</div>
        <div class="card-body">
            <form action="{{ route('admin.pages.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="title">Judul</label>
                    <input type="text" name="title" id="title" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="slug">Slug</label>
                    <input type="text" name="slug" id="slug" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="content">Konten</label>
                    <textarea name="content" id="content" class="form-control" rows="5" required></textarea>
                </div>
                <div class="text-right">
                    <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
