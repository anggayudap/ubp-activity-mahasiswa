<?php

namespace App\Http\Controllers\Master;

use DataTables;
use App\Models\Skema;
use App\Models\Review;
use App\Models\SkemaReview;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use RealRashid\SweetAlert\Facades\Alert;

class SkemaController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Skema::select(['id', 'nama_skema', 'deskripsi_skema', 'aktif'])->with(['assigned_review']);
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('jumlah_review', function ($row) {
                    return $row->assigned_review->count();
                })
                ->addColumn('action', function ($row) {
                    $btn =
                        '<div class="dropdown">
                        <a class="btn btn-sm btn-icon px-0" data-toggle="dropdown" aria-expanded="false"><i data-feather="menu"></i></a>
                        <div class="dropdown-menu dropdown-menu-right" style="">
                        <a href="' .
                        route('master.skema.show', [$row->id]) .
                        '" class="dropdown-item"><i data-feather="file-text"></i> Detail</a>
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
        $output['data_review'] = Review::where('aktif', 1)->get();

        return view('master.skema.form', compact('output'));
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
        $output['data'] = Skema::with(['assigned_review'])->findOrFail(Crypt::decrypt($id));
        $output['data_review'] = Review::where('aktif', 1)->get();
        $output['assigned_review'] =  $output['data']->assigned_review->groupBy('review_id'); 
        
        return view('master.skema.form', compact('output'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nama_skema' => 'required|string',
            'deskripsi_skema' => 'nullable|string',
            'aktif' => 'required|in:0,1',
            'review' => 'array|required',
        ]);

        $update = Skema::findOrFail($id);

        $update->update([
            'nama_skema' => $request->nama_skema,
            'deskripsi_skema' => $request->deskripsi_skema,
            'aktif' => $request->aktif,
        ]);

        // store data skema_reviews
        SkemaReview::where('skema_id', $id)->delete();

        $param = [];
        foreach ($request->review as $id_review) {
            $param[] = [
                'skema_id' => $id,
                'review_id' => $id_review,
                'created_at' => Carbon::now(),
            ];
        }
        $store_review = SkemaReview::insert($param);

        if ($update && $store_review) {
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
