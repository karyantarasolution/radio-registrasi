<?php

namespace App\Services;

use App\Models\GudangBarang;
use App\Models\Inventaris;
use App\Models\User;

class ApprovalPolicy
{
    public static function requiresPimpinan(GudangBarang $barang, int $lamaPinjam): bool
    {
        $categories = config('approval.wajib_persetujuan_pimpinan_kategori', []);
        $maxDays = config('approval.wajib_persetujuan_pimpinan_lama_pinjam_hari', 30);

        if (in_array($barang->kategori, $categories)) {
            return true;
        }

        if ($lamaPinjam > $maxDays) {
            return true;
        }

        return false;
    }

    public static function canAdminApproveFinal(Inventaris $inventaris): bool
    {
        return !$inventaris->butuh_persetujuan_pimpinan;
    }

    public static function logApproval($model, string $tahap, string $status, ?string $catatan, ?User $user, bool $isUrgent = false): void
    {
        $model->approvals()->create([
            'tahap' => $tahap,
            'status' => $status,
            'catatan' => $catatan,
            'user_id' => $user?->id,
            'is_urgent' => $isUrgent,
        ]);
    }

    public static function logRiwayat($aset, string $jenis, string $deskripsi, ?User $user, array $extra = []): void
    {
        if (!$aset) {
            return;
        }

        $aset->riwayat()->create(array_merge([
            'jenis' => $jenis,
            'deskripsi' => $deskripsi,
            'user_id' => $user?->id,
            'tanggal' => now(),
        ], $extra));
    }
}