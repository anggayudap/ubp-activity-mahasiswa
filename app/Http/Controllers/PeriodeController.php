<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\Periode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PeriodeController extends Controller {

    public function index(Request $request) {
        if ($request->ajax()) {
            $data = Periode::select(['id', 'periode_awal', 'periode_akhir']);
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div class="dropdown">
                        <a class="btn btn-sm btn-icon px-0" data-toggle="dropdown" aria-expanded="false"><i data-feather="more-vertical"></i></a>
                        <div class="dropdown-menu dropdown-menu-right" style="">
                        <a href="' . route("master.periode.edit", $row->id) . '" class="dropdown-item"><i data-feather="edit"></i> Edit</a>
                        <form action="' . route("master.periode.destroy", [$row->id]) . '" method="POST" id="form-delete-' . $row->id . '" style="display: inline">
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

        return view('master.periode.index');
    }

    public function create() {
        return view('master.periode.form');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name_site' => 'required',
            'location' => 'required',
        ]);

        $post = Site::create([
            'name_site' => $request->name_site,
            'location' => $request->location,
        ]);

        if ($post) {
            Alert::success('Berhasil!', 'Data site berhasil dibuat!');
            return redirect(route('master.periode.index'));
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
        $data = Periode::findOrFail($id);

        return view('master.periode.form', compact('data'));
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'name_site' => 'required',
            'location' => 'required',
        ]);

        $site = Site::findOrFail($id);

        $site->update([
            'name_site' => $request->name_site,
            'location' => $request->location,
            // 'location' => Str::slug($request->name_site)
        ]);

        if ($site) {
            Alert::success('Berhasil!', 'Data site berhasil diupdate!');
            return redirect(route('master.periode.index'));
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
        $site = Site::findOrFail($id);
        $site->delete();

        if ($site) {
            Alert::success('Berhasil!', 'Data site berhasil dihapus!');
            return redirect(route('master.periode.index'));
        } else {
            Alert::error('Gagal!', 'Data site tidak dapat dihapus!');
            return redirect(route('master.periode.index'));
        }
    }
}
