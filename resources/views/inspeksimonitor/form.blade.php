{{-- Partial form --}}
<div class="form-wrapper">
    <div class="card">
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label">Nomor Aset</label>
                <input type="text" name="nomor_aset" class="form-control" value="{{ old('nomor_aset', $inspeksimonitor->nomor_aset ?? '') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Merek</label>
                <input type="text" name="merek" class="form-control" value="{{ old('merek', $inspeksimonitor->merek ?? '') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Type</label>
                <input type="text" name="type" class="form-control" value="{{ old('type', $inspeksimonitor->type ?? '') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">S/N</label>
                <input type="text" name="sn" class="form-control" value="{{ old('sn', $inspeksimonitor->sn ?? '') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Departemen</label>
                <input type="text" name="departemen" class="form-control" value="{{ old('departemen', $inspeksimonitor->departemen ?? '') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Lokasi</label>
                <input type="text" name="lokasi" class="form-control" value="{{ old('lokasi', $inspeksimonitor->lokasi ?? '') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Tanggal Inspeksi</label>
                <input type="date" name="tanggal_inspeksi" class="form-control"
                    value="{{ old('tanggal_inspeksi', isset($inspeksimonitor->tanggal_inspeksi) ? $inspeksimonitor->tanggal_inspeksi->format('Y-m-d') : '') }}">
            </div>

            <hr>
            @php
            $checks = [
                ['key'=>'tampilan_layer','label'=>'Tampilan layer monitor'],
                ['key'=>'kabel_power','label'=>'Kondisi Kabel power'],
                ['key'=>'bracket_dudukan','label'=>'Kondisi bracket dudukan'],
                ['key'=>'kebersihan','label'=>'Kebersihan monitor'],
                ['key'=>'stop_kontak','label'=>'Kondisi stop kontak'],
            ];
            @endphp

            <table class="table table-bordered">
                <thead class="table-secondary">
                    <tr>
                        <th>Media yang diperiksa</th>
                        <th style="text-align:center">Baik</th>
                        <th style="text-align:center">Tidak</th>
                        <th>Tindakan Perbaikan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($checks as $c)
                    <tr>
                        <td>{{ $c['label'] }}</td>
                        <td class="text-center">
                            <input type="radio" name="{{ $c['key'] }}" value="Baik"
                                {{ old($c['key'], $inspeksimonitor->{$c['key']} ?? '') == 'Baik' ? 'checked' : '' }}>
                        </td>
                        <td class="text-center">
                            <input type="radio" name="{{ $c['key'] }}" value="Tidak"
                                {{ old($c['key'], $inspeksimonitor->{$c['key']} ?? '') == 'Tidak' ? 'checked' : '' }}>
                        </td>
                        <td>
                            <textarea name="tindakan_{{ $c['key'] }}" class="form-control" rows="2">{{ old('tindakan_'.$c['key'], $inspeksimonitor->{'tindakan_'.$c['key']} ?? '') }}</textarea>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mb-3">
                <label class="form-label">Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="3">{{ old('keterangan', $inspeksimonitor->keterangan ?? '') }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Inspektor (ICT)</label>
                <select name="inspektor" class="form-control" required>
                    <option value=""> Pilih Inspektor </option>
                    @foreach($karyawans as $k)
                        <option value="{{ $k->nama }}" {{ old('inspektor', $inspeksimonitor->inspektor ?? '') == $k->nama ? 'selected' : '' }}>
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
                        <option value="{{ $leader->nama }}" {{ old('diketahui_oleh', $inspeksimonitor->diketahui_oleh ?? '') == $leader->nama ? 'selected' : '' }}>
                            {{ $leader->nama }} ({{ $leader->jabatan }})
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
