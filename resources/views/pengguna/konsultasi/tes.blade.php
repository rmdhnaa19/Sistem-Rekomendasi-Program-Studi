@extends('layouts.navbar')
@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    
    <style>
    body {
        font-family: 'Poppins', sans-serif;
        font-size: 16px;
    }

    .table {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    }

    .dataTables_paginate {
        display: flex;
        justify-content: center;
    }

    .dataTables_wrapper .dataTables_paginate {
        justify-content: center !important;
        width: 100%;
        margin-bottom: 20px;
    }

    .dataTables_paginate .paginate_button {
        padding: 8px 15px !important;
        border-radius: 100px;
        background-color: #007bff;
        color: white !important;
        font-weight: bold;
        transition: all 0.3s;
        margin: 0 5px;
        margin-top: 20px;
    }

    .dataTables_paginate .paginate_button:hover {
        background-color: #0056b3 !important;
    }

    .dataTables_paginate .paginate_button.disabled {
        background-color: #d6d6d6 !important;
        color: #888 !important;
        cursor: not-allowed;
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

    .question-row.warning {
        background-color: #ffcccc !important;
    }

    .btn-choose {
        font-size: 16px;
        background-color: white;
        color: black;
        border: 2px solid;
        transition: all 0.3s ease;
        margin: 3px;
    }

    .btn-choose[data-value="1"] {
        border-color: #28a745;
    }

    .btn-choose[data-value="0"] {
        border-color: #dc3545;
    }

    .btn-choose.selected-yes {
        background-color: #28a745 !important;
        color: white !important;
        border-color: #28a745 !important;
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

    .btn-submit {
        background-color: #28a745;
        color: white;
    }

    @media (max-width: 768px) {
        .btn-choose {
            font-size: 0;
            width: 40px;
            height: 40px;
            padding: 0;
        }

        .btn-choose[data-value="1"]::before {
            content: '✅';
            font-size: 18px;
            display: inline-block;
        }

        .btn-choose[data-value="0"]::before {
            content: '❌';
            font-size: 18px;
            display: inline-block;
        }
    }
    </style>

    <div class="container pt-5">
        <h2 class="text-center">TES KECERDASAN</h2>
        <p class="text-center text-muted">Silakan pilih pernyataan yang sesuai dengan diri Anda.</p>
        <p class="text-center text-muted"><span id="terjawab">0</span>% telah dijawab</p>

        <form action="{{ route('tes.store') }}" method="POST" id="tesForm">
            @csrf
            <table class="table table-striped table-bordered" id="dataTable">
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
                        <td class="text-center">{{ $index+1 }}</td>
                        <td>{{ $pertanyaan->pertanyaan }}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-choose" data-value="1" value="1">Ya</button>
                            <button type="button" class="btn btn-choose" data-value="0" value="0">Tidak</button>
                            <input type="hidden" name="jawaban[{{ $pertanyaan->id_pertanyaan_kecerdasan }}]" class="jawaban-input">
                            <div class="warning-message">* Harap pilih salah satu</div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-center gap-3 btn-submit-wrapper">
                <button type="submit" class="btn btn-success mt-4 mb-4" id="btn-submit">Submit</button>
            </div>
        </form>
    </div>

    <script>
    var table;
    var pertanyaanTotal = {{ isset($pertanyaan_kecerdasan) ? $pertanyaan_kecerdasan->count() : 0 }}

    function terjawab(){

        var total = 0
        var data = table.$('input');
        $.each(data,function(i,v){
            if($(this).val() != ""){
                ++total
            }
        })

        let percent = Math.round(total / pertanyaanTotal * 100)
        $("#terjawab").text(percent) 
    }

    $(document).on("click",".btn-choose", function(){
        terjawab()
    })

    $(document).ready(function() {
        table = $('#dataTable').DataTable({
            searching: false,
            lengthChange: false,
            info: false,
            pagingType: "simple",
            ordering: false,
            drawCallback: function(settings) {
                let api = this.api();
                let pageInfo = api.page.info();

                if (pageInfo.page === (pageInfo.pages - 2) && (pageInfo.pages - 2) > -1) {
                    $('#btn-submit').show();
                    $('.dataTables_paginate').hide(); // Sembunyikan pagination
                    table.page.len(-1).draw();

                    setTimeout(() => {
                        $('html, body').animate({ scrollTop: $(document).height() }, 'fast');
                    }, 100);
                } else if(pageInfo.page < (pageInfo.pages - 1) && (pageInfo.pages - 1) > -1) {
                    $('#btn-submit').hide();
                    $('.dataTables_paginate').show(); // Tampilkan pagination lagi
                }
            },
            "language": {
                "paginate": {
                    "previous": "<i class='bi bi-arrow-left-circle'></i> Sebelumnya",
                    "next": "Selanjutnya <i class='bi bi-arrow-right-circle'></i>"
                }
            }
        });
        $('#btn-submit').hide();
    });

    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".btn-choose").forEach(button => {
            button.addEventListener("click", function() {
                let row = this.closest("tr");
                let buttons = row.querySelectorAll(".btn-choose");
                let hiddenInput = row.querySelector(".jawaban-input");
                let warning = row.querySelector(".warning-message");

                buttons.forEach(btn => {
                    btn.classList.remove("selected-yes", "selected-no");
                });

                if (this.dataset.value == "1") {
                    this.classList.add("selected-yes");
                    hiddenInput.value = "1";
                } else {
                    this.classList.add("selected-no");
                    hiddenInput.value = "0";
                }

                row.classList.remove("warning");
                warning.style.display = "none";
            });
        });

        document.querySelector("#btn-submit").addEventListener("click", function(event) {
            let isValid = true;
            document.querySelectorAll(".question-row").forEach(row => {
                let hiddenInput = row.querySelector(".jawaban-input");
                let warning = row.querySelector(".warning-message");

                if (!hiddenInput.value) {
                    isValid = false;
                    row.classList.add("warning");
                    warning.style.display = "block";
                }
            });

            if (!isValid) {
                event.preventDefault();
                alert("Harap jawab semua pertanyaan sebelum mengirim.");
            }
        });
    });
    </script>
@endsection
