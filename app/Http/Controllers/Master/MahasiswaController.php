<?php

namespace App\Http\Controllers\Master;

use DataTables;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use RealRashid\SweetAlert\Facades\Alert;

class MahasiswaController extends Controller {
   
    public function update_mahasiswa() {
        $response = Http::withHeaders(['Authorization' => '743jda0RAodasfRRi35e'])->post('https://api-gateway.ubpkarawang.ac.id/external/akademik/mahasiswa');
        $output = $response->json();

        if (isset($output['data'])) {
            $bulk_data = array();
            foreach ($output['data'] as $data_mhs) {
                // if(!isset($status[$data_mhs['status_aktif']])){
                //     $status[$data_mhs['status_aktif']] = 0;
                // }
                // $status[$data_mhs['status_aktif']] += 1;

                if (in_array($data_mhs['status_aktif'], array('Aktif', 'AKTIF'))) {
                    $bulk_data[] = [
                        'nim' => $data_mhs['nim'],
                        'nama_mahasiswa' => $data_mhs['nama'],
                        'prodi' => $data_mhs['kode_prodi'],
                        'periode_masuk' => $data_mhs['id_periode_masuk'],
                        'tanggal_update' => date("Y-m-d H:i:s"),
                    ];
                }

            }

            // truncate first
            Mahasiswa::truncate();
            // then insert batch
            Mahasiswa::insert($bulk_data);

            Alert::success('Berhasil!', 'Data mahasiswa berhasil diupdate!');
            return redirect(route('master.mahasiswa.index'));
        }

        Alert::error('Update gagal!', 'Terjadi error saat update. Silahkan coba lagi dalam waktu 30 menit kedepan atau hub. administrator anda!');
        return redirect(route('master.mahasiswa.index'));
    }

    public function index(Request $request) {
        if ($request->ajax()) {
            $data = Mahasiswa::all();
            return Datatables::of($data)->addIndexColumn()
                ->removeColumn('id')
                ->make(true);
        }

        return view('master.mahasiswa.index');
    }

    public function store(Request $request) {
        //
    }

    public function show(Mahasiswa $mahasiswa) {
        //
    }

    public function edit(Mahasiswa $mahasiswa) {
        //
    }

    public function update(Request $request, Mahasiswa $mahasiswa) {
        //
    }

    public function destroy(Mahasiswa $mahasiswa) {
        //
    }
}
