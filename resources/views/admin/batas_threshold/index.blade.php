@extends('layouts.template')

@section('content')
<div class="container">
    <h2>Kelola Batas Threshold</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($threshold)
        <div class="card">
            <div class="card-header">
                <h5>Batas Threshold</h5>
            </div>
            <div class="card-body">
                <p><strong>Nilai Threshold Saat Ini:</strong> {{ $threshold->nilai_threshold }}</p>
                <a href="{{ route('batas_threshold.edit') }}" class="btn btn-primary mt-3">Edit Threshold</a>
            </div>
        </div>
    @else
        <p>Belum ada data batas threshold.</p>
    @endif
</div>
@endsection
