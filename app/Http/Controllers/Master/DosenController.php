<?php

namespace App\Http\Controllers\Master;

use DataTables;
use App\Models\Dosen;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use RealRashid\SweetAlert\Facades\Alert;

class DosenController extends Controller
{
    public function update_dosen() {
        $response = Http::asForm()->post('https://api-gateway.ubpkarawang.ac.id/auth/login', [
            'email' => 'adi.rizky@ubpkarawang.ac.id',
            'password' => '25112212',
        ]);
        $output_login = $response->json();

        $token = $output_login['token'];

        $response = Http::withHeaders(['Authorization' => $token])->get('https://api-gateway.ubpkarawang.ac.id/akademik/akademik/dosen');
        $output = $response->json();

        if (isset($output['data'])) {
            $bulk_data = array();
            foreach ($output['data'] as $data_dosen) {
                // if(!isset($status[$data_dosen['status_aktif']])){
                //     $status[$data_dosen['status_aktif']] = 0;
                // }
                // $status[$data_dosen['status_aktif']] += 1;

                    $bulk_data[] = [
                        'nip' => $data_dosen['nip'],
                        'jabatan_struktural' => $data_dosen['jabatan_struktural'],
                        'id_sipt' => $data_dosen['id'],
                        'nama' => $data_dosen['nama'],
                        'email' => $data_dosen['email'],
                        'nidn' => $data_dosen['nidn'],
                        'singkatan' => $data_dosen['singkatan'],
                        'prodi' => $data_dosen['homebase'],
                        
                    ];

            }

            // truncate first
            Dosen::truncate();
            // then insert batch
            Dosen::insert($bulk_data);

            Alert::success('Berhasil!', 'Data dosen berhasil diupdate!');
            return redirect(route('master.dosen.index'));
        }

        Alert::error('Update gagal!', 'Terjadi error saat update. Silahkan coba lagi dalam waktu 30 menit kedepan atau hub. administrator anda!');
        return redirect(route('master.dosen.index'));
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Dosen::all();
            return Datatables::of($data)->addIndexColumn()
                ->removeColumn('id')
                ->make(true);
        }

        return view('master.dosen.index');
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
    }

    public function show(Dosen $dosen)
    {
    }

    public function edit(Dosen $dosen)
    {
    }

    public function update(Request $request, Dosen $dosen)
    {
    }

    public function destroy(Dosen $dosen)
    {
    }
}
