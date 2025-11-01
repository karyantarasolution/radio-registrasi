<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registrasi;
use Illuminate\Support\Facades\DB; // tambahkan ini


class DashboardController extends Controller
{
    public function index()
    {
        // --- API OpenWeatherMap ---
        $apiKey = "0b14321bccfdf91bd28f1396648671bc"; // ganti dengan key milikmu
        $city = "Tanjung,id";
        $url = "https://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$apiKey}&units=metric&lang=id";

        $weatherData = @json_decode(file_get_contents($url), true);

        // --- Data registrasi terbaru ---
        $latestRegistrasi = Registrasi::orderBy('created_at', 'desc')
                            ->take(6)
                            ->get();

        $jumlahRegistrasi = Registrasi::count();
        
      

        return view('dashboard.index', compact(
            'jumlahRegistrasi',
            'latestRegistrasi',
            'weatherData'
        ));

            
    }

   
}
