@extends('layouts.app')

@section('content')
<style>
    .page-container {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
        padding: 20px 0;
    }
    .page-header {
        background: linear-gradient(135deg, #ea6666 0%, #f71414 100%);
        color: white;
        padding: 30px;
        border-radius: 20px;
        margin-bottom: 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }
    .notif-card {
        background: #fff;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    .notif-item {
        border-left: 4px solid transparent;
        transition: background .2s;
    }
    .notif-item.unread {
        border-left-color: #ea6666;
        background: #fff8f8;
    }
    .notif-item:hover { background: #f8f9fa; }
    .badge-new {
        background: #ea6666;
        color: #fff;
        font-size: 0.7rem;
        padding: 2px 8px;
        border-radius: 10px;
    }
    .warning-card {
        background: #fff;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    .warning-item {
        border-left: 4px solid #ffc107;
        transition: background .2s;
        padding: 14px 20px;
    }
    .warning-item.overdue {
        border-left-color: #dc3545;
        background: #fff5f5;
    }
    .warning-item.h1 {
        border-left-color: #ffc107;
        background: #fffde7;
    }
</style>

<div class="page-container">
    <div class="container-fluid">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h2 class="fw-bold mb-1">
                    @if(Auth::user()->isKaryawan())
                        <i class="fas fa-bell me-2"></i>Notifikasi Pengembalian
                    @else
                        <i class="fas fa-bell me-2"></i>Notifikasi
                    @endif
                </h2>
                <p class="mb-0">
                    @if(Auth::user()->isPimpinan())
                        Pengajuan peminjaman dan informasi terbaru
                    @elseif(Auth::user()->isKaryawan())
                        Info status peminjaman dan deadline pengembalian
                    @else
                        Pengajuan inventaris dan kunjungan buku tamu
                    @endif
                </p>
            </div>
            <div class="d-flex gap-2">
                @if(auth()->user()->unreadNotifications->count() > 0)
                    <form action="{{ route('notifications.read-all') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-light btn-sm fw-bold">Tandai semua dibaca</button>
                    </form>
                @endif
                <a href="{{ url()->previous() }}" class="btn btn-light btn-sm fw-bold">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>

        @if(Auth::user()->isKaryawan())
            @php
                $karyawanNrp = Auth::user()->nrp;
                $overdueItems = \App\Models\Inventaris::where('nrp', $karyawanNrp)
                    ->where('status_peminjaman', 'Belum Dikembalikan')
                    ->whereNotNull('tanggal_pengembalian')
                    ->where('tanggal_pengembalian', '<', now()->toDateString())
                    ->get();
                $h1Items = \App\Models\Inventaris::where('nrp', $karyawanNrp)
                    ->where('status_peminjaman', 'Belum Dikembalikan')
                    ->whereNotNull('tanggal_pengembalian')
                    ->where('tanggal_pengembalian', now()->addDay()->toDateString())
                    ->get();
                $pendingReturn = \App\Models\Inventaris::where('nrp', $karyawanNrp)
                    ->where('status_peminjaman', 'Pending Pengembalian')
                    ->get();
                $activeBorrow = \App\Models\Inventaris::where('nrp', $karyawanNrp)
                    ->where('status_peminjaman', 'Belum Dikembalikan')
                    ->get();
            @endphp

            @if($overdueItems->count() > 0 || $h1Items->count() > 0)
                <div class="warning-card mb-4">
                    <div class="p-3" style="background: linear-gradient(135deg, #ffc107, #ff9800); color:#fff;">
                        <h5 class="mb-0 fw-bold"><i class="fas fa-exclamation-triangle me-2"></i>Peringatan Pengembalian</h5>
                    </div>
                    <div class="list-group list-group-flush">
                        @foreach($overdueItems as $item)
                            <div class="warning-item overdue">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong class="text-danger"><i class="fas fa-times-circle me-1"></i>Terlambat!</strong>
                                        <div class="mt-1">{{ $item->nama_perangkat }} ({{ $item->no_asset }})</div>
                                        <small class="text-muted">Deadline: {{ \Carbon\Carbon::parse($item->tanggal_pengembalian)->format('d/m/Y') }} &middot; Terlambat {{ now()->diffInDays(\Carbon\Carbon::parse($item->tanggal_pengembalian)) }} hari</small>
                                    </div>
                                    <span class="badge bg-danger rounded-pill">Terlambat</span>
                                </div>
                            </div>
                        @endforeach
                        @foreach($h1Items as $item)
                            <div class="warning-item h1">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong class="text-warning"><i class="fas fa-clock me-1"></i>H-1 Besok Deadline</strong>
                                        <div class="mt-1">{{ $item->nama_perangkat }} ({{ $item->no_asset }})</div>
                                        <small class="text-muted">Deadline: {{ \Carbon\Carbon::parse($item->tanggal_pengembalian)->format('d/m/Y') }}</small>
                                    </div>
                                    <span class="badge bg-warning text-dark rounded-pill">Besok</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($activeBorrow->count() > 0)
                <div class="warning-card mb-4">
                    <div class="p-3" style="background: linear-gradient(135deg, #667eea, #764ba2); color:#fff;">
                        <h5 class="mb-0 fw-bold"><i class="fas fa-box me-2"></i>Status Peminjaman Aktif</h5>
                    </div>
                    <div class="list-group list-group-flush">
                        @foreach($activeBorrow as $item)
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $item->nama_perangkat }}</strong>
                                        <div class="mt-1">
                                            <small class="text-muted">Pinjam: {{ \Carbon\Carbon::parse($item->tanggal_peminjaman)->format('d/m/Y') }} &middot; Est. Kembali: {{ $item->tanggal_pengembalian ? \Carbon\Carbon::parse($item->tanggal_pengembalian)->format('d/m/Y') : '-' }}</small>
                                        </div>
                                    </div>
                                    @php
                                        $statusColor = match($item->status_peminjaman) {
                                            'Pending' => 'warning',
                                            'Belum Dikembalikan' => 'danger',
                                            'Pending Pengembalian' => 'info',
                                            'Dikembalikan' => 'success',
                                            default => 'secondary',
                                        };
                                    @endphp
                                    <span class="badge bg-{{ $statusColor }} rounded-pill">{{ $item->status_peminjaman }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($pendingReturn->count() > 0)
                <div class="warning-card mb-4">
                    <div class="p-3" style="background: linear-gradient(135deg, #17a2b8, #20c997); color:#fff;">
                        <h5 class="mb-0 fw-bold"><i class="fas fa-clock me-2"></i>Menunggu Verifikasi Pengembalian</h5>
                    </div>
                    <div class="list-group list-group-flush">
                        @foreach($pendingReturn as $item)
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $item->nama_perangkat }}</strong>
                                        <div class="mt-1">
                                            <small class="text-muted">Dokumentasi pengembalian sudah dikirim, menunggu persetujuan admin ICT</small>
                                        </div>
                                    </div>
                                    <span class="badge bg-info rounded-pill">Pending</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endif

        <div class="notif-card">
            <div class="p-3" style="border-bottom: 1px solid #f0f0f0;">
                <h6 class="fw-bold mb-0"><i class="fas fa-list me-2"></i>Riwayat Notifikasi</h6>
            </div>
            <div class="list-group list-group-flush">
                @forelse($notifications as $notification)
                    @php $data = $notification->data; @endphp
                    <a href="{{ route('notifications.read', $notification->id) }}"
                       class="list-group-item list-group-item-action notif-item {{ $notification->read_at ? '' : 'unread' }}">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <strong>{{ $data['title'] ?? 'Notifikasi' }}</strong>
                                @if(!$notification->read_at)
                                    <span class="badge-new ms-1">Baru</span>
                                @endif
                                <p class="mb-1 mt-1 text-muted">{{ $data['message'] ?? '' }}</p>
                            </div>
                            <small class="text-muted text-nowrap ms-2">{{ $notification->created_at->diffForHumans() }}</small>
                        </div>
                    </a>
                @empty
                    <div class="list-group-item text-center text-muted py-5">
                        <div style="font-size:2.5rem; margin-bottom:8px;">📭</div>
                        Belum ada notifikasi.
                    </div>
                @endforelse
            </div>
            @if($notifications->hasPages())
                <div class="card-footer">{{ $notifications->links() }}</div>
            @endif
        </div>
    </div>
</div>
@endsection
