<table>
    <tr><th>No</th><th>Kasus Lama</th><th>Program Studi</th><th>Nilai Kemiripan</th></tr>
    @foreach($hasil as $index => $h)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $h['kd_kasus_lama'] }}</td>
            <td>{{ $h['nama_prodi'] }}</td>
            <td>{{ $h['nilai_kemiripan'] }}</td>
        </tr>
    @endforeach
</table>
