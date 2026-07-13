<table style="width:100%; margin-bottom:16px;">
    <tr>
        <td style="width:15%; text-align:center; vertical-align:middle;">
            <img src="{{ asset('images/ppa-logo.png') }}" alt="logo" style="max-width:100px;">
        </td>
        <td style="width:55%; text-align:center; vertical-align:middle;">
            <h4 class="fw-bold mb-1">{{ $reportTitle }}</h4>
            <div class="text-muted">ICT (Information Communication & Technology)</div>
        </td>
        <td style="width:35%; vertical-align:middle;">
            <table class="report-meta" style="width:100%; font-size:13px;">
                <tr><td>No. Dokumen</td><td>: {{ $docNumber }}</td></tr>
                <tr><td>Revisi</td><td>: 0</td></tr>
                <tr><td>Tgl Efektif</td><td>: {{ now()->format('d-M-Y') }}</td></tr>
            </table>
        </td>
    </tr>
</table>
