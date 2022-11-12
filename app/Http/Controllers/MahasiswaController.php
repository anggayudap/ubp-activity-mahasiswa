<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MahasiswaController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

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
                    ];
                }

            }

            // truncate first
            Mahasiswa::truncate();

            Mahasiswa::insert($bulk_data);

            return true;
        }

        return false;
    }

    public function index() {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function show(Mahasiswa $mahasiswa) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function edit(Mahasiswa $mahasiswa) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mahasiswa $mahasiswa) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mahasiswa $mahasiswa) {
        //
    }
}
