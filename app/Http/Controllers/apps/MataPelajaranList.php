<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MataPelajaran;
use Illuminate\Support\Facades\Validator;

class MataPelajaranList extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = MataPelajaran::query();
            if ($request->filled('jenis_mapel')) {
                $query->where('jenis_mapel', $request->jenis_mapel);
            }
            $data = $query->get()->map(function($mp) {
                return [
                    'id'    => $mp->id,
                    'kode_mapel' => $mp->kode_mapel,
                    'nama_mapel'  => $mp->nama_mapel,
                    'jenis_mapel'  => $mp->jenis_mapel,
                    'urutan' => $mp->urutan,
                    'action' => '',
                ];
            });
            return response()->json(['data' => $data]);
        }
        return view('content.apps.app-mata-pelajaran-list');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode_mapel' => 'required|unique:mata_pelajaran,kode_mapel',
            'nama_mapel' => 'required',
            'urutan' => 'required|integer',
            'jenis_mapel' => 'required|in:PAI,UMUM,MULOK',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }
        MataPelajaran::create($request->only('kode_mapel', 'nama_mapel', 'urutan', 'jenis_mapel'));
        return response()->json(['success' => true]);
    }

    public function update(Request $request)
    {
        $mp = MataPelajaran::find($request->id);
        if (!$mp) {
            return response()->json(['error' => 'Mata pelajaran tidak ditemukan'], 404);
        }
        $validator = Validator::make($request->all(), [
            'kode_mapel' => 'required|unique:mata_pelajaran,kode_mapel,' . $mp->id,
            'nama_mapel' => 'required',
            'urutan' => 'required|integer',
            'jenis_mapel' => 'required|in:PAI,UMUM,MULOK',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }
        $mp->update($request->only('kode_mapel', 'nama_mapel', 'urutan', 'jenis_mapel'));
        return response()->json(['success' => true]);
    }

    public function destroy(Request $request)
    {
        $mp = MataPelajaran::find($request->id);
        if (!$mp) {
            return response()->json(['error' => 'Mata pelajaran tidak ditemukan'], 404);
        }
        $mp->delete();
        return response()->json(['success' => true]);
    }

    public function getById($id)
    {
        $mp = MataPelajaran::find($id);
        if ($mp) {
            return response()->json(['success' => true, 'data' => $mp]);
        } else {
            return response()->json(['success' => false, 'error' => 'Data tidak ditemukan']);
        }
    }

    public function updateById(Request $request)
    {
        $mp = MataPelajaran::find($request->id);
        if (!$mp) {
            return response()->json(['success' => false, 'error' => 'Mata pelajaran tidak ditemukan'], 404);
        }
        $mp->update($request->only('nama_mapel', 'urutan'));
        return response()->json(['success' => true]);
    }

    public function deleteById(Request $request)
    {
        $mp = MataPelajaran::find($request->id);
        if (!$mp) {
            return response()->json(['success' => false, 'error' => 'Mata pelajaran tidak ditemukan'], 404);
        }
        $mp->delete();
        return response()->json(['success' => true]);
    }
} 