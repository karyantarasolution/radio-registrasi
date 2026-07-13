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
</style>

<div class="page-container">
    <div class="container-fluid">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h2 class="fw-bold mb-1">Notifikasi Admin</h2>
                <p class="mb-0">Pengajuan inventaris dan kunjungan buku tamu</p>
            </div>
            @if(auth()->user()->unreadNotifications->count() > 0)
                <form action="{{ route('notifications.read-all') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-light btn-sm fw-bold">Tandai semua dibaca</button>
                </form>
            @endif
        </div>

        <div class="notif-card">
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
