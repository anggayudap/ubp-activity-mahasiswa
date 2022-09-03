<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KegiatanController extends Controller {
    
    public function index(Request $request) {
        if ($request->ajax()) {
            $data = Kegiatan::select(['id', 'name', 'code', 'cost_center']);
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div class="dropdown">
                    <a class="btn btn-sm btn-icon px-0" data-toggle="dropdown" aria-expanded="false"><i data-feather="more-vertical"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" style="">
                    <a href="' . route("master.departement.edit", $row->id) . '" class="dropdown-item"><i data-feather="edit"></i> Edit</a>
                    <form action="' . route("master.departement.destroy", [$row->id]) . '" method="POST" id="form-delete-' . $row->id . '" style="display: inline">
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

        return view('kegiatan.index');
    }

    public function create() {
        return view('kegiatan.form');
    }

   
    public function store(Request $request) {
        //
    }

    
    public function show($id) {
        //
    }

    
    public function edit($id) {
        //
    }

    
    public function update(Request $request, $id) {
        //
    }

    
    public function destroy($id) {
        //
    }
}
