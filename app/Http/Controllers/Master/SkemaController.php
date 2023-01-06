<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Skema;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Crypt;
use RealRashid\SweetAlert\Facades\Alert;

class SkemaController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Skema::select(['id', 'nama_skema', 'deskripsi_skema', 'aktif']);
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn =
                        '<div class="dropdown">
                        <a class="btn btn-sm btn-icon px-0" data-toggle="dropdown" aria-expanded="false"><i data-feather="more-vertical"></i></a>
                        <div class="dropdown-menu dropdown-menu-right" style="">
                        <a href="' .
                        route('master.skema.edit', Crypt::encrypt($row->id)) .
                        '" class="dropdown-item"><i data-feather="edit"></i> Edit</a>
                        <form action="' .
                        route('master.skema.destroy', [$row->id]) .
                        '" method="POST" id="form-delete-' .
                        $row->id .
                        '" style="display: inline">
                        ' .
                        csrf_field() .
                        '
                        ' .
                        method_field('DELETE') .
                        '
                        <a href="#" onclick="submit_delete(' .
                        $row->id .
                        ')" class="dropdown-item"><i data-feather="trash-2"></i> Delete</a>
                        </form>
                        </div>
                        </div>';
                    return $btn;
                })
                ->editColumn('aktif', function (Skema $data) {
                    return trans('serba.status_' . $data->aktif);
                })
                ->rawColumns(['aktif', 'action'])
                ->removeColumn('id')
                ->make(true);
        }

        return view('master.skema.index');
    }

    public function create()
    {
        return view('master.skema.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_skema' => 'required|string',
            'deskripsi_skema' => 'nullable|string',
            'aktif' => 'required|in:0,1',
        ]);

        $post = Skema::create([
            'nama_skema' => $request->nama_skema,
            'deskripsi_skema' => $request->deskripsi_skema,
            'aktif' => $request->aktif,
        ]);

        if ($post) {
            Alert::success('Berhasil!', 'Data skema berhasil dibuat!');
            return redirect(route('master.skema.index'));
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'error' => 'Some problem occurred, please try again',
                ]);
        }
    }

    public function show(Skema $skema)
    {
        //
    }

    public function edit($id)
    {
        $data = Skema::findOrFail(Crypt::decrypt($id));

        return view('master.skema.form', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nama_skema' => 'required|string',
            'deskripsi_skema' => 'nullable|string',
            'aktif' => 'required|in:0,1',
        ]);

        $update = Skema::findOrFail($id);

        $update->update([
            'nama_skema' => $request->nama_skema,
            'deskripsi_skema' => $request->deskripsi_skema,
            'aktif' => $request->aktif,
        ]);

        if ($update) {
            Alert::success('Berhasil!', 'Data skema berhasil diupdate!');
            return redirect(route('master.skema.index'));
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'error' => 'Some problem occurred, please try again',
                ]);
        }
    }

    public function destroy($id)
    {
        $data = Skema::findOrFail($id);
        $data->delete();

        if ($data) {
            Alert::success('Berhasil!', 'Data skema berhasil dihapus!');
            return redirect(route('master.skema.index'));
        } else {
            Alert::error('Gagal!', 'Data skema tidak dapat dihapus!');
            return redirect(route('master.skema.index'));
        }
    }
}
