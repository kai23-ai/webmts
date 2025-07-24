<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserProfile extends Controller
{
  public function index()
  {
    return view('content.pages.pages-profile-user');
  }

  public function update(Request $request)
  {
    $user = auth()->user();
    $profile = $user->guru ?? $user->siswa ?? null;
    if (!$profile) {
      return response()->json(['success' => false, 'message' => 'Profile tidak ditemukan'], 404);
    }

    $data = $request->only(['nama', 'email', 'alamat', 'telepon', 'notelp', 'jenis_kelamin', 'status']);
    // Normalisasi field telepon/notelp
    if (isset($data['telepon'])) {
      $data['notelp'] = $data['telepon'];
      unset($data['telepon']);
    }
    // Handle upload foto
    if ($request->hasFile('foto')) {
      $file = $request->file('foto');
      $filename = uniqid('foto_') . '.' . $file->getClientOriginalExtension();
      $file->move(public_path('assets/img/avatars'), $filename);
      $data['foto'] = $filename;
    }
    $profile->update($data);
    return response()->json(['success' => true, 'message' => 'Profil berhasil diperbarui']);
  }
}
