{{-- resources/views/inspeksistavolt/form.blade.php --}}
<div class="mb-3">
    <label class="form-label">Nomor Aset Stavolt</label>
    <input type="text" name="nomor_aset" class="form-control" value="{{ old('nomor_aset', $inspeksistavolt->nomor_aset ?? '') }}">
</div>

<div class="mb-3">
    <label class="form-label">Merek</label>
    <input type="text" name="merek" class="form-control" value="{{ old('merek', $inspeksistavolt->merek ?? '') }}">
</div>

<div class="mb-3">
    <label class="form-label">Type</label>
    <input type="text" name="type" class="form-control" value="{{ old('type', $inspeksistavolt->type ?? '') }}">
</div>

<div class="mb-3">
    <label class="form-label">S/N</label>
    <input type="text" name="sn" class="form-control" value="{{ old('sn', $inspeksistavolt->sn ?? '') }}">
</div>

<div class="mb-3">
    <label class="form-label">Departemen</label>
    <input type="text" name="departemen" class="form-control" value="{{ old('departemen', $inspeksistavolt->departemen ?? '') }}">
</div>

<div class="mb-3">
    <label class="form-label">Lokasi</label>
    <input type="text" name="lokasi" class="form-control" value="{{ old('lokasi', $inspeksistavolt->lokasi ?? '') }}">
</div>

<div class="mb-3">
    <label class="form-label">Tanggal Inspeksi</label>
    <input type="date" name="tanggal_inspeksi" class="form-control" value="{{ old('tanggal_inspeksi', isset($inspeksistavolt->tanggal_inspeksi) ? $inspeksistavolt->tanggal_inspeksi->format('Y-m-d') : '') }}">
</div>

<div class="mb-3">
    <label class="form-label">Keterangan Umum</label>
    <textarea name="keterangan" class="form-control" rows="3">{{ old('keterangan', $inspeksistavolt->keterangan ?? '') }}</textarea>
</div>

@php
  $items = [
    ['key'=>'casing','label'=>'Kondisi casing stavolt'],
    ['key'=>'kebersihan','label'=>'Kebersihan stavolt'],
    ['key'=>'kabel_adaptor','label'=>'Kondisi kabel adaptor'],
    ['key'=>'tombol_switch','label'=>'Kondisi tombol dan switch'],
    ['key'=>'indikator_voltase','label'=>'Indikator voltase input/output (220 V)'],
    ['key'=>'respon_perubahan_beban','label'=>'Respon terhadap perubahan beban'],
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
        @foreach($items as $it)
        <tr>
            <td>{{ $it['label'] }}</td>
            <td style="text-align:center;">
                <input type="radio" name="{{ $it['key'] }}" value="Baik"
                    {{ old($it['key'], $inspeksistavolt->{$it['key']} ?? '') == 'Baik' ? 'checked' : '' }}>
            </td>
            <td style="text-align:center;">
                <input type="radio" name="{{ $it['key'] }}" value="Tidak"
                    {{ old($it['key'], $inspeksistavolt->{$it['key']} ?? '') == 'Tidak' ? 'checked' : '' }}>
            </td>
            <td>
                <textarea name="tindakan_{{ $it['key'] }}" class="form-control tindakan-field" rows="2">{{ old('tindakan_'.$it['key'], $inspeksistavolt->{'tindakan_'.$it['key']} ?? '') }}</textarea>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="mb-3">
    <label class="form-label">Inspektor (ICT)</label>
        <select name="inspektor" class="form-control" required>
                <option value=""> Pilih Inspektor </option>
                 @foreach($karyawans as $k)
                    <option value="{{ $k->nama }}" {{ old('inspektor', $inspeksistavolt->inspektor ?? '') == $k->nama ? 'selected' : '' }}>
                        {{ $k->nama }} ({{ $k->jabatan }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Diketahui oleh (Group Leader ICT)</label>
                <select name="diketahui_oleh" class="form-control" required>
                    <option value=""> Pilih Group Leader ICT </option>
                    @foreach($leaders as $leader)
                        <option value="{{ $leader->nama }}" {{ old('diketahui_oleh', $inspeksistavolt->diketahui_oleh ?? '') == $leader->nama ? 'selected' : '' }}>
                            {{ $leader->nama }} ({{ $leader->jabatan }})
                        </option>
                    @endforeach
                </select>
            </div>