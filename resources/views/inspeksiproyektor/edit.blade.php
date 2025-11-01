@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Edit Inspeksi Proyektor</h4>

    <form action="{{ route('inspeksiproyektor.update', $inspeksiproyektor->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('inspeksiproyektor.form', ['inspeksiproyektor' => $inspeksiproyektor])
        <div class="mt-3">
            <button class="btn btn-primary">Update</button>
            <a href="{{ route('inspeksiproyektor.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
