<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.admin-index');
    }

    public function userlist()
    {
        return view('admin.admin-userlist');
    }
    public function getusertable(Request $request)
    {
        $users = User::with('sekolah')->orderBy('id', 'desc');

        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('status', function ($user) {
                return $user->login_token
                    ? '<span class="badge bg-success" style="cursor:pointer" onclick="handleStatusClick(' . $user->id . ', this)">Online</span>'
                    : '<span class="badge bg-secondary">Offline</span>';
            })
            ->addColumn('sekolah', function ($user) {
                return $user->role === 'Operator' && $user->sekolah ? $user->sekolah->vnama_kecamatan : '-';
            })
            ->addColumn('action', function ($user) {
                $detail = '<button class="btn btn-sm btn-primary" onclick="showUserDetail(' . $user->id . ')">Detail</button>';
                $edit = '<button class="btn btn-sm btn-warning" onclick="editUser(' . $user->id . ')">Edit</button>';
                return $detail . ' ' . $edit;
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }
}
