<?php

namespace App\Http\Controllers;

use App\Models\KasusLamaModel;
use App\Models\KriteriaModel;
use App\Models\SubKriteriaModel;
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
    
        // Mengambil data KasusLama dengan relasi
        $kasusLama = KasusLamaModel::with(['prodi'])->get();
    
        return view('admin.kasus_lama.index', compact('breadcrumb', 'activeMenu', 'kasusLama'));
    }

    public function list(Request $request)
{
    $kasus_lamas = KasusLamaModel::select(
        'id_kasus_lama',
        'kd_kasus_lama',
        'nama',
        'jurusan_asal',
        'nilai_rata_rata_rapor',
        'prestasi',
        'organisasi',
        'kec_linguistik',
        'kec_musikal',
        'kec_logika_matematis',
        'kec_spasial',
        'kec_kinestetik',
        'kec_interpersonal',
        'kec_intrapersonal',
        'kec_naturalis',
        'kec_eksistensial',
        'id_prodi', 
        'created_at', 
        'updated_at'
    )
    ->with('prodi');

    if ($request->id_prodi) {
        $kasus_lamas->where('id_prodi', $request->id_prodi);
    }

    return DataTables::of($kasus_lamas)
        // Ganti kolom asli dengan kolom yang berisi nama_sub
        ->editColumn('jurusan_asal', function ($row) {
            $subKriteria = SubKriteriaModel::where('id_sub_kriteria', $row->jurusan_asal)->first();
            return $subKriteria ? $subKriteria->nama_sub : '-';
        })
        ->editColumn('prestasi', function ($row) {
            $subKriteria = SubKriteriaModel::where('id_sub_kriteria', $row->prestasi)->first();
            return $subKriteria ? $subKriteria->nama_sub : '-';
        })
        ->editColumn('organisasi', function ($row) {
            $subKriteria = SubKriteriaModel::where('id_sub_kriteria', $row->organisasi)->first();
            return $subKriteria ? $subKriteria->nama_sub : '-';
        })
        ->addColumn('prodi_nama', function ($row) {
            return $row->prodi ? $row->prodi->nama_prodi : '-';
        })
        ->rawColumns(['jurusan_asal', 'prestasi', 'organisasi', 'prodi_nama'])
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
    $kasus_lama = KasusLamaModel::all();
    $prodi = ProdiModel::all();

    // Ambil sub_kriteria berdasarkan id_kriteria tertentu
    $sub_kriteria_jurusan = SubKriteriaModel::where('id_kriteria', 16)->get(); // ID 1 untuk Jurusan Asal
    $sub_kriteria_prestasi = SubKriteriaModel::where('id_kriteria', 19)->get(); // ID 2 untuk Prestasi
    $sub_kriteria_organisasi = SubKriteriaModel::where('id_kriteria', 20)->get(); // ID 3 untuk Organisasi

    return view('admin.kasus_lama.create', compact('breadcrumb', 'activeMenu', 'kasus_lama', 'prodi', 'sub_kriteria_jurusan', 'sub_kriteria_prestasi', 'sub_kriteria_organisasi'
    ));
    }

    public function store(Request $request)
    {
        // Generate kode kasus lama, misalnya format "KL0001", "KL0002", dst.
        $latestKasus = KasusLamaModel::latest()->first();
        $newNumber = $latestKasus ? (int)substr($latestKasus->kd_kasus_lama, 2) + 1 : 1;

        // Format agar tetap dua digit hingga mencapai 100, lalu berkembang bebas
        $newKode = 'KL' . str_pad($newNumber, ($newNumber < 100 ? 2 : strlen($newNumber)), '0', STR_PAD_LEFT);

    
        // Validasi input
        $validatedData = $request->validate([
            'nama' => 'required|string|max:50',
            'jurusan_asal' => 'required|string', 
            'prestasi' => 'required|string',
            'organisasi' => 'required|string',
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
            'id_prodi' => 'required|integer',
        ]);
    
        // Ganti id_sub_kriteria dengan nilai sebelum menyimpan
        $validatedData['jurusan_asal'] = SubKriteriaModel::where('id_sub_kriteria', $request->jurusan_asal)->value('nilai');
        $validatedData['prestasi'] = SubKriteriaModel::where('id_sub_kriteria', $request->prestasi)->value('nilai');
        $validatedData['organisasi'] = SubKriteriaModel::where('id_sub_kriteria', $request->organisasi)->value('nilai');

        // Jika input kosong, set nilai ke 0
        $validatedData['kec_linguistik'] = $validatedData['kec_linguistik'] ?? 0;
        $validatedData['kec_musikal'] = $validatedData['kec_musikal'] ?? 0;
        $validatedData['kec_logika_matematis'] = $validatedData['kec_logika_matematis'] ?? 0;
        $validatedData['kec_spasial'] = $validatedData['kec_spasial'] ?? 0;
        $validatedData['kec_kinestetik'] = $validatedData['kec_kinestetik'] ?? 0;
        $validatedData['kec_interpersonal'] = $validatedData['kec_interpersonal'] ?? 0;
        $validatedData['kec_intrapersonal'] = $validatedData['kec_intrapersonal'] ?? 0;
        $validatedData['kec_naturalis'] = $validatedData['kec_naturalis'] ?? 0;
        $validatedData['kec_eksistensial'] = $validatedData['kec_eksistensial'] ?? 0;
        
        // Tambahkan kode kasus lama
        $validatedData['kd_kasus_lama'] = $newKode;
    
        // Simpan ke database
        KasusLamaModel::create($validatedData);
    
        Alert::toast('Data Kasus Lama berhasil ditambahkan', 'success');
        return redirect()->route('admin.kasus_lama.index');
    }
    

public function show($id)
{
    $kasus_lama = KasusLamaModel::with('prodi')->find($id);
    
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
    
    // Ambil semua sub kriteria untuk dropdown
    $sub_kriteria_jurusan = SubKriteriaModel::where('id_kriteria', 16)->get();
    $sub_kriteria_prestasi = SubKriteriaModel::where('id_kriteria', 19)->get();
    $sub_kriteria_organisasi = SubKriteriaModel::where('id_kriteria', 20)->get();
    
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
        'sub_kriteria_jurusan', 
        'sub_kriteria_prestasi', 
        'sub_kriteria_organisasi',
        'breadcrumb', 
        'activeMenu'
    ));
}

public function update(Request $request, $id)
{
    $kasus_lama = KasusLamaModel::where('id_kasus_lama', $id)->firstOrFail();

    $validatedData = $request->validate([
        'nama' => 'required|string|max:50',
        'jurusan_asal' => 'required', // Ini akan menerima ID sub kriteria
        'nilai_rata_rata_rapor' => 'required|numeric|min:0|max:100',
        'prestasi' => 'required', // Ini akan menerima ID sub kriteria
        'organisasi' => 'required', // Ini akan menerima ID sub kriteria
        'kec_linguistik' => 'required|integer|min:0',
        'kec_musikal' => 'required|integer|min:0',
        'kec_logika_matematis' => 'required|integer|min:0',
        'kec_spasial' => 'required|integer|min:0',
        'kec_kinestetik' => 'required|integer|min:0',
        'kec_interpersonal' => 'required|integer|min:0',
        'kec_intrapersonal' => 'required|integer|min:0',
        'kec_naturalis' => 'required|integer|min:0',
        'kec_eksistensial' => 'required|integer|min:0',
        'id_prodi' => 'required|integer'
    ]);

    // Simpan ID langsung ke database, tidak perlu konversi
    // ID sudah ada di request

    // Update data
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
