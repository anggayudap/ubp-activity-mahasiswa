<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\RoleUser;
use App\Models\User;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller {
    public function index(Request $request) {
        if ($request->ajax()) {
            $data = User::select(['id', 'name', 'email', 'role', 'last_login_at']);
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div class="dropdown">
                        <a class="btn btn-sm btn-icon px-0" data-toggle="dropdown" aria-expanded="false"><i data-feather="more-vertical"></i></a>
                        <div class="dropdown-menu dropdown-menu-right" style="">
                        <a href="' . route("master.user.edit", Crypt::encrypt($row->id)) . '" class="dropdown-item"><i data-feather="edit"></i> Edit</a>
                        <form action="' . route("master.user.destroy", [$row->id]) . '" method="POST" id="form-delete-' . $row->id . '" style="display: inline">
                        ' . csrf_field() . '
                        ' . method_field("DELETE") . '
                        <a href="#" onclick="submit_delete(' . $row->id . ')" class="dropdown-item"><i data-feather="trash-2"></i> Delete</a>
                        </form>
                        </div>
                        </div>';
                    return $btn;
                })
                ->editColumn('last_login_at', function (User $user) {
                    return get_date_time($user->last_login_at);
                })
                ->rawColumns(['action'])
                ->removeColumn('id')
                ->make(true);
        }

        return view('master.user.index');
    }

    public function edit($id) {
        $data['user'] = User::findOrFail(Crypt::decrypt($id));
        $data['role'] = RoleUser::all();

        return view('master.user.form', compact('data'));
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'role' => 'required',
        ]);

        $user = User::findOrFail($id);

        $user->update([
            'role' => $request->role,
        ]);

        if ($user) {
            Alert::success('Berhasil!', 'Data user berhasil diupdate!');
            return redirect(route('master.user.index'));
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
        $user = User::findOrFail($id);
        $user->delete();

        if ($user) {
            Alert::success('Berhasil!', 'Data user berhasil dihapus!');
            return redirect(route('master.user.index'));
        } else {
            Alert::error('Gagal!', 'Data user tidak dapat dihapus!');
            return redirect(route('master.user.index'));
        }
    }
}
