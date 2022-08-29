<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller {
    public function cek_login(Request $request) {

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
 
            return redirect()->intended('dashboard');
        }
 
        return back()->withErrors([
            'email' => 'Email dan Password tidak cocok dengan data kami.',
        ]);




        if (!Auth::check()) {
            $payload = $this->decode_jwt();

            if ($payload) {
                // cek dept of user from sso payload
                // $dept = Departement::where('code', $payload->departement)->first();
                // if (!$dept) {
                //     $dept = Departement::create([
                //         'name' => $payload->departement,
                //         'code' => $payload->departement,
                //     ]);
                // }

                $cek_user = User::where('email', $payload->email)->first();
                if (!$cek_user) {
                    $cek_user = User::create([
                        'name' => $payload->fullname,
                        'email' => $payload->email,
                        'dept_id' => $dept->id,
                        'password' => Hash::make('apgb-user'),
                    ]);

                    // insert tabel role (role default : user)
                    RolesUsers::create([
                        'role_id' => '1',
                        'user_id' => $cek_user->id,
                    ]);
                }

                // do login
                Auth::login($cek_user);

                $roles_users = RolesUsers::where('user_id', $cek_user->id)->first();
                $role = Role::find($roles_users->role_id);

                $request->session()->put('user', [
                    'user_id' => $cek_user->id,
                    'email' => $payload->email,
                    'fullname' => $payload->fullname,
                    'username' => $payload->username,
                    'role' => $role->name,
                    'role_definition' => $role->definition,
                    'dept_id' => $dept->id,
                    'dept_name' => $dept->name,
                    'dept_code' => $dept->code,
                ]);
                $request->session()->put('user_theme', 'light');

                return redirect()->route('dashboard');
            } else {
                return redirect(env('SSO_URI') . '?back=' . url(''));
            }

        }
        return redirect()->route('dashboard');
    }

    // public function lihat_login(Request $request) {
    //     if (Auth::check()) {
    //         echo '<p>aku sudah login</p>';
    //     }

    // }

    public function logout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');

    }

    private function cek_login() {
        
    }

}
