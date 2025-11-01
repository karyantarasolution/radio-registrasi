@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="fw-bold mb-3">Edit Data Inventaris</h3>

    <form action="{{ route('inventaris.update', $inventaris->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('inventaris.form')
        <button type="submit" class="btn btn-warning">Update</button>
        <a href="{{ route('inventaris.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
