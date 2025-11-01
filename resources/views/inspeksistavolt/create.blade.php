@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Tambah Inspeksi Stavolt</h4>
    <form action="{{ route('inspeksistavolt.store') }}" method="POST">
        @csrf
        @include('inspeksistavolt.form', ['inspeksistavolt'=> null])
        <button class="btn btn-success">Simpan</button>
        <a href="{{ route('inspeksistavolt.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
