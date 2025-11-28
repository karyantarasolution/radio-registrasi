{{-- Partial form inspeksi proyektor --}}
<div class="form-wrapper">
    <div class="card">
        <div class="card-body">
            {{-- Identitas Perangkat --}}
            <div class="mb-3">
                <label class="form-label">Nomor Aset Proyektor</label>
                <input type="text" name="nomor_aset" class="form-control" 
                    value="{{ old('nomor_aset', $inspeksiproyektor->nomor_aset ?? '') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Merek</label>
                <input type="text" name="merek" class="form-control" 
                    value="{{ old('merek', $inspeksiproyektor->merek ?? '') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Type</label>
                <input type="text" name="type" class="form-control" 
                    value="{{ old('type', $inspeksiproyektor->type ?? '') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">S/N</label>
                <input type="text" name="sn" class="form-control" 
                    value="{{ old('sn', $inspeksiproyektor->sn ?? '') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Departemen</label>
                <input type="text" name="departemen" class="form-control" 
                    value="{{ old('departemen', $inspeksiproyektor->departemen ?? '') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Lokasi</label>
                <input type="text" name="lokasi" class="form-control" 
                    value="{{ old('lokasi', $inspeksiproyektor->lokasi ?? '') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Tanggal Inspeksi</label>
                <input type="date" name="tanggal_inspeksi" class="form-control"
                    value="{{ old('tanggal_inspeksi', isset($inspeksiproyektor->tanggal_inspeksi) ? $inspeksiproyektor->tanggal_inspeksi->format('Y-m-d') : '') }}">
            </div>

            <hr>

            {{-- Kondisi Pemeriksaan --}}
            @php
            $checks = [
                ['key'=>'kondisi_casing','label'=>'Kondisi Casing Proyektor'],
                ['key'=>'kebersihan','label'=>'Kebersihan Proyektor'],
                ['key'=>'kabel_adaptor','label'=>'Kondisi Kabel Adaptor'],
                ['key'=>'lensa_proyektor','label'=>'Lensa Proyektor'],
                ['key'=>'indikator_lampu','label'=>'Indikator Lampu'],
                ['key'=>'fokus_zoom','label'=>'Fokus dan Zoom'],
                ['key'=>'kecerahan_kontras','label'=>'Kecerahan dan Kontras'],
                ['key'=>'koneksi_input_hdmi','label'=>'Koneksi Input HDMI'],
                ['key'=>'koneksi_input_vga','label'=>'Koneksi Input VGA'],
                ['key'=>'koneksi_input_usb','label'=>'Koneksi Input USB'],
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
                                {{ old($c['key'], $inspeksiproyektor->{$c['key']} ?? '') == 'Baik' ? 'checked' : '' }}>
                        </td>
                        <td class="text-center">
                            <input type="radio" name="{{ $c['key'] }}" value="Tidak"
                                {{ old($c['key'], $inspeksiproyektor->{$c['key']} ?? '') == 'Tidak' ? 'checked' : '' }}>
                        </td>
                        <td>
                            <textarea name="tindakan_{{ $c['key'] }}" class="form-control" rows="2">{{ old('tindakan_'.$c['key'], $inspeksiproyektor->{'tindakan_'.$c['key']} ?? '') }}</textarea>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Keterangan dan Pemeriksa --}}
            <div class="mb-3">
                <label class="form-label">Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="3">{{ old('keterangan', $inspeksiproyektor->keterangan ?? '') }}</textarea>
            </div>

    <div class="mb-3">
    <label class="form-label">Inspektor (ICT)</label>
        <select name="inspektor" class="form-control" required>
                <option value=""> Pilih Inspektor </option>
                 @foreach($karyawans as $k)
                    <option value="{{ $k->nama }}" {{ old('inspektor', $inspeksiproyektor->inspektor ?? '') == $k->nama ? 'selected' : '' }}>
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
                        <option value="{{ $leader->nama }}" {{ old('diketahui_oleh', $inspeksiproyektor->diketahui_oleh ?? '') == $leader->nama ? 'selected' : '' }}>
                            {{ $leader->nama }} ({{ $leader->jabatan }})
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
