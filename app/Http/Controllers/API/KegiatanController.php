<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\KegiatanResource;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class KegiatanController extends Controller
{
    public function all(Request $request)
    {
        $posts = Kegiatan::select('id', 'klasifikasi_id', 'nama_kegiatan', 'nim', 'bukti_kegiatan')
            ->where('approval', 'approve')
            ->with(['klasifikasi'])
            ->get();

        $output = [];

        if ($posts->count() > 0) {
            foreach ($posts as $post) {
                $output[] = [
                    'nama-kegiatan' => $post->nama_kegiatan,
                    'nim' => $post->nim,
                    'id-kegiatan' => $post->id,
                    'klasifikasi' => $post->klasifikasi->name_kegiatan,
                    'tahun-kegiatan' => $post->tahun_periode,
                    'bukti-sertifikat' => URL::asset($post->bukti_kegiatan),
                ];
            }

            //return collection of posts as a resource
            return new KegiatanResource('200', 'Data Kegiatan : Ditemukan', $output);
        }

        return new KegiatanResource('404', 'Data Kegiatan : Tidak Ditemukan', $output);
    }

    public function filtered(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nim' => 'required',
            ],
            [
                'nim.required' => 'Masukkan NIM Mahasiswa !',
            ],
        );

        if ($validator->fails()) {
            return new KegiatanResource('401', 'Silahkan Isi Bidang Yang Kosong', $validator->errors());
        } else {
            $posts = Kegiatan::select('id', 'klasifikasi_id', 'nama_kegiatan', 'nim', 'bukti_kegiatan')
                ->where('approval', 'approve')
                ->where('nim', $request->input('nim'))
                ->with(['klasifikasi'])
                ->get();

            $output = [];

            if ($posts->count() > 0) {
                foreach ($posts as $post) {
                    $output[] = [
                        'nama-kegiatan' => $post->nama_kegiatan,
                        'nim' => $post->nim,
                        'id-kegiatan' => $post->id,
                        'klasifikasi' => $post->klasifikasi->name_kegiatan,
                        'tahun-kegiatan' => $post->tahun_periode,
                        'bukti-sertifikat' => URL::asset($post->bukti_kegiatan),
                    ];
                }

                //return collection of posts as a resource
                return new KegiatanResource('200', 'List Data Kegiatan : Ditemukan', $output);
            }

            return new KegiatanResource('404', 'List Data Kegiatan : Tidak Ditemukan', $output);
        }
    }
}
