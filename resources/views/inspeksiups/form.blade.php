{{-- resources/views/inspeksiups/form.blade.php --}}

<div class="card shadow-sm border-0 rounded-4">
    <div class="card-body p-4">

        {{-- DATA UMUM --}}
        <h5 class="mb-4 fw-bold text-danger">Form Inspeksi UPS</h5>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Nomor Aset UPS</label>
                <input type="text" name="nomor_aset" class="form-control form-control-sm rounded-3 shadow-sm"
                    value="{{ old('nomor_aset', $inspeksiups->nomor_aset ?? '') }}">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Merek</label>
                <input type="text" name="merek" class="form-control form-control-sm rounded-3 shadow-sm"
                    value="{{ old('merek', $inspeksiups->merek ?? '') }}">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Type</label>
                <input type="text" name="type" class="form-control form-control-sm rounded-3 shadow-sm"
                    value="{{ old('type', $inspeksiups->type ?? '') }}">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">S/N</label>
                <input type="text" name="sn" class="form-control form-control-sm rounded-3 shadow-sm"
                    value="{{ old('sn', $inspeksiups->sn ?? '') }}">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Departemen</label>
                <input type="text" name="departemen" class="form-control form-control-sm rounded-3 shadow-sm"
                    value="{{ old('departemen', $inspeksiups->departemen ?? '') }}">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Lokasi</label>
                <input type="text" name="lokasi" class="form-control form-control-sm rounded-3 shadow-sm"
                    value="{{ old('lokasi', $inspeksiups->lokasi ?? '') }}">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Tanggal Inspeksi</label>
                <input type="date" name="tanggal_inspeksi" class="form-control form-control-sm rounded-3 shadow-sm"
                    value="{{ old('tanggal_inspeksi', isset($inspeksiups->tanggal_inspeksi) ? $inspeksiups->tanggal_inspeksi->format('Y-m-d') : '') }}">
            </div>

            <div class="col-md-12 mb-3">
                <label class="form-label fw-semibold">Keterangan Umum</label>
                <textarea name="keterangan" class="form-control form-control-sm rounded-3 shadow-sm" rows="3">{{ old('keterangan', $inspeksiups->keterangan ?? '') }}</textarea>
            </div>
        </div>

        @php
        $items = [
            ['key'=>'casing','label'=>'Kondisi casing UPS'],
            ['key'=>'kebersihan','label'=>'Kebersihan UPS'],
            ['key'=>'kabel_adaptor','label'=>'Kondisi kabel adaptor'],
            ['key'=>'tombol_switch','label'=>'Kondisi tombol dan switch'],
            ['key'=>'indikator_status','label'=>'Indikator status (power, battery, load)'],
            ['key'=>'fungsi_alarm','label'=>'Fungsi alarm'],
            ['key'=>'respon_kehilangan_daya','label'=>'Respon terhadap kehilangan daya'],
            ['key'=>'fuse','label'=>'Fuse (sekering)'],
        ];
        @endphp

        <h6 class="fw-bold mt-4 mb-3 text-secondary">Detail Pemeriksaan</h6>

        <table class="table table-bordered table-hover align-middle rounded overflow-hidden">
            <thead class="table-light text-center">
                <tr>
                    <th>Media yang Diperiksa</th>
                    <th width="80">Baik</th>
                    <th width="80">Tidak</th>
                    <th>Tindakan Perbaikan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $it)
                <tr>
                    <td class="fw-semibold">{{ $it['label'] }}</td>
                    <td class="text-center">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="{{ $it['key'] }}" value="Baik"
                                {{ old($it['key'], $inspeksiups->{$it['key']} ?? '') == 'Baik' ? 'checked' : '' }}>
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="{{ $it['key'] }}" value="Tidak"
                                {{ old($it['key'], $inspeksiups->{$it['key']} ?? '') == 'Tidak' ? 'checked' : '' }}>
                        </div>
                    </td>
                    <td>
                        <textarea name="tindakan_{{ $it['key'] }}"
                            class="form-control form-control-sm rounded-3 shadow-sm tindakan-field"
                            rows="2">{{ old('tindakan_'.$it['key'], $inspeksiups->{'tindakan_'.$it['key']} ?? '') }}</textarea>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- PENANDATANGAN --}}
        <div class="row mt-4">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Inspektor (ICT)</label>
                <select name="inspektor" class="form-select form-select-sm rounded-3 shadow-sm" required>
                    <option value="">Pilih Inspektor</option>
                    @foreach($karyawans as $k)
                        <option value="{{ $k->nama }}" {{ old('inspektor', $inspeksiups->inspektor ?? '') == $k->nama ? 'selected' : '' }}>
                            {{ $k->nama }} ({{ $k->jabatan }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Diketahui oleh (Group Leader ICT)</label>
                <select name="diketahui_oleh" class="form-select form-select-sm rounded-3 shadow-sm" required>
                    <option value="">Pilih Group Leader ICT</option>
                    @foreach($leaders as $leader)
                        <option value="{{ $leader->nama }}" {{ old('diketahui_oleh', $inspeksiups->diketahui_oleh ?? '') == $leader->nama ? 'selected' : '' }}>
                            {{ $leader->nama }} ({{ $leader->jabatan }})
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

    </div>
</div>

{{-- STYLE MODERN --}}
<style>
.form-control, .form-select {
    transition: all 0.2s ease-in-out;
}

.form-control:focus, .form-select:focus {
    border-color: #e74c3c;
    box-shadow: 0 0 0 0.15rem rgba(231, 76, 60, 0.25);
}

.table th {
    font-weight: 600;
    font-size: 0.9rem;
}

.table td {
    font-size: 0.88rem;
}

.card {
    animation: fadeInUp 0.4s ease;
}

@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
