@extends('layouts.template')
@section('title', 'Dashboard')
@section('content')
<div class="row gy-3">
    <div class="col-md-4">
        <div class="card m-0" style="height: 200px;">
            <div class="card-body">
                <h5 class="card-title m-0">
                    <x-svg-icon icon="user" /> Total User
                </h5>
                <div class="card-body p-0 d-flex justify-content-center align-items-center">
                    <h1 style="font-size: 90px; font-weight: 900">{{ $totalUser }}</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card m-0" style="height: 200px;">
            <div class="card-body">
                <h5 class="card-title m-0">
                    <x-svg-icon icon="prodi" /> Total Jurusan
                </h5>
                <div class="card-body p-0 d-flex justify-content-center align-items-center">
                    <h1 style="font-size: 90px; font-weight: 900">{{ $totalJurusan }}</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card m-0" style="height: 200px;">
            <div class="card-body">
                <h5 class="card-title m-0">
                    <x-svg-icon icon="prodi" /> Total Program Studi
                </h5>
                <div class="card-body p-0 d-flex justify-content-center align-items-center">
                    <h1 style="font-size: 90px; font-weight: 900">{{ $totalProdi }}</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card m-0" style="height: 200px;">
            <div class="card-body">
                <h5 class="card-title m-0">
                    <x-svg-icon icon="kriteria" /> Total Kriteria
                </h5>
                <div class="card-body p-0 d-flex justify-content-center align-items-center">
                    <h1 style="font-size: 90px; font-weight: 900">{{ $totalKriteria }}</h1>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
@endpush
