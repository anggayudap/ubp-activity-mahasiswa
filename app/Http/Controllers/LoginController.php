<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Prodi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class LoginController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email:dns'],
            'password' => ['required'],
        ]);

        $response = Http::asForm()->post('https://api-gateway.ubpkarawang.ac.id/auth/login', [
            'email' => $credentials['email'],
            'password' => $credentials['password'],
        ]);

        $output = $response->json();

        if ($output['status_code'] == 000) {
            // login success
            $data_user = $output['data'];
            $cek_user = User::where('email', $data_user['email'])->first();
            if (!$cek_user) {
                $cek_user = User::create([
                    'name' => $data_user['nama'],
                    'email' => $data_user['email'],
                    'password' => Hash::make('ubp2022'),
                    'user_id' => $data_user['id'],
                ]);
            }

            // input id User model to session
            $data_user['user_id'] = $cek_user->id;

            // clear roles for renew dpm/dosen/kemahasiswaan access list w/ role in application
            if ($output['data']['role'] != 'mahasiswa') {
                $cek_user->roles()->detach();
            }

            // check assigned role
            if ($cek_user->getRoleNames()->isEmpty()) {
                // assign user with role. check if mahasiswa
                if ($output['data']['role'] == 'mahasiswa') {
                    $cek_user->assignRole('mahasiswa');
                } else {
                    $checking_user_access = false;
                    $user_access_list = $output['data']['user_access'];
                    $dpm_user_access = ['korprodi', 'dpm'];
                    $kemahasiswaan_user_access = ['kemahasiswaan', 'pusdatin', 'akademik'];

                    // handling for user access is null
                    if ($user_access_list) {
                        // check if user_access was valid with kemahasiswaan role
                        if ($this->strposa($user_access_list, $kemahasiswaan_user_access)) {
                            $cek_user->assignRole('kemahasiswaan');
                            $checking_user_access = true;
                        }

                        // check if user_access was valid with dpm role
                        if ($this->strposa($user_access_list, $dpm_user_access)) {
                            $cek_user->assignRole('dpm');
                            $checking_user_access = true;
                        }
                    }

                    // check if user hasnt user_access and employee is edosen
                    if ($output['data']['employee'] == 'dosen') {
                        $cek_user->assignRole('dosen');
                    }

                    // if user_access and employee is not matching w/ roles criteria
                    // or user hasnt assigned any role
                    if ($cek_user->getRoleNames()->isEmpty()) {
                        return redirect()->route('error_notauthorized');
                    }
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

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    private function strposa(string $haystack, array $needles, int $offset = 0): bool
    {
        foreach ($needles as $needle) {
            if (strpos($haystack, $needle, $offset) !== false) {
                return true; // stop on first true result
            }
        }

        return false;
    }
}
