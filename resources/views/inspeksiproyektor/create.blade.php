@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Tambah Inspeksi Proyektor</h4>

    <form action="{{ route('inspeksiproyektor.store') }}" method="POST">
        @csrf
        @include('inspeksiproyektor.form', ['inspeksiproyektor' => null])
        <div class="mt-3">
            <button class="btn btn-success">Simpan</button>
            <a href="{{ route('inspeksiproyektor.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
