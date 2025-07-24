<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccountSettingsSecurity extends Controller
{
  public function index()
  {
    return view('content.pages.pages-account-settings-security');
  }

  public function changePassword(Request $request)
  {
    $request->validate([
      'currentPassword' => 'required|min:4',
      'newPassword' => 'required|min:4|confirmed',
    ], [
      'newPassword.confirmed' => 'Konfirmasi password tidak cocok.'
    ]);

    $user = auth()->user();
    if (!\Hash::check($request->currentPassword, $user->password)) {
      return response()->json(['message' => 'Password lama salah.'], 422);
    }

    $user->password = bcrypt($request->newPassword);
    $user->save();

    return response()->json(['message' => 'Password berhasil diubah.']);
  }
}
