{{-- resources/views/inspeksiups/form.blade.php --}}
<div class="mb-3">
    <label class="form-label">Nomor Aset UPS</label>
    <input type="text" name="nomor_aset" class="form-control" 
        value="{{ old('nomor_aset', $inspeksi_up->nomor_aset ?? '') }}">
</div>

<div class="mb-3">
    <label class="form-label">Merek</label>
    <input type="text" name="merek" class="form-control" 
        value="{{ old('merek', $inspeksi_up->merek ?? '') }}">
</div>

<div class="mb-3">
    <label class="form-label">Type</label>
    <input type="text" name="type" class="form-control" 
        value="{{ old('type', $inspeksi_up->type ?? '') }}">
</div>

<div class="mb-3">
    <label class="form-label">S/N</label>
    <input type="text" name="sn" class="form-control" 
        value="{{ old('sn', $inspeksi_up->sn ?? '') }}">
</div>

<div class="mb-3">
    <label class="form-label">Departemen</label>
    <input type="text" name="departemen" class="form-control" 
        value="{{ old('departemen', $inspeksi_up->departemen ?? '') }}">
</div>

<div class="mb-3">
    <label class="form-label">Lokasi</label>
    <input type="text" name="lokasi" class="form-control" 
        value="{{ old('lokasi', $inspeksi_up->lokasi ?? '') }}">
</div>

<div class="mb-3">
    <label class="form-label">Tanggal Inspeksi</label>
    <input type="date" name="tanggal_inspeksi" class="form-control" 
        value="{{ old('tanggal_inspeksi', isset($inspeksi_up->tanggal_inspeksi) ? $inspeksi_up->tanggal_inspeksi->format('Y-m-d') : '') }}">
</div>

<div class="mb-3">
    <label class="form-label">Keterangan Umum</label>
    <textarea name="keterangan" class="form-control" rows="3">{{ old('keterangan', $inspeksi_up->keterangan ?? '') }}</textarea>
</div>

@php
  $items = [
    ['key'=>'casing','label'=>'Kondisi Casing UPS'],
    ['key'=>'kebersihan','label'=>'Kebersihan UPS'],
    ['key'=>'kabel_adaptor','label'=>'Kondisi kabel adaptor'],
    ['key'=>'tombol_switch','label'=>'Kondisi tombol dan switch'],
    ['key'=>'indikator_status','label'=>'Indikator status (power, battery, load)'],
    ['key'=>'fungsi_alarm','label'=>'Fungsi alarm'],
    ['key'=>'respon_kehilangan_daya','label'=>'Respon terhadap kehilangan daya'],
    ['key'=>'fuse','label'=>'Fuse (sekering)'],
  ];
@endphp

<table class="table table-bordered">
    <thead class="table-secondary">
        <tr>
            <th>Media yang Diperiksa</th>
            <th style="text-align:center;">Baik</th>
            <th style="text-align:center;">Tidak</th>
            <th>Tindakan Perbaikan</th>
        </tr>
    </thead>
    <tbody>
{{-- di bagian bawah form.blade.php (sebelum </body>) --}}
<div id="data-container" data-items='@json(array_column($items, "key"))'></div>

            @foreach($items as $it)
            <tr>
                <td>{{ $it['label'] }}</td>
                <td style="text-align:center;">
                    <input type="radio" name="{{ $it['key'] }}" value="Baik"
                        {{ old($it['key'], $inspeksi_up->{$it['key']} ?? '') == 'Baik' ? 'checked' : '' }}>
                </td>
                <td style="text-align:center;">
                    <input type="radio" name="{{ $it['key'] }}" value="Tidak"
                        {{ old($it['key'], $inspeksi_up->{$it['key']} ?? '') == 'Tidak' ? 'checked' : '' }}>
                </td>
                <td>
                    <textarea name="tindakan_{{ $it['key'] }}" class="form-control tindakan-field"
                        rows="2">{{ old('tindakan_'.$it['key'], $inspeksi_up->{'tindakan_'.$it['key']} ?? '') }}</textarea>
                </td>
            </tr>
            @endforeach
    </tbody>
</table>

<div class="mb-3">
    <label class="form-label">Inspektor (ICT)</label>
    <input type="text" name="inspektor" class="form-control" 
        value="{{ old('inspektor', $inspeksi_up->inspektor ?? '') }}">
</div>

<div class="mb-3">
    <label class="form-label">Diketahui Oleh</label>
    <input type="text" name="diketahui_oleh" class="form-control" 
        value="{{ old('diketahui_oleh', $inspeksi_up->diketahui_oleh ?? '') }}">
</div>

<div id="data-container" data-items='@json(array_column($items, "key"))'></div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const items = JSON.parse(document.getElementById('data-items').textContent);

        items.forEach(function (key) {
            const radios = Array.from(document.getElementsByName(key));
            const textarea = document.querySelector('textarea[name="tindakan_' + key + '"]');
            if (!radios.length || !textarea) return;
        });
    });
</script>

<!-- Simpan data di bawah -->
<script type="application/json" id="data-items">
    {!! json_encode(array_column($items, 'key')) !!}
</script>




