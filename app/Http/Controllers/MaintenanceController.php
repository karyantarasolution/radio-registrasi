<?php

namespace App\Http\Controllers;

use App\Models\GudangBarang;
use App\Models\Inventaris;
use App\Models\Maintenance;
use App\Models\MaintenanceHistory;
use App\Models\StokMutasi;
use App\Services\AdminNotificationService;
use App\Services\ApprovalPolicy;
use App\Services\PimpinanNotificationService;
use App\Notifications\MaintenanceStatusNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class MaintenanceController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Maintenance::with('gudangBarang', 'inventaris', 'createdBy', 'histories.user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('gudang_barang_id')) {
            $query->where('gudang_barang_id', $request->gudang_barang_id);
        }

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('nomor_maintenance', 'LIKE', "%{$q}%")
                    ->orWhere('jenis_kerusakan', 'LIKE', "%{$q}%")
                    ->orWhere('petugas', 'LIKE', "%{$q}%");
            });
        }

        if ($request->filled('tanggal_awal')) {
            $query->whereDate('tanggal_masuk', '>=', $request->tanggal_awal);
        }
        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('tanggal_masuk', '<=', $request->tanggal_akhir);
        }

        $maintenances = $query->orderBy('created_at', 'desc')->get();
        $gudangBarangs = GudangBarang::orderBy('nama_perangkat')->get();

        $stats = [
            'menunggu' => $maintenances->where('status', 'Menunggu')->count(),
            'diproses' => $maintenances->where('status', 'Diproses')->count(),
            'selesai' => $maintenances->where('status', 'Selesai')->count(),
            'dibatalkan' => $maintenances->where('status', 'Dibatalkan')->count(),
            'total' => $maintenances->count(),
        ];

        return view('maintenance.index', compact('maintenances', 'gudangBarangs', 'stats'));
    }

    public function create()
    {
        $user = Auth::user();
        $gudangBarangs = GudangBarang::orderBy('nama_perangkat')->get();
        $inventarisDipinjam = collect();

        if ($user->isKaryawan()) {
            $inventarisDipinjam = Inventaris::where('nrp', $user->nrp)
                ->where('status_peminjaman', 'Belum Dikembalikan')
                ->with('gudangBarang')
                ->get();
        } elseif ($user->isAdmin()) {
            $inventarisDipinjam = Inventaris::where('status_peminjaman', 'Belum Dikembalikan')
                ->with('gudangBarang')
                ->get();
        }

        return view('maintenance.form', compact('gudangBarangs', 'inventarisDipinjam', 'user'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'gudang_barang_id' => 'required|exists:gudang_barang,id',
            'inventaris_id' => 'nullable|exists:inventaris,id',
            'jenis_kerusakan' => 'required|string|max:255',
            'deskripsi_kerusakan' => 'nullable|string',
            'petugas' => 'nullable|string|max:255',
            'tanggal_masuk' => 'required|date',
        ]);

        if ($user->isPimpinan()) {
            abort(403, 'Pimpinan tidak dapat membuat maintenance.');
        }

        $barang = GudangBarang::findOrFail($request->gudang_barang_id);

        DB::transaction(function () use ($request, $barang, $user) {
            $nomor = 'MT-' . date('Ymd') . '-' . strtoupper(Str::random(4));

            $maintenance = Maintenance::create([
                'nomor_maintenance' => $nomor,
                'gudang_barang_id' => $barang->id,
                'inventaris_id' => $request->inventaris_id ?: null,
                'jenis_kerusakan' => $request->jenis_kerusakan,
                'deskripsi_kerusakan' => $request->deskripsi_kerusakan,
                'petugas' => $request->petugas,
                'status' => 'Menunggu',
                'tanggal_masuk' => $request->tanggal_masuk,
                'created_by' => $user->id,
            ]);

            if ($barang->stok_tersedia > 0) {
                $barang->decrement('stok_tersedia');
                StokMutasi::create([
                    'gudang_barang_id' => $barang->id,
                    'inventaris_id' => null,
                    'jenis' => 'Keluar',
                    'jumlah' => 1,
                    'keterangan' => "Masuk maintenance {$nomor}",
                ]);
            }

            MaintenanceHistory::create([
                'maintenance_id' => $maintenance->id,
                'status_dari' => null,
                'status_ke' => 'Menunggu',
                'keterangan' => 'Pengajuan maintenance dibuat.',
                'user_id' => $user->id,
            ]);

            ApprovalPolicy::logRiwayat(
                $barang,
                'Maintenance',
                sprintf(
                    '%s masuk maintenance (%s) - %s.',
                    $barang->nama_perangkat,
                    $nomor,
                    $request->jenis_kerusakan
                ),
                $user,
                ['maintenance_id' => $maintenance->id, 'inventaris_id' => $request->inventaris_id]
            );

            AdminNotificationService::notify(new MaintenanceStatusNotification($maintenance, 'baru'));
        });

        return redirect()->route('maintenance.index')->with('success', 'Maintenance berhasil dibuat. Menunggu diproses.');
    }

    public function show($id)
    {
        $maintenance = Maintenance::with('gudangBarang', 'inventaris', 'createdBy', 'histories.user')->findOrFail($id);

        $riwayatPerangkat = $maintenance->gudangBarang
            ? $maintenance->gudangBarang->riwayat()->with('user', 'maintenance', 'inventaris')->orderBy('tanggal', 'desc')->get()
            : collect();

        return view('maintenance.show', compact('maintenance', 'riwayatPerangkat'));
    }

    public function edit($id)
    {
        $user = Auth::user();
        if (!$user->isAdmin()) {
            abort(403);
        }

        $maintenance = Maintenance::with('gudangBarang')->findOrFail($id);
        $gudangBarangs = GudangBarang::orderBy('nama_perangkat')->get();

        return view('maintenance.form', compact('maintenance', 'gudangBarangs', 'user'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user->isAdmin()) {
            abort(403);
        }

        $request->validate([
            'gudang_barang_id' => 'required|exists:gudang_barang,id',
            'jenis_kerusakan' => 'required|string|max:255',
            'deskripsi_kerusakan' => 'nullable|string',
            'tanggal_masuk' => 'required|date',
        ]);

        $maintenance = Maintenance::findOrFail($id);
        $barangBaru = GudangBarang::findOrFail($request->gudang_barang_id);

        DB::transaction(function () use ($request, $maintenance, $barangBaru, $user) {
            if ($maintenance->gudang_barang_id !== $barangBaru->id) {
                $barangLama = $maintenance->gudangBarang;
                if ($barangLama && !$maintenance->inventaris_id) {
                    $barangLama->increment('stok_tersedia');
                }
                if ($barangBaru->stok_tersedia > 0) {
                    $barangBaru->decrement('stok_tersedia');
                }
            }

            $maintenance->update([
                'gudang_barang_id' => $barangBaru->id,
                'jenis_kerusakan' => $request->jenis_kerusakan,
                'deskripsi_kerusakan' => $request->deskripsi_kerusakan,
                'petugas' => $request->petugas,
                'tanggal_masuk' => $request->tanggal_masuk,
            ]);
        });

        return redirect()->route('maintenance.show', $maintenance->id)->with('success', 'Data maintenance diperbarui.');
    }

    public function proses(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user->isAdmin()) {
            abort(403);
        }

        $maintenance = Maintenance::findOrFail($id);
        if ($maintenance->status !== 'Menunggu') {
            return back()->with('error', 'Hanya maintenance berstatus Menunggu yang dapat diproses.');
        }

        $request->validate([
            'tindakan_perbaikan' => 'nullable|string',
            'petugas' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($maintenance, $request, $user) {
            $maintenance->update([
                'status' => 'Diproses',
                'tindakan_perbaikan' => $request->tindakan_perbaikan ?: $maintenance->tindakan_perbaikan,
                'petugas' => $request->petugas ?: $maintenance->petugas,
            ]);

            MaintenanceHistory::create([
                'maintenance_id' => $maintenance->id,
                'status_dari' => 'Menunggu',
                'status_ke' => 'Diproses',
                'keterangan' => $request->tindakan_perbaikan,
                'user_id' => $user->id,
            ]);

            AdminNotificationService::notify(new MaintenanceStatusNotification($maintenance, 'diproses'));
        });

        return redirect()->route('maintenance.show', $maintenance->id)->with('success', 'Maintenance ditandai sedang diproses.');
    }

    public function selesai(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user->isAdmin()) {
            abort(403);
        }

        $maintenance = Maintenance::with('gudangBarang')->findOrFail($id);
        if (!in_array($maintenance->status, ['Menunggu', 'Diproses'])) {
            return back()->with('error', 'Hanya maintenance aktif yang dapat diselesaikan.');
        }

        $request->validate([
            'tindakan_perbaikan' => 'nullable|string',
            'biaya' => 'nullable|numeric|min:0',
            'catatan' => 'nullable|string',
        ]);

        DB::transaction(function () use ($maintenance, $request, $user) {
            $maintenance->update([
                'status' => 'Selesai',
                'tanggal_selesai' => now()->toDateString(),
                'tindakan_perbaikan' => $request->tindakan_perbaikan ?: $maintenance->tindakan_perbaikan,
                'biaya' => $request->biaya ?: $maintenance->biaya,
                'catatan' => $request->catatan ?: $maintenance->catatan,
            ]);

            if (!$maintenance->inventaris_id && $maintenance->gudangBarang) {
                $maintenance->gudangBarang->increment('stok_tersedia');
                StokMutasi::create([
                    'gudang_barang_id' => $maintenance->gudangBarang->id,
                    'inventaris_id' => null,
                    'jenis' => 'Masuk',
                    'jumlah' => 1,
                    'keterangan' => "Maintenance selesai {$maintenance->nomor_maintenance}",
                ]);
            }

            if ($maintenance->gudangBarang) {
                $maintenance->gudangBarang->update(['kondisi' => 'Baik']);
            }

            MaintenanceHistory::create([
                'maintenance_id' => $maintenance->id,
                'status_dari' => $maintenance->histories()->latest()->value('status_ke') ?? $maintenance->status,
                'status_ke' => 'Selesai',
                'keterangan' => $request->tindakan_perbaikan ?: 'Perbaikan selesai.',
                'user_id' => $user->id,
            ]);

            ApprovalPolicy::logRiwayat(
                $maintenance->gudangBarang,
                'Perbaikan',
                sprintf(
                    'Perbaikan selesai (%s) - %s%s.',
                    $maintenance->nomor_maintenance,
                    $request->tindakan_perbaikan ?: 'tindakan tercatat',
                    $request->biaya ? " Biaya: Rp " . number_format($request->biaya, 0, ',', '.') : ''
                ),
                $user,
                ['maintenance_id' => $maintenance->id]
            );

            AdminNotificationService::notify(new MaintenanceStatusNotification($maintenance, 'selesai'));
            if ($maintenance->createdBy) {
                $maintenance->createdBy->notify(new MaintenanceStatusNotification($maintenance, 'selesai'));
            }
        });

        return redirect()->route('maintenance.show', $maintenance->id)->with('success', 'Maintenance selesai. Stok barang telah dikembalikan.');
    }

    public function batalkan(Request $request, $id)
    {
        $user = Auth::user();
        if (!$user->isAdmin()) {
            abort(403);
        }

        $maintenance = Maintenance::with('gudangBarang')->findOrFail($id);
        if (in_array($maintenance->status, ['Selesai', 'Dibatalkan'])) {
            return back()->with('error', 'Maintenance sudah tidak aktif.');
        }

        DB::transaction(function () use ($maintenance, $request, $user) {
            $statusLama = $maintenance->status;

            $maintenance->update([
                'status' => 'Dibatalkan',
                'catatan' => $request->catatan ?: $maintenance->catatan,
            ]);

            if (!$maintenance->inventaris_id && $maintenance->gudangBarang) {
                $maintenance->gudangBarang->increment('stok_tersedia');
            }

            MaintenanceHistory::create([
                'maintenance_id' => $maintenance->id,
                'status_dari' => $statusLama,
                'status_ke' => 'Dibatalkan',
                'keterangan' => $request->catatan ?: 'Maintenance dibatalkan.',
                'user_id' => $user->id,
            ]);

            ApprovalPolicy::logRiwayat(
                $maintenance->gudangBarang,
                'Maintenance',
                "Maintenance {$maintenance->nomor_maintenance} dibatalkan.",
                $user,
                ['maintenance_id' => $maintenance->id]
            );
        });

        return redirect()->route('maintenance.show', $maintenance->id)->with('success', 'Maintenance dibatalkan.');
    }

    public function destroy($id)
    {
        $user = Auth::user();
        if (!$user->isAdmin()) {
            abort(403);
        }

        Maintenance::findOrFail($id)->delete();
        return redirect()->route('maintenance.index')->with('success', 'Data maintenance dihapus.');
    }

    public function report(Request $request)
    {
        $user = Auth::user();
        if (!$user->isAdmin() && !$user->isPimpinan()) {
            abort(403);
        }

        $query = Maintenance::with('gudangBarang', 'createdBy');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('tanggal_awal')) {
            $query->whereDate('tanggal_masuk', '>=', $request->tanggal_awal);
        }
        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('tanggal_masuk', '<=', $request->tanggal_akhir);
        }

        $data = $query->orderBy('created_at', 'desc')->get();

        $pdf = Pdf::loadView('maintenance.report', compact('data'))->setPaper('a4', 'landscape');
        return $pdf->stream('Laporan-Maintenance.pdf');
    }
}