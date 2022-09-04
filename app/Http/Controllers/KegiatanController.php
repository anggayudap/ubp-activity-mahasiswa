<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use App\Models\KlasifikasiKegiatan;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use RealRashid\SweetAlert\Facades\Alert;

class KegiatanController extends Controller {

    public function index(Request $request) {
        if ($request->ajax()) {
            $data = Kegiatan::select(['id', 'nama_kegiatan', 'nama_mahasiswa', 'klasifikasi_id', 'status']);
            // dd($data);
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div class="dropdown">
                        <a class="btn btn-sm btn-icon px-0" data-toggle="dropdown" aria-expanded="false"><i data-feather="more-vertical"></i></a>
                        <div class="dropdown-menu dropdown-menu-right" style="">
                        <a href="' . route("kegiatan.show", Crypt::encrypt($row->id)) . '" class="dropdown-item"><i data-feather="file-text"></i> Detail</a>
                        <a href="' . route("kegiatan.edit", Crypt::encrypt($row->id)) . '" class="dropdown-item"><i data-feather="edit"></i> Edit</a>
                        <form action="' . route("kegiatan.destroy", [$row->id]) . '" method="POST" id="form-delete-' . $row->id . '" style="display: inline">
                        ' . csrf_field() . '
                        ' . method_field("DELETE") . '
                        <a href="#" onclick="submit_delete(' . $row->id . ')" class="dropdown-item"><i data-feather="trash-2"></i> Delete</a>
                        </form>
                        </div>
                        </div>';
                    return $btn;
                })
                ->editColumn('klasifikasi_id', function (Kegiatan $kegiatan) {
                    return $kegiatan->klasifikasi->name_kegiatan;
                })
                ->editColumn('status', function (Kegiatan $kegiatan) {
                    if ($kegiatan->status == 'completed') {
                        return 'Selesai';
                    }
                    if ($kegiatan->status == 'checked_kemahasiswaan') {
                        return 'Dilihat Kemahasiswaan';
                    }
                    if ($kegiatan->status == 'checked_dosen') {
                        return 'Dilihat Dosen';
                    }
                    return 'Sedang Direview';
                })
                ->rawColumns(['action'])
                ->removeColumn('id')
                ->make(true);
        }

        return view('kegiatan.index');
    }

    public function create() {
        $klasifikasi = KlasifikasiKegiatan::all();
        $group = null;
        $klasifikasi = $klasifikasi->groupBy('group_kegiatan');
        // dd($klasifikasi);
        return view('kegiatan.form', compact('klasifikasi'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name_kegiatan' => 'required',
            'group_kegiatan' => 'required',
            'alternate_name_kegiatan' => 'nullable',
        ]);

        $post = Kegiatan::create([
            'name_kegiatan' => $request->name_kegiatan,
            'group_kegiatan' => $request->group_kegiatan,
            'alternate_name_kegiatan' => $request->alternate_name_kegiatan,
        ]);

        if ($post) {
            Alert::success('Berhasil!', 'Data klasifikasi kegiatan berhasil dibuat!');
            return redirect(route('kegiatan.index'));
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'error' => 'Some problem occurred, please try again',
                ]);
        }
    }

    public function show($id) {
        //
    }

    public function edit($id) {
        $data = Kegiatan::findOrFail(Crypt::decrypt($id));

        return view('kegiatan.form', compact('data'));
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'name_kegiatan' => 'required',
            'group_kegiatan' => 'required',
            'alternate_name_kegiatan' => 'nullable',
        ]);

        $site = Kegiatan::findOrFail($id);

        $site->update([
            'name_kegiatan' => $request->name_kegiatan,
            'group_kegiatan' => $request->group_kegiatan,
            'alternate_name_kegiatan' => $request->alternate_name_kegiatan,
        ]);

        if ($site) {
            Alert::success('Berhasil!', 'Data klasifikasi kegiatan berhasil diupdate!');
            return redirect(route('kegiatan.index'));
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'error' => 'Some problem occurred, please try again',
                ]);
        }
    }

    public function destroy($id) {
        $klasifikasi = Kegiatan::findOrFail($id);
        $klasifikasi->delete();

        if ($klasifikasi) {
            Alert::success('Berhasil!', 'Data klasifikasi kegiatan berhasil dihapus!');
            return redirect(route('kegiatan.index'));
        } else {
            Alert::error('Gagal!', 'Data klasifikasi kegiatan tidak dapat dihapus!');
            return redirect(route('kegiatan.index'));
        }
    }

}
