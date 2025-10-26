<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\DaftarSekolah;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.admin-index');
    }

    public function userlist()
    {
        $sekolahs = DaftarSekolah::orderBy('vnama_sekolah', 'asc')->get();
        return view('admin.admin-userlist', compact('sekolahs'));
    }

    public function getusertable(Request $request)
    {
        if ($request->ajax()) {
            $users = User::with('sekolah')->select('users.*')->orderBy('id', 'desc');

            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('DT_RowIndex', function ($user) {
                    return '';
                })
                ->addColumn('status', function ($user) {
                    return $user->login_token
                        ? '<span class="badge bg-success" style="cursor:pointer" onclick="handleStatusClick(' . $user->id . ', this)">Online</span>'
                        : '<span class="badge bg-secondary">Offline</span>';
                })
                ->addColumn('action', function ($user) {
                    $detail = '<button class="btn btn-sm btn-primary" onclick="showUserDetail(' . $user->id . ')">Detail</button>';
                    $edit = '<button class="btn btn-sm btn-warning" onclick="editUser(' . $user->id . ')">Edit</button>';
                    return $detail . ' ' . $edit;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return abort(404);
    }

    // Method store, edit, update, detail tetap sama seperti sebelumnya
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:users,username',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:5',
                'role' => 'required|string|in:Admin,Operator',
                'daftar_sekolahs_id' => 'nullable|exists:daftar_sekolahs,id',
            ]);

            if ($request->role === 'Operator' && !$request->daftar_sekolahs_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Operator wajib memilih asal sekolahan.'
                ], 422);
            }

            $user = User::create([
                'nama' => $request->nama,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'daftar_sekolahs_id' => $request->role === 'Operator' ? $request->daftar_sekolahs_id : null,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'User berhasil ditambahkan.',
                'data' => $user
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }


    public function edit($id)
    {
        $user = User::with('sekolah')->findOrFail($id);
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|string|in:Admin,Operator',
            'daftar_sekolahs_id' => 'nullable|exists:daftar_sekolahs,id',
            'password' => 'nullable|string|min:5',
        ]);

        if ($request->role === 'Operator' && !$request->daftar_sekolahs_id) {
            return response()->json([
                'success' => false,
                'message' => 'Operator wajib memilih asal sekolahan.'
            ], 422);
        }

        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->role = $request->role;

        // Reset daftar_sekolahs_id jika bukan Operator
        if ($request->role !== 'Operator') {
            $user->daftar_sekolahs_id = null;
        } else {
            $user->daftar_sekolahs_id = $request->daftar_sekolahs_id;
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'User berhasil diperbarui.'
        ]);
    }

    public function detail($id)
    {
        $user = User::with('sekolah')->findOrFail($id);

        return response()->json([
            'nama' => $user->nama,
            'username' => $user->username,
            'email' => $user->email,
            'role' => $user->role,
            'sekolah' => $user->sekolah ? $user->sekolah->vnama_sekolah . ' (' . $user->sekolah->vnpsn_sekolah . ')' : '-',
            'status' => $user->login_token ? 'Online' : 'Offline',
            'created_at' => $user->created_at->format('d M Y H:i'),
        ]);
    }
}
