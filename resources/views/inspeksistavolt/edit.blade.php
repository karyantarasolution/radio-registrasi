@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Edit Inspeksi Stavolt</h4>
    <form action="{{ route('inspeksistavolt.update', $inspeksistavolt) }}" method="POST">
        @csrf
        @method('PUT')
        @include('inspeksistavolt.form', ['inspeksistavolt' => $inspeksistavolt])
        <button class="btn btn-primary">Update</button>
        <a href="{{ route('inspeksistavolt.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
