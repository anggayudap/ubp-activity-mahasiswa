<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\Prodi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class ProdiController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {
            $data = Prodi::select(['id', 'kode_prodi', 'nama_prodi']);
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div class="dropdown">
                        <a class="btn btn-sm btn-icon px-0" data-toggle="dropdown" aria-expanded="false"><i data-feather="more-vertical"></i></a>
                        <div class="dropdown-menu dropdown-menu-right" style="">
                        <a href="' . route("master.prodi.edit", $row->id) . '" class="dropdown-item"><i data-feather="edit"></i> Edit</a>
                        <form action="' . route("master.prodi.destroy", [$row->id]) . '" method="POST" id="form-delete-' . $row->id . '" style="display: inline">
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

        return view('master.prodi.index');
    }

    public function create() {
        return view('master.prodi.form');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'kode_prodi' => 'required',
            'nama_prodi' => 'required',
        ]);

        $post = Prodi::create([
            'kode_prodi' => $request->kode_prodi,
            'nama_prodi' => $request->nama_prodi,
        ]);

        if ($post) {
            Alert::success('Berhasil!', 'Data prodi berhasil dibuat!');
            return redirect(route('master.prodi.index'));
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
        $data = Prodi::findOrFail($id);

        return view('master.prodi.form', compact('data'));
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'kode_prodi' => 'required',
            'nama_prodi' => 'required',
        ]);

        $site = Prodi::findOrFail($id);

        $site->update([
            'kode_prodi' => $request->kode_prodi,
            'nama_prodi' => $request->nama_prodi,
        ]);

        if ($site) {
            Alert::success('Berhasil!', 'Data prodi berhasil diupdate!');
            return redirect(route('master.prodi.index'));
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
        $prodi = Prodi::findOrFail($id);
        $prodi->delete();

        if ($prodi) {
            Alert::success('Berhasil!', 'Data prodi berhasil dihapus!');
            return redirect(route('master.prodi.index'));
        } else {
            Alert::error('Gagal!', 'Data prodi tidak dapat dihapus!');
            return redirect(route('master.prodi.index'));
        }
    }
}
