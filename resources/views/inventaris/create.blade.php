@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="fw-bold mb-3">Tambah Data Inventaris</h3>

    <form action="{{ route('inventaris.store') }}" method="POST">
        @csrf
        @include('inventaris.form')
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('inventaris.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
