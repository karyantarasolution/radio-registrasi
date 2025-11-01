<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\KaryawanExport;
use Illuminate\Support\Facades\Storage;

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

    public function update(Request $request, Karyawan $karyawan)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'nrp' => 'required|string|max:50|unique:karyawans,nrp,',
            'jabatan' => 'required|string|max:100',
            'departemen' => 'required|string|max:100',
            'qr_code' => 'nullable|image|mimes:png,jpg,jpeg|max:2048'
        ]);

        $data = $request->only(['nama', 'nrp', 'jabatan', 'departemen']);

        // Upload baru jika ada file baru
        if ($request->hasFile('qr_code')) {
            // Hapus file lama jika ada
            if ($karyawan->qr_code && file_exists(public_path($karyawan->qr_code))) {
                unlink(public_path($karyawan->qr_code));
            }

            $file = $request->file('qr_code');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/qr_codes', $filename);
            $data['qr_code'] = 'qr_codes/' . $filename;

        }

        $karyawan->update($data);

        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil diperbarui.');
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
}
