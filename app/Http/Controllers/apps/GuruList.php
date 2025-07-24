<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Guru;
use Illuminate\Support\Facades\Validator;

class GuruList extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $gurus = Guru::all();
            $data = [];
            foreach ($gurus as $guru) {
                $data[] = [
                    'nip'           => $guru->nip,
                    'nama'          => $guru->nama,
                    'jenis_kelamin' => $guru->jenis_kelamin,
                    'alamat'        => $guru->alamat,
                    'status'        => $guru->status,
                    // tambahkan kolom lain jika perlu
                ];
            }
            return response()->json(['data' => $data]);
        }
        return view('content.apps.app-guru-list');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nip' => 'required|unique:guru,nip',
            'nama' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'required',
            'status' => 'required|in:aktif,tidak,lulus',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }
        Guru::create($request->all());
        return response()->json(['success' => true]);
    }

    public function update(Request $request)
    {
        $guru = Guru::find($request->id);
        if (!$guru) {
            return response()->json(['error' => 'Guru tidak ditemukan'], 404);
        }
        $guru->update($request->all());
        return response()->json(['success' => true]);
    }

    public function destroy(Request $request)
    {
        $guru = Guru::find($request->id);
        if (!$guru) {
            return response()->json(['error' => 'Guru tidak ditemukan'], 404);
        }
        $guru->delete();
        return response()->json(['success' => true]);
    }

    public function getByNip($nip)
    {
        $guru = \App\Models\Guru::where('nip', $nip)->first();
        if ($guru) {
            return response()->json(['success' => true, 'data' => $guru]);
        } else {
            return response()->json(['success' => false, 'error' => 'Data tidak ditemukan']);
        }
    }

    public function updateByNip(Request $request)
    {
        $guru = \App\Models\Guru::where('nip', $request->nip)->first();
        if (!$guru) {
            return response()->json(['success' => false, 'error' => 'Guru tidak ditemukan'], 404);
        }
        $guru->update($request->all());
        return response()->json(['success' => true]);
    }

    public function deleteByNip(Request $request)
    {
        $guru = \App\Models\Guru::where('nip', $request->nip)->first();
        if (!$guru) {
            return response()->json(['success' => false, 'error' => 'Guru tidak ditemukan'], 404);
        }
        $guru->delete();
        return response()->json(['success' => true]);
    }

    public function data() {
        $gurus = Guru::all();
        $data = [];
        foreach ($gurus as $guru) {
            $data[] = [
                'id'            => $guru->id, // tambahkan id
                'nip'           => $guru->nip,
                'nama'          => $guru->nama,
                'jenis_kelamin' => $guru->jenis_kelamin,
                'alamat'        => $guru->alamat,
                'status'        => $guru->status,
            ];
        }
        return response()->json(['data' => $data]);
    }
} 