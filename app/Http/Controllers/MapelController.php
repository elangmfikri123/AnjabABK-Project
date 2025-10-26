<?php

namespace App\Http\Controllers;

use App\Models\Mapel;
use Illuminate\Http\Request;

class MapelController extends Controller
{
    public function index()
    {
        return view('admin.admin-matapelajaranlist');
    }
    public function getdatamapel(Request $request)
    {
        $data = Mapel::query();
        if ($request->has('search') && !empty($request->search['value'])) {
            $search = $request->search['value'];
            $data->where(function ($query) use ($search) {
                $query->where('id', 'like', '%' . $search . '%')
                    ->orWhere('vnama_mapel', 'like', '%' . $search . '%');
            });
        }

        $result = DataTables()->of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $edit = '<button class="btn btn-sm btn-warning edit-button" data-id="' . $row->id . '">Edit</button>';
                $delete = '<form action="' . url('/matapelajaran/delete/' . $row->id) . '" method="POST" style="display:inline;">
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
    public function storeMapel(Request $request)
    {
        $request->validate([
            'vnama_mapel' => 'required|string|max:255',
        ]);

        Mapel::create([
            'vnama_mapel' => $request->vnama_mapel,
        ]);

        return response()->json(['success' => 'Mata Pelajaran berhasil ditambahkan!']);
    }

    public function editMapel($id)
    {
        $data = Mapel::findOrFail($id);
        return response()->json($data);
    }

    public function updateMapel(Request $request, $id)
    {
        $request->validate([
            'vnama_mapel' => 'required|string|max:255',
        ]);

        $data = Mapel::findOrFail($id);
        $data->update($request->only([
            'vnama_mapel',
        ]));

        return response()->json(['success' => 'Mata Pelajaran berhasil diperbarui!']);
    }

    public function deleteMapel($id)
    {
        $data = Mapel::findOrFail($id);
        $data->delete();
        return response()->json(['success' => 'Mata Pelajaran berhasil dihapus!']);
    }
}
