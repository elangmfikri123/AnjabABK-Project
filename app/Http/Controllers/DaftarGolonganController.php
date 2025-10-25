<?php

namespace App\Http\Controllers;

use App\Models\DaftarGolongan;
use Illuminate\Http\Request;

class DaftarGolonganController extends Controller
{
    public function index()
    {
        return view('admin.admin-golonganlist');
    }
    public function getdatagolongan(Request $request)
    {
        $data = DaftarGolongan::query();
        if ($request->has('search') && !empty($request->search['value'])) {
            $search = $request->search['value'];
            $data->where(function ($query) use ($search) {
                $query->where('id', 'like', '%' . $search . '%')
                    ->orWhere('vnama_golongan', 'like', '%' . $search . '%');
            });
        }

        $result = DataTables()->of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $edit = '<button class="btn btn-sm btn-warning edit-button" data-id="' . $row->id . '">Edit</button>';
                $delete = '<form action="' . url('/golongan/delete/' . $row->id) . '" method="POST" style="display:inline;">
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
