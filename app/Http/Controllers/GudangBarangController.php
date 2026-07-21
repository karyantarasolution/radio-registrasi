<?php

namespace App\Http\Controllers;

use App\Models\GudangBarang;
use App\Models\StokMutasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class GudangBarangController extends Controller
{
    private function isAdmin(): bool
    {
        return Auth::user()->isAdmin();
    }

    private function reportPdf(string $view, array $data, string $filename)
    {
        $pdf = Pdf::loadView($view, $data)->setPaper('A4', 'portrait');

        $pdf->getDomPDF()->getCanvas()->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) {
            $text = sprintf('Rev.%02d', $pageNumber);
            $font = $fontMetrics->get_font('Helvetica', 'normal');
            $size = 9;
            $x = $canvas->get_width() - 60;
            $y = $canvas->get_height() - 25;
            $canvas->text($x, $y, $text, $font, $size);
        });

        return $pdf->stream($filename);
    }

    public function index()
    {
        $barang = GudangBarang::orderBy('nama_perangkat')->get();

        $stats = [
            'total_jenis' => $barang->count(),
            'stok_tersedia' => $barang->sum('stok_tersedia'),
            'maintenance' => $barang->where('kondisi', 'Perlu Maintenance')->count(),
        ];

        return view('gudang.index', compact('barang', 'stats'));
    }

    public function create()
    {
        if (!$this->isAdmin()) {
            abort(403);
        }

        return view('gudang.form');
    }

    public function store(Request $request)
    {
        if (!$this->isAdmin()) {
            abort(403);
        }

        $request->validate([
            'nama_perangkat' => 'required|string|max:255',
            'merk' => 'nullable|string|max:100',
            'kategori' => 'required|string|max:100',
            'stok_total' => 'required|integer|min:1',
            'kondisi' => 'required|in:Baik,Perlu Maintenance,Rusak',
            'tanggal_masuk' => 'required|date',
            'keterangan' => 'nullable|string',
            'jumlah_maintenance' => 'nullable|integer|min:1',
        ]);

        $stokTotal = (int) $request->stok_total;
        $stokTersedia = $stokTotal;

        if (in_array($request->kondisi, ['Perlu Maintenance', 'Rusak'])) {
            $jumlah = (int) ($request->jumlah_maintenance ?? 0);
            if ($jumlah > $stokTotal) {
                $jumlah = $stokTotal;
            }
            $stokTersedia = $stokTotal - $jumlah;
        }

        $barang = GudangBarang::create([
            'nama_perangkat' => $request->nama_perangkat,
            'merk' => $request->merk,
            'kategori' => $request->kategori,
            'stok_total' => $stokTotal,
            'stok_tersedia' => $stokTersedia,
            'kondisi' => 'Baik',
            'tanggal_masuk' => $request->tanggal_masuk,
            'keterangan' => $request->keterangan,
        ]);

        StokMutasi::create([
            'gudang_barang_id' => $barang->id,
            'jenis' => 'Masuk',
            'jumlah' => $stokTotal,
            'keterangan' => 'Barang baru masuk gudang',
        ]);

        if ($stokTersedia < $stokTotal) {
            StokMutasi::create([
                'gudang_barang_id' => $barang->id,
                'jenis' => 'Keluar',
                'jumlah' => $stokTotal - $stokTersedia,
                'keterangan' => 'Dikirim ke maintenance',
            ]);
        }

        return redirect()->route('gudang-barang.index')->with('success', 'Barang gudang berhasil ditambahkan.');
    }

    public function edit(GudangBarang $gudang_barang)
    {
        if (!$this->isAdmin()) {
            abort(403);
        }

        return view('gudang.form', ['barang' => $gudang_barang]);
    }

    public function update(Request $request, GudangBarang $gudang_barang)
    {
        if (!$this->isAdmin()) {
            abort(403);
        }

        $request->validate([
            'nama_perangkat' => 'required|string|max:255',
            'merk' => 'nullable|string|max:100',
            'kategori' => 'required|string|max:100',
            'stok_total' => 'required|integer|min:0',
            'kondisi' => 'required|in:Baik,Perlu Maintenance,Rusak',
            'tanggal_masuk' => 'required|date',
            'keterangan' => 'nullable|string',
            'jumlah_maintenance' => 'nullable|integer|min:0',
        ]);

        $stokTotal = (int) $request->stok_total;
        $stokTersedia = $stokTotal;

        if (in_array($request->kondisi, ['Perlu Maintenance', 'Rusak'])) {
            $jumlah = (int) ($request->jumlah_maintenance ?? 0);
            if ($jumlah > $stokTotal) {
                $jumlah = $stokTotal;
            }
            $stokTersedia = $stokTotal - $jumlah;
        }

        $gudang_barang->update([
            'nama_perangkat' => $request->nama_perangkat,
            'merk' => $request->merk,
            'kategori' => $request->kategori,
            'stok_total' => $stokTotal,
            'stok_tersedia' => $stokTersedia,
            'kondisi' => 'Baik',
            'tanggal_masuk' => $request->tanggal_masuk,
            'keterangan' => $request->keterangan,
        ]);

        if ($stokTersedia < $stokTotal) {
            $existingMutasi = StokMutasi::where('gudang_barang_id', $gudang_barang->id)
                ->where('keterangan', 'Dikirim ke maintenance')
                ->where('created_at', '>=', now()->subHour())
                ->first();

            if (!$existingMutasi) {
                StokMutasi::create([
                    'gudang_barang_id' => $gudang_barang->id,
                    'jenis' => 'Keluar',
                    'jumlah' => $stokTotal - $stokTersedia,
                    'keterangan' => 'Dikirim ke maintenance',
                ]);
            }
        }

        return redirect()->route('gudang-barang.index')->with('success', 'Data gudang berhasil diperbarui.');
    }

    public function destroy(GudangBarang $gudang_barang)
    {
        if (!$this->isAdmin()) {
            abort(403);
        }

        $gudang_barang->delete();

        return redirect()->route('gudang-barang.index')->with('success', 'Barang gudang berhasil dihapus.');
    }

    public function laporan()
    {
        if (!$this->isAdmin()) {
            abort(403);
        }

        return view('gudang.laporan');
    }

    public function previewMaintenance()
    {
        if (!$this->isAdmin()) {
            abort(403);
        }

        $items = GudangBarang::where('kondisi', 'Perlu Maintenance')
            ->orderBy('nama_perangkat')
            ->get();

        return view('gudang.preview_maintenance', compact('items'));
    }

    public function previewBaru()
    {
        if (!$this->isAdmin()) {
            abort(403);
        }

        $items = GudangBarang::where('tanggal_masuk', '>=', now()->subDays(30))
            ->orderBy('tanggal_masuk', 'desc')
            ->get();

        return view('gudang.preview_baru', compact('items'));
    }

    public function previewMutasi()
    {
        if (!$this->isAdmin()) {
            abort(403);
        }

        $items = StokMutasi::with('gudangBarang')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('gudang.preview_mutasi', compact('items'));
    }

    public function reportMaintenance()
    {
        if (!$this->isAdmin()) {
            abort(403);
        }

        $items = GudangBarang::where('kondisi', 'Perlu Maintenance')
            ->orderBy('nama_perangkat')
            ->get();

        return $this->reportPdf('gudang.report_maintenance', compact('items'), 'laporan-maintenance-gudang-it.pdf');
    }

    public function reportBaru()
    {
        if (!$this->isAdmin()) {
            abort(403);
        }

        $items = GudangBarang::where('tanggal_masuk', '>=', now()->subDays(30))
            ->orderBy('tanggal_masuk', 'desc')
            ->get();

        return $this->reportPdf('gudang.report_baru', compact('items'), 'laporan-barang-baru-gudang-it.pdf');
    }

    public function reportMutasi()
    {
        if (!$this->isAdmin()) {
            abort(403);
        }

        $items = StokMutasi::with('gudangBarang')
            ->orderBy('created_at', 'desc')
            ->get();

        return $this->reportPdf('gudang.report_mutasi', compact('items'), 'laporan-mutasi-gudang-it.pdf');
    }
}
