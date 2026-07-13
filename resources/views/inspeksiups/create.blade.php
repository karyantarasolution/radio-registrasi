@extends('layouts.app')

@section('content')
<div class="container">

    {{-- Header Section --}}
    <div class="card border-0 shadow-sm mb-4 rounded-3">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold text-danger mb-1">Tambah Inspeksi UPS</h4>
                <small class="text-muted">Form input data inspeksi perangkat UPS</small>
            </div>
            <a href="{{ route('inspeksiups.index') }}" class="btn btn-secondary fw-bold">
                Kembali
            </a>
        </div>
    </div>

    {{-- Card Form --}}
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body">

            <form action="{{ route('inspeksiups.store') }}" method="POST">
                @csrf

                @include('inspeksiups.form', ['inspeksiups' => null])

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-success fw-bold me-2">
                        Simpan
                    </button>
                    <a href="{{ route('inspeksiups.index') }}" class="btn btn-outline-secondary fw-bold me-2">
                        Batal
                    </a>
                </div>
            </form>

        </div>
    </div>

</div>
@endsection
