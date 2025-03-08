<div class="container-fluid">
    <div class="text-center mb-3">
        <h4 class="mb-4">{{ $user->nama }}</h4>
    </div>
    <div class="row">
        <div class="col-md-5">
            <div class="image-container text-center" style="position: sticky; top: 20px;">
                @if ($user->foto != '')
                <img src="{{ asset('storage/' . $user->foto) }}" alt="Foto User" class="img-fluid"
                    style="width: auto; height: 30vh;">
                @else
                    <img src="{{ asset('storage/asset_web/No Image Profile.png') }}" alt="Foto Pengguna"
                        class="img-fluid" style="width: auto; height: 30vh;">
                @endif
            </div>
        </div>
        <div class="col-md-7">
            <div style="max-height: 30vh; overflow-y: auto; padding-right: 15px;">
                <p><strong>Username : </strong> {{ $user->username ?? '-' }} </p>
                <p><strong>NIP : </strong> {{ $user->nip ?? '-' }} </p>
                <p><strong>Jenis Kelamin : </strong> {{ $user->jenis_kelamin ?? '-' }} </p>
                <p><strong>Tanggal Lahir : </strong> {{ $user->tanggal_lahir ?? '-' }} </p>
                <p><strong>Nomor HP : </strong> {{ $user->no_hp ?? '-' }} </p>
                <p><strong>Alamat : </strong> {{ $user->alamat ?? '-' }} </p>
            </div>
        </div>
    </div>
</div>


{{-- <div class="container">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="text-center mb-3">
        <h4 class="mb-4">{{ $user->nama }}</h4>
    </div>

    <div class="row">
        <div class="col-md-5">
            <div class="image-container text-center" style="position: sticky; top: 20px;">
                <img src="{{ $user->foto ? Storage::url($user->foto) : asset('default-image.jpg') }}" alt="Foto User" class="img-fluid rounded mb-3">
            </div>
        </div>

        <div class="col-md-7">
            <div style="padding-right: 15px;">
                <p><strong>Username : </strong> {{ $user->username ?? '-' }} </p>
                <p><strong>NIP : </strong> {{ $user->nip ?? '-' }} </p>
                <p><strong>Jenis Kelamin : </strong> {{ $user->jenis_kelamin ?? '-' }} </p>
                <p><strong>Tanggal Lahir : </strong> {{ $user->tanggal_lahir ?? '-' }} </p>
                <p><strong>Nomor HP : </strong> {{ $user->no_hp ?? '-' }} </p>
                <p><strong>Alamat : </strong> {{ $user->alamat ?? '-' }} </p>
            </div>
        </div>
    </div>
</div> --}}






