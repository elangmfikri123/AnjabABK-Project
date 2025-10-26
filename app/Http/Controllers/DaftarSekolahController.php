<?php

namespace App\Http\Controllers;

use App\Models\DaftarSekolah;
use App\Models\Kecamatan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DaftarSekolahController extends Controller
{
    public function index()
    {
        $kecamatans = Kecamatan::all(); // untuk dropdown
        return view('admin.admin-sekolahlist', compact('kecamatans'));
    }

    public function getdatasekolah(Request $request)
    {
        $data = DaftarSekolah::with('kecamatan');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('kecamatan', function ($row) {
                return $row->kecamatan ? $row->kecamatan->vnama_kecamatan : '-';
            })
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
            ->make(true);
    }

    public function storesekolah(Request $request)
    {
        $request->validate([
            'vnpsn_sekolah' => 'required|string|max:255',
            'vnama_sekolah' => 'required|string|max:255',
            'kecamatans_id' => 'required|exists:kecamatans,id',
        ]);

        DaftarSekolah::create([
            'vnpsn_sekolah' => $request->vnpsn_sekolah,
            'vnama_sekolah' => $request->vnama_sekolah,
            'kecamatans_id' => $request->kecamatans_id,
        ]);

        return response()->json(['success' => 'Sekolah berhasil ditambahkan!']);
    }

    public function editSekolah($id)
    {
        $data = DaftarSekolah::with('kecamatan')->findOrFail($id);
        $kecamatans = Kecamatan::all();
        return response()->json(['data' => $data, 'kecamatans' => $kecamatans]);
    }

    public function updateSekolah(Request $request, $id)
    {
        $request->validate([
            'vnpsn_sekolah' => 'required|string|max:255',
            'vnama_sekolah' => 'required|string|max:255',
            'kecamatans_id' => 'required|exists:kecamatans,id',
        ]);

        $data = DaftarSekolah::findOrFail($id);
        $data->update($request->only(['vnpsn_sekolah', 'vnama_sekolah', 'kecamatans_id']));

        return response()->json(['success' => 'Sekolah berhasil diperbarui!']);
    }

    public function deleteSekolah($id)
    {
        $data = DaftarSekolah::findOrFail($id);
        $data->delete();
        return response()->json(['success' => 'Sekolah berhasil dihapus!']);
    }
}
