<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title ?? 'Notifikasi Admin' }}</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #ea6666, #f71414); color: #fff; padding: 16px 20px; border-radius: 8px 8px 0 0; }
        .body { background: #f9f9f9; padding: 20px; border: 1px solid #eee; border-top: none; border-radius: 0 0 8px 8px; }
        .btn { display: inline-block; background: #ea6666; color: #fff !important; padding: 10px 20px; text-decoration: none; border-radius: 6px; margin-top: 16px; }
        ul { padding-left: 18px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2 style="margin:0;">{{ $title ?? 'Notifikasi Admin ICT' }}</h2>
        </div>
        <div class="body">
            <p>PT. Putra Perkasa Abadi — Sistem Radio Registasi</p>
            @if(!empty($lines))
                <ul>
                    @foreach($lines as $line)
                        <li>{{ $line }}</li>
                    @endforeach
                </ul>
            @endif
            @if(!empty($actionUrl))
                <a href="{{ $actionUrl }}" class="btn">{{ $actionText ?? 'Buka Aplikasi' }}</a>
            @endif
        </div>
    </div>
</body>
</html>
