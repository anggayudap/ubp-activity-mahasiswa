<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\Periode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use RealRashid\SweetAlert\Facades\Alert;

class PeriodeController extends Controller {

    public function index(Request $request) {
        if ($request->ajax()) {
            $data = Periode::select(['id', 'periode_awal', 'periode_akhir']);
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div class="dropdown">
                        <a class="btn btn-sm btn-icon px-0" data-toggle="dropdown" aria-expanded="false"><i data-feather="more-vertical"></i></a>
                        <div class="dropdown-menu dropdown-menu-right" style="">
                        <a href="' . route("master.periode.edit", Crypt::encrypt($row->id)) . '" class="dropdown-item"><i data-feather="edit"></i> Edit</a>
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
            'periode_awal' => 'required',
            'periode_akhir' => 'required',
        ]);

        $post = Periode::create([
            'periode_awal' => $request->periode_awal,
            'periode_akhir' => $request->periode_akhir,
        ]);

        if ($post) {
            Alert::success('Berhasil!', 'Data periode berhasil dibuat!');
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
        $data = Periode::findOrFail(Crypt::decrypt($id));

        return view('master.periode.form', compact('data'));
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'periode_awal' => 'required',
            'periode_akhir' => 'required',
        ]);

        $site = Periode::findOrFail($id);

        $site->update([
            'periode_awal' => $request->periode_awal,
            'periode_akhir' => $request->periode_akhir,
        ]);

        if ($site) {
            Alert::success('Berhasil!', 'Data periode berhasil diupdate!');
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
        $periode = Periode::findOrFail($id);
        $periode->delete();

        if ($periode) {
            Alert::success('Berhasil!', 'Data periode berhasil dihapus!');
            return redirect(route('master.periode.index'));
        } else {
            Alert::error('Gagal!', 'Data periode tidak dapat dihapus!');
            return redirect(route('master.periode.index'));
        }
    }
}
