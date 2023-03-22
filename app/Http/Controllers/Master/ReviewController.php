<?php

namespace App\Http\Controllers\Master;

use DataTables;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use RealRashid\SweetAlert\Facades\Alert;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Review::select(['id', 'teks_review', 'aktif']);
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn =
                        '<div class="dropdown">
                        <a class="btn btn-sm btn-icon px-0" data-toggle="dropdown" aria-expanded="false"><i data-feather="menu"></i></a>
                        <div class="dropdown-menu dropdown-menu-right" style="">
                        <a href="' .
                        route('master.review.edit', Crypt::encrypt($row->id)) .
                        '" class="dropdown-item"><i data-feather="edit"></i> Edit</a>
                        <form action="' .
                        route('master.review.destroy', [$row->id]) .
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
                ->editColumn('aktif', function (Review $data) {
                    return trans('serba.status_' . $data->aktif);
                })
                ->rawColumns(['aktif', 'action'])
                ->removeColumn('id')
                ->make(true);
        }

        return view('master.review.index');
    }

    public function create()
    {
        return view('master.review.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'teks_review' => 'required|string',
            'deskripsi_review' => 'nullable|string',
            'aktif' => 'required|in:0,1',
        ]);

        $post = Review::create([
            'teks_review' => $request->teks_review,
            'deskripsi_review' => $request->deskripsi_review,
            'aktif' => $request->aktif,
        ]);

        if ($post) {
            Alert::success('Berhasil!', 'Data review kompetisi berhasil dibuat!');
            return redirect(route('master.review.index'));
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'error' => 'Some problem occurred, please try again',
                ]);
        }
    }

    public function show(Review $review)
    {
        //
    }

    public function edit($id)
    {
        $data = Review::findOrFail(Crypt::decrypt($id));

        return view('master.review.form', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'teks_review' => 'required|string',
            'deskripsi_review' => 'nullable|string',
            'aktif' => 'required|in:0,1',
        ]);

        $update = Review::findOrFail($id);

        $update->update([
            'teks_review' => $request->teks_review,
            'deskripsi_review' => $request->deskripsi_review,
            'aktif' => $request->aktif,
        ]);

        if ($update) {
            Alert::success('Berhasil!', 'Data review kompetisi berhasil diupdate!');
            return redirect(route('master.review.index'));
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
        $data = Review::findOrFail($id);
        $data->delete();

        if ($data) {
            Alert::success('Berhasil!', 'Data review kompetisi berhasil dihapus!');
            return redirect(route('master.review.index'));
        } else {
            Alert::error('Gagal!', 'Data review kompetisi tidak dapat dihapus!');
            return redirect(route('master.review.index'));
        }
    }
}
