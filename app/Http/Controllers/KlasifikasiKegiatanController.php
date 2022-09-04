<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\KlasifikasiKegiatan;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use RealRashid\SweetAlert\Facades\Alert;

class KlasifikasiKegiatanController extends Controller {
    public function index(Request $request) {
        if ($request->ajax()) {
            $data = KlasifikasiKegiatan::select(['id', 'group_kegiatan', 'name_kegiatan', 'alternate_name_kegiatan']);
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div class="dropdown">
                        <a class="btn btn-sm btn-icon px-0" data-toggle="dropdown" aria-expanded="false"><i data-feather="more-vertical"></i></a>
                        <div class="dropdown-menu dropdown-menu-right" style="">
                        <a href="' . route("master.klasifikasi.edit", Crypt::encrypt($row->id)) . '" class="dropdown-item"><i data-feather="edit"></i> Edit</a>
                        <form action="' . route("master.klasifikasi.destroy", [$row->id]) . '" method="POST" id="form-delete-' . $row->id . '" style="display: inline">
                        ' . csrf_field() . '
                        ' . method_field("DELETE") . '
                        <a href="#" onclick="submit_delete(' . $row->id . ')" class="dropdown-item"><i data-feather="trash-2"></i> Delete</a>
                        </form>
                        </div>
                        </div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->removeColumn('id')
                ->make(true);
        }

        return view('master.klasifikasi.index');
    }

    public function create() {
        return view('master.klasifikasi.form');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name_kegiatan' => 'required',
            'group_kegiatan' => 'required',
            'alternate_name_kegiatan' => 'nullable',
        ]);

        $post = KlasifikasiKegiatan::create([
            'name_kegiatan' => $request->name_kegiatan,
            'group_kegiatan' => $request->group_kegiatan,
            'alternate_name_kegiatan' => $request->alternate_name_kegiatan,
        ]);

        if ($post) {
            Alert::success('Berhasil!', 'Data klasifikasi kegiatan berhasil dibuat!');
            return redirect(route('master.klasifikasi.index'));
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'error' => 'Some problem occurred, please try again',
                ]);
        }
    }

    public function edit($id) {
        $data = KlasifikasiKegiatan::findOrFail(Crypt::decrypt($id));

        return view('master.klasifikasi.form', compact('data'));
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'name_kegiatan' => 'required',
            'group_kegiatan' => 'required',
            'alternate_name_kegiatan' => 'nullable',
        ]);

        $site = KlasifikasiKegiatan::findOrFail($id);

        $site->update([
            'name_kegiatan' => $request->name_kegiatan,
            'group_kegiatan' => $request->group_kegiatan,
            'alternate_name_kegiatan' => $request->alternate_name_kegiatan,
        ]);

        if ($site) {
            Alert::success('Berhasil!', 'Data klasifikasi kegiatan berhasil diupdate!');
            return redirect(route('master.klasifikasi.index'));
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
        $klasifikasi = KlasifikasiKegiatan::findOrFail($id);
        $klasifikasi->delete();

        if ($klasifikasi) {
            Alert::success('Berhasil!', 'Data klasifikasi kegiatan berhasil dihapus!');
            return redirect(route('master.klasifikasi.index'));
        } else {
            Alert::error('Gagal!', 'Data klasifikasi kegiatan tidak dapat dihapus!');
            return redirect(route('master.klasifikasi.index'));
        }
    }
}
