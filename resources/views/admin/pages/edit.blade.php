@extends('layouts.template')

@section('title', 'Edit Halaman')

@section('content')
    <div class="card">
        <div class="card-header">Edit Halaman</div>
        <div class="card-body">
                <form action="{{ route('admin.pages.update', ['page' => $pages->id_pages]) }}" method="POST">

                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="title">Judul Halaman</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $pages->title) }}" required>
                </div>

                <div class="form-group">
                    <label for="slug">Slug</label>
                    <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug', $pages->slug) }}" placeholder="Biarkan kosong jika ingin otomatis">
                    {{-- <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug', $pages->slug) }}" required> --}}
                </div>
                

                <div class="form-group">
                    <label for="content">Konten</label>
                    <textarea class="form-control" id="content" name="content" rows="5" required>{{ old('content', $pages->content) }}</textarea>
                </div>

                <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection
