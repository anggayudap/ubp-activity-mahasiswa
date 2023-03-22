<?php

namespace App\Http\Controllers\Master;

use DataTables;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use RealRashid\SweetAlert\Facades\Alert;

class RoleUserController extends Controller {
    public function index(Request $request) {
        if ($request->ajax()) {
            $data = Role::select(['id', 'name', 'guard_name']);
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div class="dropdown">
                        <a class="btn btn-sm btn-icon px-0" data-toggle="dropdown" aria-expanded="false"><i data-feather="menu"></i></a>
                        <div class="dropdown-menu dropdown-menu-right" style="">
                        <em class="dropdown-item">No action required.</em>
                        </div>
                        </div>';
                    return $btn;
                })
                ->editColumn('name', function (Role $role) {
                    return Str::ucfirst($role->name);
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
            'guard_name' => 'required',
        ]);

        $post = Role::create([
            'name' => $request->name,
            'guard_name' => $request->guard_name,
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
        $data = Role::findOrFail(Crypt::decrypt($id));

        return view('master.role.form', compact('data'));
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'name' => 'required',
            'guard_name' => 'required',
        ]);

        $role = Role::findOrFail($id);

        $role->update([
            'name' => $request->name,
            'guard_name' => $request->guard_name,
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
        $role = Role::findOrFail($id);
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
