<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Prodi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class LoginController extends Controller {
    public function authenticate(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email:dns'],
            'password' => ['required'],
        ]);

        $response = Http::asForm()->post('https://api-gateway.ubpkarawang.ac.id/auth/login', [
            'email' => $credentials['email'],
            'password' => $credentials['password'],
        ]);

        $output = $response->json();

        // dd($output);

        if ($output['status_code'] == 000) {
            // login success
            $data_user = $output['data'];
            $cek_user = User::where('email', $data_user['email'])->first();
            if (!$cek_user) {
                $cek_user = User::create([
                    'name' => $data_user['nama'],
                    'email' => $data_user['email'],
                    'password' => Hash::make('ubp2022'),
                ]);
            }

            // input id User model to session
            $data_user['user_id'] = $cek_user->id;

            // check assigned role
            if ($cek_user->getRoleNames()->isEmpty()) {
                // assign user with role. check if mahasiswa
                if ($output['data']['role'] == 'mahasiswa') {
                    $cek_user->assignRole('mahasiswa');
                } else {
                    $user_access_list = $output['data']['user_access'];
                    // check if kemahasiswaan
                    if (strpos($user_access_list, 'kemahasiswaan') !== false) {
                        $cek_user->assignRole('kemahasiswaan');
                    }

                    $cek_user->assignRole('dosen');
                }
            }

            // do login
            Auth::login($cek_user);

            $cek_user->update([
                'last_login_at' => Carbon::now()->toDateTimeString(),
                'last_login_ip' => $request->getClientIp(),
            ]);

            // save data to session
            $request->session()->put('user', $data_user);

            // register prodi
            $cek_prodi = Prodi::where('kode_prodi', $data_user['prodi'])->first();
            if (!$cek_prodi) {
                Prodi::create([
                    'kode_prodi' => $data_user['prodi'],
                    'nama_prodi' => 'Prodi ' . $data_user['prodi'],
                ]);
            }

            return redirect()->route('dashboard');
        } else {
            return back()->withErrors([
                'email' => $output['messages'],
            ]);
        }

        // dd($response->json());
    }

    public function logout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
