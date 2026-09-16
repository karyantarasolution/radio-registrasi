<?php

namespace App\Console\Commands;

use App\Services\PengingatService;
use Illuminate\Console\Command;

class KirimPengingatPeminjaman extends Command
{
    protected $signature = 'reminders:peminjaman';

    protected $description = 'Kirim pengingat peminjaman mendekati/melewati batas waktu';

    public function handle(): int
    {
        $count = PengingatService::kirimPengingat();

        $this->info("{$count} pengingat peminjaman berhasil dikirim.");

        return Command::SUCCESS;
    }
}