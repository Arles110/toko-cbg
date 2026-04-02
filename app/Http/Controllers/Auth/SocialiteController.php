<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use Illuminate\Support\Str;

class SocialiteController extends Controller
{
    // Fungsi untuk mengarahkan ke halaman login Google
    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    // Fungsi untuk menangani data yang dikirim balik oleh Google
    public function handleProviderCallback()
    {
        try {
            $userGoogle = Socialite::driver('google')->user();
            
            // Cari user berdasarkan email di database
            $user = User::where('email', $userGoogle->getEmail())->first();

            if ($user) {
                // Jika user sudah ada, langsung login
                Auth::login($user);
            } else {
                // Jika belum ada, buat user baru otomatis
                $newUser = User::create([
                    'name' => $userGoogle->getName(),
                    'email' => $userGoogle->getEmail(),
                    'password' => bcrypt(Str::random(16)), // Password acak agar aman
                    'role' => 'staff', // Menyesuaikan input hidden di form kamu
                ]);

                Auth::login($newUser);
            }

            // Arahkan ke dashboard setelah berhasil login
            return redirect()->intended('dashboard');

        } catch (Exception $e) {
            // Jika ada error (misal user membatalkan login)
            return redirect('/login')->withErrors(['msg' => 'Gagal login menggunakan Google.']);
        }
    }
}