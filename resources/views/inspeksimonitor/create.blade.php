@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Tambah Inspeksi Monitor / TV</h4>

    <form action="{{ route('inspeksimonitor.store') }}" method="POST">
        @csrf
        @include('inspeksimonitor.form', ['inspeksimonitor' => null])
        <div class="mt-3">
            <button class="btn btn-success">Simpan</button>
            <a href="{{ route('inspeksimonitor.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
