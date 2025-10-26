<?php

namespace App\Http\Controllers;

use App\Models\DaftarJabatan;
use Illuminate\Http\Request;

class DataJabatanController extends Controller
{
    public function index()
    {
        return view('admin.admin-jabatanlist');
    }
    public function getdatajabatan(Request $request)
    {
        $data = DaftarJabatan::query();
        if ($request->has('search') && !empty($request->search['value'])) {
            $search = $request->search['value'];
            $data->where(function ($query) use ($search) {
                $query->where('id', 'like', '%' . $search . '%')
                    ->orWhere('vnama_jabatan', 'like', '%' . $search . '%')
                    ->orWhere('vkelas_jabatan', 'like', '%' . $search . '%');
            });
        }

        $result = DataTables()->of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $edit = '<button class="btn btn-sm btn-warning edit-button" data-id="' . $row->id . '">Edit</button>';
                $delete = '<form action="' . url('/jabatan/delete/' . $row->id) . '" method="POST" style="display:inline;">
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
    public function storeJabatan(Request $request)
    {
        $request->validate([
            'vnama_jabatan' => 'required|string|max:255',
            'vkelas_jabatan' => 'required|string|max:255',
        ]);

        DaftarJabatan::create([
            'vnama_jabatan' => $request->vnama_jabatan,
            'vkelas_jabatan' => $request->vkelas_jabatan,
        ]);

        return response()->json(['success' => 'Sekolah berhasil ditambahkan!']);
    }

    public function editJabatan($id)
    {
        $data = DaftarJabatan::findOrFail($id);
        return response()->json($data);
    }

    public function updateJabatan(Request $request, $id)
    {
        $request->validate([
            'vnama_jabatan' => 'required|string|max:255',
            'vkelas_jabatan' => 'required|string|max:255',
        ]);

        $data = DaftarJabatan::findOrFail($id);
        $data->update($request->only([
            'vnama_jabatan', 
            'vkelas_jabatan',
        ]));

        return response()->json(['success' => 'Jabatan berhasil diperbarui!']);
    }

    public function deleteJabatan($id)
    {
        $data = DaftarJabatan::findOrFail($id);
        $data->delete();
        return response()->json(['success' => 'Jabatan berhasil dihapus!']);
    }
}
