<?php

namespace App\Http\Controllers;

use App\Models\KasusLamaModel;
use App\Models\KriteriaModel;
use App\Models\JurusanAsalModel;
use App\Models\NormalisasiModel;
use App\Models\PrestasiModel;
use App\Models\OrganisasiModel;
use App\Models\ProdiModel;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class KasusLamaController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Kelola Data Kasus Lama',
            'paragraph' => 'Berikut ini merupakan data kasus lama yang tersimpan dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Kelola Kasus Lama'],
            ]
        ];
        $activeMenu = 'kasus_lama';
    
        // Ambil semua data dari tabel kasus_lama (tanpa relasi)
        $kasusLama = KasusLamaModel::all();
    
        return view('admin.kasus_lama.index', compact('breadcrumb', 'activeMenu', 'kasusLama'));
    }

    public function list(Request $request)
{
    // Ambil data dari tabel kasus_lama tanpa relasi
    $kasus_lamas = KasusLamaModel::query();

    // Filter berdasarkan nama_prodi jika dikirim (asumsinya kolom 'nama_prodi' ada langsung di tabel kasus_lama)
    if ($request->nama_prodi) {
        $kasus_lamas->where('nama_prodi', $request->nama_prodi);
    }

    return DataTables::of($kasus_lamas)
        ->editColumn('jurusan_asal', function ($row) {
            return $row->jurusan_asal ?? '-'; // Ambil langsung dari kolom
        })
        ->editColumn('prestasi', function ($row) {
            return $row->prestasi ?? '-'; // Ambil langsung dari kolom
        })
        ->editColumn('organisasi', function ($row) {
            return $row->organisasi ?? '-'; // Ambil langsung dari kolom
        })
        ->editColumn('prodi', function ($row) {
            return $row->nama_prodi ?? '-'; // Ambil langsung dari kolom
        })
        ->rawColumns(['jurusan_asal', 'prestasi', 'organisasi', 'prodi'])
        ->make(true);
}

    public function create()
{
    $breadcrumb = (object) [
        'title' => 'Tambah Data Kasus Lama',
        'paragraph' => 'Berikut ini merupakan form tambah data kasus lama yang terinput ke dalam sistem',
        'list' => [
            ['label' => 'Home', 'url' => route('dashboard.index')],
            ['label' => 'Kelola Kasus Lama', 'url' => route('admin.kasus_lama.index')],
            ['label' => 'Tambah'],
        ]
    ];

    $activeMenu = 'kasus_lama';

    // Ambil data referensi untuk dropdown
    $prodi = ProdiModel::all();
    $jurusan_asal = JurusanAsalModel::all();
    $prestasi = PrestasiModel::all();
    $organisasi = OrganisasiModel::all();

    return view('admin.kasus_lama.create', compact(
        'breadcrumb',
        'activeMenu',
        'prodi',
        'jurusan_asal',
        'prestasi',
        'organisasi'
    ));
}



    public function store(Request $request)
    {
        // Generate kode kasus lama
        $latestKasus = KasusLamaModel::latest()->first();
        $newNumber = $latestKasus ? (int)substr($latestKasus->kd_kasus_lama, 2) + 1 : 1;
        $newKode = 'KL' . str_pad($newNumber, ($newNumber < 100 ? 2 : strlen($newNumber)), '0', STR_PAD_LEFT);

        // Validasi input
        $validatedData = $request->validate([
            'nama' => 'required|string|max:50',
            'id_jurusan_asal' => 'required|integer|exists:jurusan_asal,id_jurusan_Asal',
            'id_prestasi' => 'required|integer|exists:prestasi,id_prestasi',
            'id_organisasi' => 'required|integer|exists:organisasi,id_organisasi',
            'nilai_rata_rata_rapor' => 'required|numeric|min:0|max:100',
            'kec_linguistik' => 'nullable|integer|min:0|max:7',
            'kec_musikal' => 'nullable|integer|min:0|max:7',
            'kec_logika_matematis' => 'nullable|integer|min:0|max:7',
            'kec_spasial' => 'nullable|integer|min:0|max:7',
            'kec_kinestetik' => 'nullable|integer|min:0|max:7',
            'kec_interpersonal' => 'nullable|integer|min:0|max:7',
            'kec_intrapersonal' => 'nullable|integer|min:0|max:7',
            'kec_naturalis' => 'nullable|integer|min:0|max:7',
            'kec_eksistensial' => 'nullable|integer|min:0|max:7',
            'id_prodi' => 'required|integer|exists:prodi,id_prodi',
        ]);

        $normalisasiData = [];
        $normalisasiData['nilai_rata_rata_rapor'] = $request->nilai_rata_rata_rapor;

        // Set default 0 untuk kecerdasan jika null
        $kecerdasanFields = [
            'kec_linguistik', 'kec_musikal', 'kec_logika_matematis', 'kec_spasial',
            'kec_kinestetik', 'kec_interpersonal', 'kec_intrapersonal',
            'kec_naturalis', 'kec_eksistensial'
        ];
        foreach ($kecerdasanFields as $field) {
            $validatedData[$field] = $validatedData[$field] ?? 0;
            $normalisasiData[$field] = $validatedData[$field] ?? 0;
        }

        
        $validatedData['jurusan_asal'] = JurusanAsalModel::find($validatedData['id_jurusan_asal'])->nama;
        $validatedData['prestasi'] = PrestasiModel::find($validatedData['id_prestasi'])->nama;
        $validatedData['organisasi'] = OrganisasiModel::find($validatedData['id_organisasi'])->nama;
        $validatedData['nama_prodi'] = ProdiModel::find($validatedData['id_prodi'])->nama_prodi;

        //Data normalisasi 
        $normalisasiData['jurusan_asal'] = JurusanAsalModel::find($validatedData['id_jurusan_asal'])->nilai;
        $normalisasiData['prestasi'] = PrestasiModel::find($validatedData['id_prestasi'])->nilai;
        $normalisasiData['organisasi'] = OrganisasiModel::find($validatedData['id_organisasi'])->nilai;
        $normalisasiData['id_prodi'] = ProdiModel::find($validatedData['id_prodi'])->id_prodi;
        

        // Hapus field yang tidak ada di DB agar tidak error saat create
        unset($validatedData['id_jurusan_asal'], $validatedData['id_prestasi'], 
              $validatedData['id_organisasi'], $validatedData['id_prodi']);

        // Tambahkan kode kasus lama
        $validatedData['kd_kasus_lama'] = $newKode;
        $normalisasiData['kd_kasus_lama'] = $newKode;

        // Simpan ke database
        KasusLamaModel::create($validatedData);
        NormalisasiModel::create($normalisasiData);
        

        Alert::toast('Data Kasus Lama berhasil ditambahkan', 'success');
        return redirect()->route('admin.kasus_lama.index');
    }

    public function show($id)
    {
        $kasus_lama = KasusLamaModel::with(['prodi', 'jurusanAsal', 'prestasiRelasi', 'organisasiRelasi'])->find($id);
        
        if (!$kasus_lama) {
            return response()->json(['error' => 'Kasus lama tidak ditemukan.'], 404);
        }

        $view = view('admin.kasus_lama.show', compact('kasus_lama'))->render();
        return response()->json(['html' => $view]);
    }

    public function edit($id)
    {
        $kasus_lama = KasusLamaModel::where('id_kasus_lama', $id)->first();
        
        if (!$kasus_lama) {
            return redirect()->route('admin.kasus_lama.index')->with('error', 'Kasus lama tidak ditemukan');
        }
        
        // Ambil data dari tabel masing-masing
        $jurusan_asal = JurusanAsalModel::all();
        $prestasi = PrestasiModel::all();
        $organisasi = OrganisasiModel::all();        
        $list_prodi = ProdiModel::all();

        $breadcrumb = (object) [
            'title' => 'Edit Data Kasus Lama',
            'paragraph' => 'Berikut ini merupakan form edit data kasus lama yang ada di dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Kasus Lama', 'url' => route('admin.kasus_lama.index')],
                ['label' => 'Edit'],
            ]
        ];

        $activeMenu = 'kasus_lama';

        return view('admin.kasus_lama.edit', compact(
            'kasus_lama', 
            'list_prodi', 
            'jurusan_asal', 
            'prestasi', 
            'organisasi',
            'breadcrumb', 
            'activeMenu'
        ));
    }

    public function update(Request $request, $id)
{
    $kasus_lama = KasusLamaModel::where('id_kasus_lama', $id)->firstOrFail();

    $validatedData = $request->validate([
        'nama' => 'required|string|max:50',
        'jurusan_asal' => 'required|string|exists:jurusan_asal,nama', 
        'prestasi' => 'required|string|exists:prestasi,nama',
        'organisasi' => 'required|string|exists:organisasi,nama',
        'nilai_rata_rata_rapor' => 'required|numeric|min:0|max:100',
        'kec_linguistik' => 'required|integer|min:0|max:7',
        'kec_musikal' => 'required|integer|min:0|max:7',
        'kec_logika_matematis' => 'required|integer|min:0|max:7',
        'kec_spasial' => 'required|integer|min:0|max:7',
        'kec_kinestetik' => 'required|integer|min:0|max:7',
        'kec_interpersonal' => 'required|integer|min:0|max:7',
        'kec_intrapersonal' => 'required|integer|min:0|max:7',
        'kec_naturalis' => 'required|integer|min:0|max:7',
        'kec_eksistensial' => 'required|integer|min:0|max:7',
        'id_prodi' => 'required|integer|exists:prodi,id_prodi'
    ]);

    // Cari nama prodi dari id_prodi yang dipilih
    $validatedData['nama_prodi'] = ProdiModel::find($validatedData['id_prodi'])->nama_prodi;

    // Hapus id_prodi karena di tabel kasus_lama tidak ada kolom id_prodi (atau memang tidak ingin disimpan)
    unset($validatedData['id_prodi']);

    // Simpan langsung data validasi, sudah dalam format nama string
    $kasus_lama->update($validatedData);

    Alert::toast('Data Kasus Lama berhasil diperbarui', 'success');
    return redirect()->route('admin.kasus_lama.index');
}

    public function destroy($id)
    {
        $kasus_lama = KasusLamaModel::where('id_kasus_lama', $id)->first();
    
        if (!$kasus_lama) {
            return response()->json([
                'success' => false,
                'message' => 'Data kasus lama tidak ditemukan.'
            ], 404);
        }
    
        try {
            $kasus_lama->delete();
            return response()->json([
                'success' => true,
                'message' => 'Data kasus lama berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data: ' . $e->getMessage()
            ], 500);
        }
    }
}