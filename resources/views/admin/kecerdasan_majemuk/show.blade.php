<div class="container-fluid">
    <div class="text-center mb-3">
        <h4 class="mb-4">{{ $kecerdasan_majemuk->nama_kecerdasan }}</h4>
    </div>
    <div class="col-md-12">
        <div style="max-height: 30vh; padding-right: 15px;">
            <p><strong>Jenis Kecerdasan: </strong> {{ $kecerdasan_majemuk->nama_kecerdasan ?? '-' }} </p>
            <div style="display: flex; align-items: start;">
                <p style="flex-shrink: 0;"><strong>Deskripsi :</strong></p>
                <p style="margin-left: 10px; text-align: justify; flex-grow: 1;">
                    {{ $kecerdasan_majemuk->deskripsi ?? '-' }}
                </p>
            </div>
        </div>
    </div>
</div>
