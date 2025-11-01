@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Edit Inspeksi Monitor / TV</h4>

    <form action="{{ route('inspeksimonitor.update', $inspeksimonitor->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('inspeksimonitor.form', ['inspeksimonitor' => $inspeksimonitor])
        <div class="mt-3">
            <button class="btn btn-primary">Update</button>
            <a href="{{ route('inspeksimonitor.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
