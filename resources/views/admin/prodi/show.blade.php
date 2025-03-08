<div class="modal-body">
    <div class="text-center mb-3">
        <h4 class="fw-bold">{{ $prodi->nama_prodi }}</h4>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div style="padding: 10px;">
                <p><strong>Nama Jurusan :</strong> {{ $prodi->jurusan->nama_jurusan ?? 'Jurusan tidak ditemukan' }}</p>
                <p><strong>Akreditasi :</strong> {{ $prodi->akreditasi }}</p>
                <p><strong>Jenjang :</strong> {{ $prodi->jenjang }}</p>
                <p><strong>Durasi Studi :</strong> {{ $prodi->durasi_studi }}</p>
                <p><strong>Deskripsi :</strong></p>
                <p class="text-muted" style="text-align: justify;">{{ $prodi->deskripsi }}</p>
            </div>
        </div>
    </div>
</div>


{{-- <div class="container-fluid">
    <div class="text-center mb-3">
        <h4 class="mb-4">{{ $prodi->nama_prodi }}</h4>
    </div>
    <div class="col-md-12">
        <div style="max-height: 30vh; padding-right: 15px;">
            <p><strong> Jurusan : </strong> {{ $prodi->jurusan->nama_jurusan ?? 'Jurusan tidak ditemukan' }} </p>
            <div style="display: flex; align-items: start;">
            <p><strong> Akreditasi : </strong> {{ $prodi->akreditasi }} </p>
            <div style="display: flex; align-items: start;">
            <p><strong> Jenjang : </strong> {{ $prodi->jenjang }} </p>
            <div style="display: flex; align-items: start;">
            <p><strong> Durasi Studi : </strong> {{ $prodi->durasi_studi }} </p>
            <div style="display: flex; align-items: start;">
            <p style="flex-shrink: 0;"><strong>Deskripsi :</strong></p>
            <p style="margin-left: 10px; text-align: justify; flex-grow: 1;"> {{ $jurusan->deskripsi ?? '-' }} </p>
            </div>
        </div>
    </div>
</div> --}}




