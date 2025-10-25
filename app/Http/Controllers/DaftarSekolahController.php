<?php

namespace App\Http\Controllers;

use App\Models\DaftarSekolah;
use Illuminate\Http\Request;

class DaftarSekolahController extends Controller
{
    public function index()
    {
        return view('admin.admin-sekolahlist');
    }
    public function getdatasekolah(Request $request)
    {
        $data = DaftarSekolah::query();
        if ($request->has('search') && !empty($request->search['value'])) {
            $search = $request->search['value'];
            $data->where(function ($query) use ($search) {
                $query->where('id', 'like', '%' . $search . '%')
                    ->orWhere('vnpsn_sekolah', 'like', '%' . $search . '%')
                    ->orWhere('vnama_sekolah', 'like', '%' . $search . '%');
            });
        }

        $result = DataTables()->of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $edit = '<button class="btn btn-sm btn-warning edit-button" data-id="' . $row->id . '">Edit</button>';
                $delete = '<form action="' . url('/sekolah/delete/' . $row->id) . '" method="POST" style="display:inline;">
                ' . csrf_field() . '
                ' . method_field('DELETE') . '
                    <button type="submit" class="btn btn-sm btn-danger delete-button">Hapus</button>
                </form>';
                return $edit . ' ' . $delete;
            })
            ->rawColumns(['action'])
            ->toJson();

        return $result;
    }
}
