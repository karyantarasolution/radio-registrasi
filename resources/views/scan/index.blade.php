@extends('layouts.app')

@section('content')
<style>
    .page-container {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
        padding: 20px 0;
    }
    .scan-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        max-width: 640px;
        margin: 40px auto;
        padding: 40px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    .scan-card .qr-icon {
        width: 90px;
        height: 90px;
        border-radius: 22px;
        background: linear-gradient(135deg, #ea6666 0%, #f71414 100%);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.6rem;
        margin: 0 auto 20px;
        box-shadow: 0 8px 20px rgba(247,20,20,0.35);
    }
    .btn-scan {
        border: none;
        padding: 12px 30px;
        border-radius: 12px;
        font-weight: 700;
        color: #fff;
        background: linear-gradient(135deg, #ea6666 0%, #f71414 100%);
    }
    .btn-scan:hover { opacity: .9; color: #fff; }
</style>

<div class="page-container">
    <div class="container-fluid">
        @if(session('error'))
            <div class="alert alert-danger" style="max-width:640px;margin:0 auto 15px;">{{ session('error') }}</div>
        @endif

        <div class="scan-card">
            <div class="qr-icon"><i class="fas fa-qrcode"></i></div>
            <h4 class="fw-bold mb-1">Scan / Cari Aset</h4>
            <p class="text-muted mb-4">Masukkan kode QR aset, ID PTT, nomor lambung, serial, atau nama perangkat.</p>

            <form method="GET" action="{{ route('scan.search') }}">
                <div class="input-group input-group-lg mb-3">
                    <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" name="q" class="form-control form-control-lg border-start-0" placeholder="cth: GB-00001 / RD-0001 / HT-23 / ..." value="{{ request('q') }}" autofocus>
                </div>
                <button class="btn btn-scan btn-lg w-100" type="submit"><i class="fas fa-search me-1"></i> Cari Aset</button>
            </form>

            <small class="text-muted d-block mt-3">
                Kode QR tertera pada label yang ditempel di perangkat atau kendaraan.
            </small>
        </div>
    </div>
</div>
@endsection