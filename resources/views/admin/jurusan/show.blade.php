<div class="container-fluid">
    <div class="text-center mb-3">
        <h4 class="mb-4">{{ $jurusan->nama_jurusan }}</h4>
    </div>
    <div class="col-md-12">
        <div style="max-height: 30vh; padding-right: 15px;">
            <p><strong>Nama Jurusan : </strong> {{ $jurusan->nama_jurusan ?? '-' }} </p>
            <div style="display: flex; align-items: start;">
                <p style="flex-shrink: 0;"><strong>Deskripsi :</strong></p>
                <p style="margin-left: 10px; text-align: justify; flex-grow: 1;">
                    {{ $jurusan->deskripsi ?? '-' }}
                </p>
            </div>
        </div>
    </div>
</div>
