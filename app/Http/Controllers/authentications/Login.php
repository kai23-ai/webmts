<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Guru;
use App\Models\Siswa;

class Login extends Controller
{
  public function index()
  {
    $pageConfigs = ['myLayout' => 'blank'];
    return view('content.authentications.auth-login', ['pageConfigs' => $pageConfigs]);
  }

  public function authenticate(Request $request)
  {
    $request->validate([
      'role' => 'required|in:admin,guru,siswa',
      'nip_nis' => 'required',
      'password' => 'required|min:4',
    ]);

    $role = $request->input('role');
    $nip_nis = $request->input('nip_nis');
    $password = $request->input('password');

    if ($role === 'admin' || $role === 'guru') {
      // Cek NIP di tabel guru
      $guru = Guru::where('nip', $nip_nis)->first();
      if (!$guru) {
        return back()->withErrors(['login' => 'NIP guru tidak ditemukan'])->withInput();
      }
      $user = User::where('guru_id', $guru->id)->where('role', $role)->first();
      if (!$user) {
        return back()->withErrors(['login' => 'Akun user untuk guru/admin ini tidak ditemukan'])->withInput();
      }
      if (!Hash::check($password, $user->password)) {
        return back()->withErrors(['login' => 'Password salah'])->withInput();
      }
      Auth::login($user);
      if ($role === 'guru') {
        return redirect()->route('dashboard-guru');
      }
      return redirect('/');
    } elseif ($role === 'siswa') {
      $siswa = Siswa::where('no_induk', $nip_nis)->first();
      if (!$siswa) {
        return back()->withErrors(['login' => 'No Induk siswa tidak ditemukan'])->withInput();
      }
      $user = User::where('siswa_id', $siswa->id)->where('role', 'siswa')->first();
      if (!$user) {
        return back()->withErrors(['login' => 'Akun user untuk siswa ini tidak ditemukan'])->withInput();
      }
      if (!Hash::check($password, $user->password)) {
        return back()->withErrors(['login' => 'Password salah'])->withInput();
      }
      Auth::login($user);
      return redirect()->route('dashboard-siswa');
    }

    return back()->withErrors(['login' => 'Role tidak valid'])->withInput();
  }
}
