<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use Illuminate\Http\Request;

class KecamatanController extends Controller
{
    public function index()
    {
        return view('admin.admin-kecamatanlist');
    }
    public function getdatakecamatan(Request $request)
    {
        $data = Kecamatan::query();
        if ($request->has('search') && !empty($request->search['value'])) {
            $search = $request->search['value'];
            $data->where(function ($query) use ($search) {
                $query->where('id', 'like', '%' . $search . '%')
                    ->orWhere('vnama_kecamatan', 'like', '%' . $search . '%');
            });
        }

        $result = DataTables()->of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $edit = '<button class="btn btn-sm btn-warning edit-button" data-id="' . $row->id . '">Edit</button>';
                $delete = '<form action="' . url('/kecamatan/delete/' . $row->id) . '" method="POST" style="display:inline;">
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

    public function storekecamatan(Request $request)
    {
        $request->validate([
            'vnama_kecamatan' => 'required|string|max:255',
        ]);

        Kecamatan::create([
            'vnama_kecamatan' => $request->vnama_kecamatan,
        ]);

        return redirect()->back()->with('success', 'Main Dealer berhasil ditambahkan!');
    }
}
