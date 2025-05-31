<?php

namespace App\Http\Controllers;

use App\Models\BatasThresholdModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class BatasThresholdController extends Controller
{
    public function edit()
    {
        $threshold = BatasThresholdModel::first();

        if (!$threshold) {
            return redirect()->route('dashboard.index')->with('error', 'Data threshold belum tersedia.');
        }

        $breadcrumb = (object) [
            'title' => 'Edit Batas Threshold',
            'paragraph' => 'Berikut ini merupakan form untuk mengatur nilai batas threshold, nilai threshold berada pada rentang 0 -1',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Kelola Threshold', 'url' => route('batas_threshold.edit')],
                ['label' => 'Edit'],
            ]
        ];

        $activeMenu = 'batas_threshold';

        return view('admin.batas_threshold.edit', compact('breadcrumb', 'activeMenu', 'threshold'));
    }

    // Menyimpan perubahan nilai threshold
    public function update(Request $request)
    {
        $request->validate([
            'nilai_threshold' => 'required|numeric|min:0|max:1',
        ]);

        $threshold = BatasThresholdModel::first();

        if (!$threshold) {
            $threshold = new BatasThresholdModel();
        }

        $threshold->nilai_threshold = $request->nilai_threshold;
        $threshold->save();

        Alert::success('Berhasil', 'Nilai threshold berhasil diperbarui!');
        return redirect()->route('batas_threshold.edit');
    }
}