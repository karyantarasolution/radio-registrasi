<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\KaryawanExport;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class KaryawanController extends Controller
{
    public function index()
    {
        $karyawans = Karyawan::all();
        return view('karyawan.index', compact('karyawans'));
    }

    public function create()
    {
        return view('karyawan.create');
    }

    public function edit(Karyawan $karyawan)
    {
        return view('karyawan.edit', compact('karyawan'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'nrp' => 'required|string|max:50|unique:karyawans',
            'jabatan' => 'required|string|max:100',
            'departemen' => 'required|string|max:100',
            'qr_code' => 'nullable|image|mimes:png,jpg,jpeg|max:2048'
        ]);

        $data = $request->only(['nama', 'nrp', 'jabatan', 'departemen']);

        // 🟢 Ini bagian yang membuat Storage aktif
        if ($request->hasFile('qr_code')) {
            $file = $request->file('qr_code');
            $filename = time() . '_' . $file->getClientOriginalName();

            // Gunakan Storage facade di sini
            Storage::disk('public')->makeDirectory('qr_codes');
            $file->storeAs('qr_codes', $filename, 'public');

            $data['qr_code'] = $filename;
        }

        Karyawan::create($data);

        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $karyawan = Karyawan::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:100',
            'nrp' => 'required|string|max:50|unique:karyawans,nrp,' . $karyawan->id,
            'jabatan' => 'required|string|max:100',
            'departemen' => 'required|string|max:100',
            'qr_code' => 'nullable|image|mimes:png,jpg,jpeg|max:2048'
        ]);

        $data = $request->only(['nama', 'nrp', 'jabatan', 'departemen']);

        //  Jika user upload file baru
        if ($request->hasFile('qr_code')) {
            // Hapus file lama (kalau ada)
            if ($karyawan->qr_code && Storage::disk('public')->exists('qr_codes/' . $karyawan->qr_code)) {
                Storage::disk('public')->delete('qr_codes/' . $karyawan->qr_code);
            }

            // Simpan file baru
            $file = $request->file('qr_code');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('qr_codes', $filename, 'public');

            $data['qr_code'] = $filename;
        }

        $karyawan->update($data);

        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil diperbarui!');
    }

    public function destroy(Karyawan $karyawan)
    {
        if ($karyawan->qr_code && file_exists(public_path($karyawan->qr_code))) {
            unlink(public_path($karyawan->qr_code));
        }

        $karyawan->delete();
        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil dihapus.');
    }

    public function exportExcel()
    {
        return Excel::download(new KaryawanExport, 'data_karyawan.xlsx');
    }

    public function exportPDF()
    {
        $karyawans = Karyawan::orderBy('nama')->get();
        $pdf = Pdf::loadView('karyawan.report_all', compact('karyawans'))
            ->setPaper('A4', 'portrait');

        return $pdf->stream('laporan-karyawan-it.pdf');
    }

    public function report($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        $pdf = Pdf::loadView('karyawan.report', compact('karyawan'))
            ->setPaper('A4', 'portrait');

        return $pdf->stream('karyawan-' . $karyawan->nrp . '.pdf');
    }
}
