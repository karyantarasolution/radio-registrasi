@extends('layouts.app')

@section('content')
<div class="container">

    {{-- Header Section --}}
    <div class="card border-0 shadow-sm mb-4 rounded-3">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold text-danger mb-1">Tambah Inspeksi Proyektor</h4>
                <small class="text-muted">Form input data inspeksi perangkat proyektor</small>
            </div>
            <a href="{{ route('inspeksiproyektor.index') }}" class="btn btn-secondary fw-bold">
                Kembali
            </a>
        </div>
    </div>

    {{-- Card Form --}}
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body">

            <form action="{{ route('inspeksiproyektor.store') }}" method="POST">
                @csrf

                @include('inspeksiproyektor.form', ['inspeksiproyektor' => null])

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-success fw-bold me-2">
                        Simpan
                    </button>
                    <a href="{{ route('inspeksiproyektor.index') }}" class="btn btn-outline-secondary fw-bold">
                        Batal
                    </a>
                </div>
            </form>

        </div>
    </div>

</div>
@endsection
