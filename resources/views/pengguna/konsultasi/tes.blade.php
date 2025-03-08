@extends('layouts.navbar')
@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
    .table {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    }

    .table thead {
        background-color: #0a2756;
        color: white;
        text-align: center;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
    }

    .table-bordered th, .table-bordered td {
        border: 1px solid #dee2e6;
    }

    .pagination-buttons {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
        
    }

    .pagination-buttons button {
        padding: 10px 20px;
        font-size: 18px;
        font-weight: bold;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .pagination-buttons button:hover {
        opacity: 0.8;
    }

    .warning-message {
        color: red;
        font-size: 14px;
        display: none;
    }
    .question-row.warning {
        background-color: #ffcccc !important;
    }

    .btn-prev {
        background-color: #6c757d;
        color: white;
    }

    .btn-next {
        background-color: #007bff;
        color: white;
    }

    .btn-choose {
        background-color: white;
        color: black;
        transition: all 0.3s ease;
        border: 2px solid;
    }

    .btn-choose[data-value="1"] {
        border-color: #28a745; /* Border hijau untuk Ya */
    }

    .btn-choose[data-value="0"] {
        border-color: #dc3545; /* Border merah untuk Tidak */
    }

    .btn-choose.selected-yes {
        background-color: #28a745 !important;
        color: white !important;
        border-color: #28a745 !important;
    }
    
    .btn-choose:hover {
        background-color: #b7b7b7!important;
        color: white !important;
        border: none !important;
    }

    .btn-choose.selected-no {
        background-color: #dc3545 !important;
        color: white !important;
        border-color: #dc3545 !important;
    }

    .warning {
        border: 2px solid red;
        background-color: #ffebee; 
    }
    
    .warning-message {
        color: red;
        font-size: 12px;
        display: none;
        margin-top: 5px;
    }

    .pagination-buttons {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-top: 20px;
    }

    .btn-submit {
        background-color: #28a745;
        color: white;
    }
    </style>
</head>
<body>
    <div class="container mt-5 pt-5">
        <h2 class="text-center">TES KECERDASAN</h2>
        <p class="text-center text-muted">Silakan pilih pernyataan yang sesuai dengan diri Anda.</p>

        <form action="{{ route('tes.store') }}" method="POST" id="tesForm">
            @csrf
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th width="10%" class="text-center">NO.</th>
                        <th width="70%">PERNYATAAN</th>
                        <th width="20%" class="text-center">PILIHAN</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pertanyaan_kecerdasan as $index => $pertanyaan)
                    <tr class="question-row" data-id="{{ $pertanyaan->id }}">
                        <td class="text-center">{{ $pertanyaan_kecerdasan->firstItem() + $index }}</td>
                        <td>{{ $pertanyaan->pertanyaan }}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-choose" data-value="1">Ya</button>
                            <button type="button" class="btn btn-choose" data-value="0">Tidak</button>
                            <input type="hidden" name="jawaban[{{ $pertanyaan->id }}]" class="jawaban-input">
                            <div class="warning-message">* Harap pilih salah satu</div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-center gap-3">
                @if ($pertanyaan_kecerdasan->previousPageUrl())
                    <a href="{{ $pertanyaan_kecerdasan->previousPageUrl() }}" class="btn btn-secondary">Sebelumnya</a>
                @endif
                @if ($pertanyaan_kecerdasan->hasMorePages())
                    <a href="{{ $pertanyaan_kecerdasan->nextPageUrl() }}" class="btn btn-primary">Selanjutnya</a>
                @else
                    <button type="submit" class="btn btn-success">Submit</button>
                @endif
            </div>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let kecerdasanData = {}; // Objek untuk menyimpan jawaban berdasarkan jenis kecerdasan
    
            // Event listener untuk tombol pilihan Ya/Tidak
            document.querySelectorAll(".btn-choose").forEach(button => {
                button.addEventListener("click", function() {
                    let row = this.closest("tr"); // Baris saat ini
                    let buttons = row.querySelectorAll(".btn-choose"); // Semua tombol dalam baris
                    let hiddenInput = row.querySelector(".jawaban-input"); // Input tersembunyi
                    let warning = row.querySelector(".warning-message"); // Peringatan
                    let questionId = row.dataset.id;
                    let kecerdasanId = row.dataset.kecerdasan; // Ambil ID kecerdasan
                    let pertanyaanText = row.querySelector("td:nth-child(2)").innerText;
    
                    // Reset tombol lain di baris ini
                    buttons.forEach(btn => {
                        btn.classList.remove("selected-yes", "selected-no");
                    });
    
                    // Tandai tombol yang dipilih & isi nilai input tersembunyi
                    if (this.dataset.value == "1") {
                        this.classList.add("selected-yes");
                        hiddenInput.value = "1";
    
                        // Tambahkan ke daftar jawaban berdasarkan kecerdasan
                        if (!kecerdasanData[kecerdasanId]) {
                            kecerdasanData[kecerdasanId] = [];
                        }
                        kecerdasanData[kecerdasanId].push(pertanyaanText);
                    } else {
                        this.classList.add("selected-no");
                        hiddenInput.value = "0";
    
                        // Hapus jika sebelumnya ada di daftar
                        if (kecerdasanData[kecerdasanId]) {
                            kecerdasanData[kecerdasanId] = kecerdasanData[kecerdasanId].filter(q => q !== pertanyaanText);
                        }
                    }
    
                    // Hilangkan peringatan jika pengguna sudah memilih
                    row.classList.remove("warning");
                    warning.style.display = "none";
                });
            });
    
            // Fungsi validasi sebelum tombol "Selanjutnya" ditekan
            function validateForm(event) {
                let isValid = true;
    
                document.querySelectorAll(".question-row").forEach(row => {
                    let hiddenInput = row.querySelector(".jawaban-input");
                    let warning = row.querySelector(".warning-message");
    
                    if (!hiddenInput.value) {
                        isValid = false;
                        row.classList.add("warning"); // Tambahkan highlight merah
                        warning.style.display = "block"; // Tampilkan peringatan
                    }
                });
    
                if (!isValid) {
                    event.preventDefault(); 
                }
            }
    
            // Event listener untuk tombol "Selanjutnya"
            document.querySelector(".btn-primary").addEventListener("click", validateForm);
    
            // Saat submit, tambahkan kecerdasanData ke input hidden untuk dikirim ke backend
            document.querySelector("#tesForm").addEventListener("submit", function() {
                let inputHidden = document.createElement("input");
                inputHidden.type = "hidden";
                inputHidden.name = "hasil_kecerdasan";
                inputHidden.value = JSON.stringify(kecerdasanData);
                this.appendChild(inputHidden);
            });
        });
    </script>
    