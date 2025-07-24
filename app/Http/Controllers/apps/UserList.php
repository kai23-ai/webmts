<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserList extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $users = \DB::table('users')
        ->leftJoin('siswa', 'users.siswa_id', '=', 'siswa.id')
        ->leftJoin('guru', 'users.guru_id', '=', 'guru.id')
        ->select(
          'users.id',
          'users.role',
          \DB::raw('COALESCE(siswa.nama, guru.nama, "-") as nama'),
          \DB::raw('COALESCE(siswa.status, guru.status, "-") as status')
        )
        ->get();
      return response()->json(['data' => $users]);
    }
    return view('content.apps.app-user-list');
  }

  public function store(Request $request)
  {
    $validator = Validator::make($request->all(), [
      //'nama' => 'required', // Tidak perlu validasi nama di tabel users
      'role' => 'required',
      'password' => 'required|min:8|confirmed',
      // status dihapus
    ]);
    if ($validator->fails()) {
      return response()->json(['error' => $validator->errors()->first()], 422);
    }
    $user = new User();
    //$user->name = $request->nama; // Hapus kolom name
    $user->role = $request->role;
    $user->password = Hash::make($request->password);
    // handle ref_id (guru_id/siswa_id) jika ada
    if ($request->role === 'guru' || $request->role === 'admin') {
      $user->guru_id = $request->ref_id;
    } else if ($request->role === 'siswa') {
      $user->siswa_id = $request->ref_id;
    }
    //$user->status = $request->status ?? 'aktif'; // dihapus
    $user->save();
    return response()->json(['success' => true, 'data' => $user]);
  }

  public function update(Request $request)
  {
    $user = User::find($request->id);
    if (!$user) {
      return response()->json(['error' => 'User tidak ditemukan'], 404);
    }
    $validator = Validator::make($request->all(), [
      //'nama' => 'required', // Tidak perlu validasi nama di tabel users
      'role' => 'required',
      'password' => 'nullable|min:8|confirmed',
      // status dihapus
    ]);
    if ($validator->fails()) {
      return response()->json(['error' => $validator->errors()->first()], 422);
    }
    //$user->name = $request->nama; // Hapus kolom name
    $user->role = $request->role;
    // handle ref_id (guru_id/siswa_id) jika ada
    if ($request->role === 'guru' || $request->role === 'admin') {
      $user->guru_id = $request->ref_id;
      $user->siswa_id = null;
    } else if ($request->role === 'siswa') {
      $user->siswa_id = $request->ref_id;
      $user->guru_id = null;
    }
    //$user->status = $request->status ?? 'aktif'; // dihapus
    if ($request->filled('password')) {
      $user->password = Hash::make($request->password);
    }
    $user->save();
    return response()->json(['success' => true, 'data' => $user]);
  }

  public function getById($id)
  {
    $user = \DB::table('users')
      ->leftJoin('siswa', 'users.siswa_id', '=', 'siswa.id')
      ->leftJoin('guru', 'users.guru_id', '=', 'guru.id')
      ->select(
        'users.id',
        'users.role',
        'users.guru_id',
        'users.siswa_id',
        \DB::raw('COALESCE(siswa.nama, guru.nama, "-") as nama')
      )
      ->where('users.id', $id)
      ->first();

    if ($user) {
      return response()->json(['success' => true, 'data' => $user]);
    } else {
      return response()->json(['success' => false, 'error' => 'User tidak ditemukan']);
    }
  }

  public function delete(Request $request)
  {
    $user = \App\Models\User::find($request->id);
    if (!$user) {
      return response()->json(['success' => false, 'error' => 'User tidak ditemukan']);
    }
    $user->delete();
    return response()->json(['success' => true]);
  }
}
