<div class="mb-3">
    <label class="form-label">Nama</label>
    <input type="text" name="nama" class="form-control" value="{{ old('nama', $inventaris->nama ?? '') }}" required>
</div>

<div class="mb-3">
    <label class="form-label">NRP</label>
    <input type="text" name="nrp" class="form-control" value="{{ old('nrp', $inventaris->nrp ?? '') }}" required>
</div>

<div class="mb-3">
    <label class="form-label">Nama Perangkat</label>
    <input type="text" name="nama_perangkat" class="form-control" value="{{ old('nama_perangkat', $inventaris->nama_perangkat ?? '') }}" required>
</div>

<div class="mb-3">
    <label class="form-label">No Asset</label>
    <input type="text" name="no_asset" class="form-control" value="{{ old('no_asset', $inventaris->no_asset ?? '') }}">
</div>

<div class="mb-3">
    <label class="form-label">Status Peminjaman</label>
    <select name="status_peminjaman" class="form-select" required>
        <option value="Belum Dikembalikan" {{ old('status_peminjaman', $inventaris->status_peminjaman ?? '') == 'Belum Dikembalikan' ? 'selected' : '' }}>Belum Dikembalikan</option>
        <option value="Dikembalikan" {{ old('status_peminjaman', $inventaris->status_peminjaman ?? '') == 'Dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
    </select>
</div>

<div class="mb-3">
    <label class="form-label">Tanggal Peminjaman</label>
    <input type="date" name="tanggal_peminjaman" class="form-control" value="{{ old('tanggal_peminjaman', $inventaris->tanggal_peminjaman ?? '') }}" required>
</div>
