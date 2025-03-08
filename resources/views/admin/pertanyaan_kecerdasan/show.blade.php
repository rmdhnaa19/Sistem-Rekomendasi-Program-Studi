<div class="modal-body">
    <div class="text-center mb-3">
        <h4 class="fw-bold">{{ $pertanyaan_kecerdasan->kecerdasan_majemuk->nama_kecerdasan }}</h4>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div style="padding: 10px;">
                <p><strong>Pertanyaan :</strong> {{ $pertanyaan_kecerdasan->pertanyaan }}</p>
                <p><strong>Jenis Kecerdasan :</strong> {{ $pertanyaan_kecerdasan->kecerdasan_majemuk->nama_kecerdasan ?? 'Jenis Kecerdasan tidak ditemukan'}}</p>
                <p><strong>Deskripsi :</strong> {{ $pertanyaan_kecerdasan->kecerdasan_majemuk->deskripsi ?? 'Deskripsi jenis kecerdasan tidak ditemukan'}}</p>
            </div>
        </div>
    </div>
</div>