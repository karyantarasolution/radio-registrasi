@extends('layouts.app')

@section('content')
<div class="container">

    {{-- Header Section --}}
    <div class="card border-0 shadow-sm mb-4 rounded-3">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold text-danger mb-1">Edit Inspeksi Monitor / TV</h4>
                <small class="text-muted">Form edit data inspeksi perangkat Monitor / TV</small>
            </div>
            <a href="{{ route('inspeksimonitor.index') }}" class="btn btn-secondary fw-bold">
                Kembali
            </a>
        </div>
    </div>

    {{-- Card Form --}}
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body">

            <form action="{{ route('inspeksimonitor.update', $inspeksimonitor) }}" method="POST">
                @csrf
                @method('PUT')

                @include('inspeksimonitor.form', ['inspeksimonitor' => $inspeksimonitor])

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-success fw-bold me-2">
                        Perbaharui
                    </button>
                    <a href="{{ route('inspeksimonitor.index') }}" class="btn btn-outline-secondary fw-bold">
                        Batal
                    </a>
                </div>
            </form>

        </div>
    </div>

</div>
@endsection
