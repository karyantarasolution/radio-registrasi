@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Tambah Inspeksi UPS</h4>
    <form action="{{ route('inspeksiups.store') }}" method="POST">
        @csrf
        @include('inspeksiups.form', ['inspeksi_up'=> null])
        <button class="btn btn-success">Simpan</button>
        <a href="{{ route('inspeksiups.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>


@endsection
