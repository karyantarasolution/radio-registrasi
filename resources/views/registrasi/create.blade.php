@extends('layouts.app')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #ffffffff 0%, #ffffffff 100%);
        min-height: 100vh;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .form-wrapper {
        display: flex;
        justify-content: center;
        align-items: flex-start;
        width: 100%;
        padding: 30px 15px;
        margin-top: 20px;
        min-height: calc(100vh - 80px);
    }

    .card {
        border-radius: 10px;
        width: 100%;
        max-width: 520px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1), 
                    0 15px 12px rgba(0, 0, 0, 0.08);
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        overflow: hidden;
        animation: slideUp 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        position: relative;
    }

    .card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #667eea, #764ba2, #f093fb);
    }

    .card-header {
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 50%, #2c3e50 100%);
        color: #fff;
        padding: 25px 20px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .card-header::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: linear-gradient(45deg, transparent, rgba(255,255,255,0.1), transparent);
        transform: rotate(45deg);
        animation: shimmer 3s infinite;
    }

    .card-header h4 {
        font-size: 1.4rem;
        font-weight: 700;
        margin: 0;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        position: relative;
        z-index: 1;
    }

    .card-header::after {
        content: '';
        position: absolute;
        top: 50%;
        right: 20px;
        transform: translateY(-50%);
        font-size: 1.5rem;
        opacity: 0.7;
    }

    .card-body {
        padding: 30px 25px;
    }

    .form-group {
        margin-bottom: 20px;
        position: relative;
    }

    .form-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #2c3e50;
        font-size: 0.95rem;
        position: relative;
        padding-left: 8px;
    }

    .form-label::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 3px;
        height: 16px;
        background: linear-gradient(45deg, #667eea, #764ba2);
        border-radius: 2px;
    }

    .form-control {
        border-radius: 12px;
        padding: 14px 18px;
        font-size: 0.95rem;
        border: 2px solid #e8ecf0;
        transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        background: #ffffff;
        width: 100%;
        box-sizing: border-box;
        position: relative;
    }

    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        outline: none;
        transform: translateY(-1px);
        background: #fafbfc;
    }

    .form-control.is-invalid {
        border-color: #e74c3c;
        background: #fdf2f2;
    }

    .form-control.is-invalid:focus {
        box-shadow: 0 0 0 4px rgba(231, 76, 60, 0.1);
    }

    .invalid-feedback {
        display: block;
        margin-top: 6px;
        font-size: 0.85rem;
        color: #e74c3c;
        padding-left: 18px;
    }

    .btn {
        border-radius: 12px;
        padding: 14px 24px;
        font-size: 0.95rem;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        position: relative;
        overflow: hidden;
    }

    .btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.6s;
    }

    .btn:hover::before {
        left: 100%;
    }

    .btn-success {
        background: linear-gradient(45deg, #27ae60, #2ecc71);
        color: white;
        box-shadow: 0 4px 15px rgba(46, 204, 113, 0.3);
    }

    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(46, 204, 113, 0.4);
        background: linear-gradient(45deg, #229954, #27ae60);
    }

    .btn-secondary {
        background: linear-gradient(45deg, #7f8c8d, #95a5a6);
        color: white;
        box-shadow: 0 4px 15px rgba(127, 140, 141, 0.3);
    }

    .btn-secondary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(127, 140, 141, 0.4);
        background: linear-gradient(45deg, #6c7b7d, #7f8c8d);
        color: white;
        text-decoration: none;
    }

    .button-group {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 30px;
        gap: 15px;
    }

    .alert {
        border-radius: 12px;
        padding: 16px 20px;
        margin-bottom: 25px;
        border: none;
        position: relative;
        animation: slideIn 0.4s ease-out;
    }

    .alert-danger {
        background: linear-gradient(45deg, #e74c3c, #c0392b);
        color: white;
        box-shadow: 0 4px 15px rgba(231, 76, 60, 0.2);
    }

    .alert ul {
        margin: 8px 0 0 0;
        padding-left: 20px;
    }

    .alert li {
        margin-bottom: 4px;
    }

    /* Input Icons */
    .input-group {
        position: relative;
    }

    .input-icon {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #bdc3c7;
        font-size: 1.1rem;
        z-index: 1;
        pointer-events: none;
        transition: color 0.3s;
    }

    .form-control:focus + .input-icon {
        color: #667eea;
    }

    /* Loading Animation */
    .btn-loading {
        position: relative;
        pointer-events: none;
        opacity: 0.7;
    }

    .btn-loading::after {
        content: '';
        position: absolute;
        width: 16px;
        height: 16px;
        margin: auto;
        border: 2px solid transparent;
        border-top-color: #ffffff;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px) scale(0.95);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes shimmer {
        0% { transform: translateX(-100%) rotate(45deg); }
        100% { transform: translateX(100%) rotate(45deg); }
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Responsive Design */
    @media (max-width: 576px) {
        .form-wrapper {
            padding: 15px 10px;
        }
        
        .card {
            max-width: 100%;
            margin: 0;
        }
        
        .card-body {
            padding: 20px 20px;
        }
        
        .button-group {
            flex-direction: column-reverse;
            gap: 10px;
        }
        
        .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="form-wrapper">
    <div class="card">
        <div class="card-header">
            <h4>Form Registrasi Radio</h4>
        </div>

        <div class="card-body">
            {{-- Error validasi --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>⚠️ Perhatian!</strong> Ada kesalahan pada input Anda:
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('registrasi.store') }}" method="POST" id="radioForm">
                @csrf

                <div class="form-group">
                    <label for="perusahaan" class="form-label">Perusahaan</label>
                    <div class="input-group">
                        <input type="text" name="perusahaan" id="perusahaan"
                               value="{{ old('perusahaan') }}"
                               class="form-control @error('perusahaan') is-invalid @enderror" 
                               placeholder="Masukkan nama perusahaan"
                               required>
                    </div>
                    @error('perusahaan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="nomor_lambung" class="form-label">Nomor Lambung</label>
                    <div class="input-group">
                        <input type="text" name="nomor_lambung" id="nomor_lambung"
                               value="{{ old('nomor_lambung') }}"
                               class="form-control @error('nomor_lambung') is-invalid @enderror"
                               placeholder="Contoh: KL-001"
                               required>
                    </div>
                    @error('nomor_lambung')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="jenis_kendaraan" class="form-label">Jenis Kendaraan</label>
                    <div class="input-group">
                        <input type="text" name="jenis_kendaraan" id="jenis_kendaraan"
                               value="{{ old('jenis_kendaraan') }}"
                               class="form-control @error('jenis_kendaraan') is-invalid @enderror"
                               placeholder="Contoh: Truck, Mobil, Motor"
                               required>
                    </div>
                    @error('jenis_kendaraan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="nomor_polisi" class="form-label">Nomor Polisi</label>
                    <div class="input-group">
                        <input type="text" name="nomor_polisi" id="nomor_polisi"
                               value="{{ old('nomor_polisi') }}"
                               class="form-control @error('nomor_polisi') is-invalid @enderror"
                               placeholder="Contoh: DA 1234 XY">
                    </div>
                    @error('nomor_polisi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="merek_radio" class="form-label">Merek Radio</label>
                    <div class="input-group">
                        <input type="text" name="merek_radio" id="merek_radio"
                               value="{{ old('merek_radio') }}"
                               class="form-control @error('merek_radio') is-invalid @enderror"
                               placeholder="Contoh: Motorola, Icom, Kenwood">
                    </div>
                    @error('merek_radio')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="serial_number" class="form-label">Serial Number</label>
                    <div class="input-group">
                        <input type="text" name="serial_number" id="serial_number"
                               value="{{ old('serial_number') }}"
                               class="form-control @error('serial_number') is-invalid @enderror"
                               placeholder="Masukkan serial number radio">
                    </div>
                    @error('serial_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label class="form-label">Pilih Channel Radio</label><br>
                    @php
                        $channels = [
                            'ADARO 2', 'ADARO 4', 
                            'PPA SECURITY', 'PPA FRONT', 'PPA DISPOSAL', 
                            'PPA CCR', 'PPA PLANT', 'PPA BASECONTROL', 
                            'PPA 1', 'PPA 2'
                        ];
                    @endphp

                    @foreach($channels as $ch)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   name="channels[]" 
                                   value="{{ $ch }}" 
                                   id="ch_{{ Str::slug($ch) }}">
                            <label class="form-check-label" for="ch_{{ Str::slug($ch) }}">{{ $ch }}</label>
                        </div>
                    @endforeach
                </div>


                <div class="button-group">
                    <a href="{{ route('registrasi.index') }}" class="btn btn-secondary">
                        ⬅ Kembali
                    </a>
                    <button type="submit" class="btn btn-success" id="submitBtn">
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('radioForm').addEventListener('submit', function() {
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.classList.add('btn-loading');
    submitBtn.innerHTML = 'Menyimpan...';
});

// Auto-format nomor polisi
document.getElementById('nomor_polisi').addEventListener('input', function(e) {
    let value = e.target.value.toUpperCase();
    // Remove any non-alphanumeric characters except spaces
    value = value.replace(/[^A-Z0-9\s]/g, '');
    e.target.value = value;
});

// Auto-format nomor lambung
document.getElementById('nomor_lambung').addEventListener('input', function(e) {
    let value = e.target.value.toUpperCase();
    e.target.value = value;
});

// Add floating label effect
document.querySelectorAll('.form-control').forEach(function(input) {
    input.addEventListener('focus', function() {
        this.parentElement.classList.add('focused');
    });
    
    input.addEventListener('blur', function() {
        if (this.value === '') {
            this.parentElement.classList.remove('focused');
        }
    });
    
    // Check if input has value on page load
    if (input.value !== '') {
        input.parentElement.classList.add('focused');
    }
});
</script>
@endsection