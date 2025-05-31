@extends('layouts.template')
@section('title', 'Kelola Batas Threshold')
@section('content')

<div class="container">
    <form action="{{ route('batas_threshold.update') }}" method="POST">
        @csrf
        @method('POST')

        {{-- Nilai Threshold --}}
        <div class="mb-4">
            <label class="form-label">Nilai Threshold Saat ini</label>
            <input type="number" step="0.01" min="0" max="1" name="nilai_threshold" class="form-control" 
                value="{{ old('nilai_threshold', $threshold->nilai_threshold ?? '') }}" required>
            @error('nilai_threshold')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- Tombol Submit --}}
        <button type="submit" class="btn btn-primary">Perbarui Threshold</button>
    </form>
</div>

@endsection
