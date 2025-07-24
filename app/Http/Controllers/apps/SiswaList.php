<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use Illuminate\Support\Facades\DB;

class SiswaList extends Controller
{
    public function index()
    {
        return view('content.apps.app-siswa-list');
    }

    public function data(Request $request)
    {
        $siswa = Siswa::all();
        $data = $siswa->map(function($item) {
            return [
                'id' => $item->id,
                'nama' => $item->nama,
                'nis' => $item->nis,
                'nisn' => $item->nisn,
                'jenis_kelamin' => $item->jenis_kelamin,
                'alamat' => $item->alamat,
                'status' => $item->status,
                'email' => $item->email,
                'notelp' => $item->notelp,
                'foto' => $item->foto,
                'action' => '',
            ];
        });
        return response()->json(['data' => $data]);
    }

    public function getbyid($id)
    {
        $siswa = Siswa::find($id);
        if ($siswa) {
            return response()->json(['success' => true, 'data' => $siswa]);
        } else {
            return response()->json(['success' => false, 'error' => 'Data tidak ditemukan']);
        }
    }

    public function store(Request $request)
    {
        try {
            $siswa = Siswa::create($request->all());
            return response()->json(['success' => true, 'data' => $siswa]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function updatebyid(Request $request)
    {
        try {
            $siswa = Siswa::find($request->id);
            if (!$siswa) {
                return response()->json(['success' => false, 'error' => 'Data tidak ditemukan']);
            }
            $siswa->update($request->all());
            return response()->json(['success' => true, 'data' => $siswa]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function deletebyid(Request $request)
    {
        try {
            $siswa = Siswa::find($request->id);
            if (!$siswa) {
                return response()->json(['success' => false, 'error' => 'Data tidak ditemukan']);
            }
            $siswa->delete();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }
}
