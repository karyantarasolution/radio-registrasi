@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-3">Edit Buku Tamu</h4>

    <form action="{{ route('bukutamu.update', $bukutamu->no) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- panggil partial form agar bisa dipakai ulang di create & edit --}}
        @include('bukutamu.form', ['bukutamu' => $bukutamu])

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('bukutamu.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
