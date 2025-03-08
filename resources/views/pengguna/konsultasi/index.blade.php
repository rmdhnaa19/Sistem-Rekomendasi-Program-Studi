@extends('layouts.navbar')
@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

<style>
    .form-wrapper {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 120px 20px 5px;
        background-color: white;
    }

    .container-form {
        background: white;
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        max-width: 700px;
        width: 100%;
        /* margin-bottom: 20px; */
    }

    .container-form h2 {
        text-align: center;
        color: #0a0f54;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-control {
        height: 45px;
        font-size: 16px;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ced4da;
    }

    .btn-primary {
        width: 100%;
        padding: 15px;
        font-size: 18px;
        font-weight: bold;
        background-color: #e3a33b;
        border: none;
        border-radius: 5px;
        transition: 0.3s ease-in-out;
    }

    .btn-primary:hover {
        background-color: white;
        color: #e3a33b;
        border: 2px solid #e3a33b;
    }

    .error-message {
        color: red;
        font-size: 14px;
        display: none;
    }

    .select2-container .select2-selection--single {
        height: 45px !important;
        display: flex;
        align-items: center;
        border: 1px solid #ced4da;
        border-radius: 5px;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 45px !important;
        padding-left: 12px;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 45px !important;
    }

    @media (max-width: 576px) {
        .container-form {
            padding: 20px;
            max-width: 100%;
        }

        .btn-primary {
            font-size: 16px;
            padding: 10px;
        }
    }
</style>

<body>
    <div class="form-wrapper">
        <div class="container-form">
            <h2>KONSULTASI</h2>
            <form action="{{ route('konsultasi.store') }}" method="POST">
                @csrf                
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Anda" value="{{ old('nama') }}" required autofocus>
                    <div class="error-message">Wajib diisi!</div>
                </div>
                <div class="form-group">
                    <label for="jurusan_asal">Jurusan Asal</label>
                    <select name="jurusan_asal" class="form-control select2" required>
                        <option value="">-- Pilih Jurusan Asal --</option>
                        @foreach($sub_kriteria_jurusan as $sub)
                            <option value="{{ $sub->id_sub_kriteria }}">{{ $sub->nama_sub }}</option>
                        @endforeach
                    </select>
                </div>   
                <div class="form-group">
                    <label for="nilai_rata_rata_rapor">Nilai Rata-rata Rapor</label>
                    <input type="number" step="0.01" class="form-control" id="nilai_rata_rata_rapor" name="nilai_rata_rata_rapor" placeholder="Masukkan nilai rata-rata rapor" required>
                    <div class="error-message">Wajib diisi!</div>
                </div>
                <div class="form-group">
                    <label for="prestasi">Prestasi</label>
                    <select name="prestasi" class="form-control select2" required>
                        <option value="">-- Pilih Prestasi --</option>
                        @foreach($sub_kriteria_prestasi as $sub)
                            <option value="{{ $sub->id_sub_kriteria }}">{{ $sub->nama_sub }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="organisasi">Organisasi</label>
                    <select name="organisasi" class="form-control select2" required>
                        <option value="">-- Pilih Organisasi --</option>
                        @foreach($sub_kriteria_organisasi as $sub)
                            <option value="{{ $sub->id_sub_kriteria }}">{{ $sub->nama_sub }}</option>
                        @endforeach
                    </select>
                </div>      
                <button type="submit" class="btn btn-primary">SELANJUTNYA</button>
            </form>
        </div>
    </div>

<script>        
    $(document).ready(function() {
        $('.select2').select2({
            width: '100%',
            placeholder: '-- Pilih Opsi--',
            allowClear: false
        });
    });

    $("#form-konsultasi").on("submit", function(event) {
        let isValid = true;
        $(".form-control").each(function() {
            if ($(this).val().trim() === "") {
                $(this).siblings(".error-message").show();
                isValid = false;
            } else {
                $(this).siblings(".error-message").hide();
            }
        });

        if (!isValid) {
            event.preventDefault();
        }
    });

    $(".form-control").on("input change", function() {
        $(this).siblings(".error-message").hide();
    });
</script>
</body>
</html>
