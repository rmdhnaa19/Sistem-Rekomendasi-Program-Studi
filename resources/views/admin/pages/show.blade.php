@extends('layouts.template')

@section('title', $page->title ?? 'Judul Tidak Ditemukan')

@section('content')
    <div class="card">
        <div class="card-header">
            {{ $page->title ?? 'Judul Tidak Ditemukan' }}
        </div>
        <div class="card-body">
            <p>{!! $page->content ?? 'Konten Tidak Tersedia' !!}</p>
        </div>
    </div>
@endsection
