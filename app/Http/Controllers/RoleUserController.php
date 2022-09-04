<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\RoleUser;
use DataTables;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class RoleUserController extends Controller {
    public function index(Request $request) {
        if ($request->ajax()) {
            $data = RoleUser::select(['id', 'name', 'description']);
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div class="dropdown">
                        <a class="btn btn-sm btn-icon px-0" data-toggle="dropdown" aria-expanded="false"><i data-feather="more-vertical"></i></a>
                        <div class="dropdown-menu dropdown-menu-right" style="">
                        <a href="' . route("master.role.edit", $row->id) . '" class="dropdown-item"><i data-feather="edit"></i> Edit</a>
                        <form action="' . route("master.role.destroy", [$row->id]) . '" method="POST" id="form-delete-' . $row->id . '" style="display: inline">
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

        return view('master.role.index');
    }

    public function create() {
        return view('master.role.form');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        $post = RoleUser::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        if ($post) {
            Alert::success('Berhasil!', 'Data role berhasil dibuat!');
            return redirect(route('master.role.index'));
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
        $data = RoleUser::findOrFail($id);

        return view('master.role.form', compact('data'));
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
        ]);

        $role = RoleUser::findOrFail($id);

        $role->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        if ($role) {
            Alert::success('Berhasil!', 'Data role berhasil diupdate!');
            return redirect(route('master.role.index'));
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
        $role = RoleUser::findOrFail($id);
        $role->delete();

        if ($role) {
            Alert::success('Berhasil!', 'Data role berhasil dihapus!');
            return redirect(route('master.role.index'));
        } else {
            Alert::error('Gagal!', 'Data role tidak dapat dihapus!');
            return redirect(route('master.role.index'));
        }
    }
}
