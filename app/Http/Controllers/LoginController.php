<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Http\Request;
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

            // do login
            Auth::login($cek_user);

            // save data to session
            $request->session()->put('user', $data_user);

            // update data role
            $cek_role = RoleUser::where('name', $data_user['role'])->first();
            if (!$cek_role) {
                RoleUser::create([
                    'name' => $data_user['role'],
                    'description' => ucfirst($data_user['role']),
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
