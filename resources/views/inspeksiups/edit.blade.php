@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Edit Inspeksi UPS</h4>
   <form action="{{ route('inspeksiups.update', $inspeksiup->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('inspeksiups.form', ['inspeksiup' => $inspeksiup])
        <button class="btn btn-primary">Update</button>
        <a href="{{ route('inspeksiups.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
