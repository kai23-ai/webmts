<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TahunAjaran;
use Illuminate\Support\Facades\Validator;

class TahunAjaranList extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = TahunAjaran::all()->map(function($ta) {
                return [
                    'id'    => $ta->id,
                    'tahun' => $ta->tahun,
                    'aktif' => $ta->aktif ? '1' : '0',
                    'action' => '',
                ];
            });
            return response()->json(['data' => $data]);
        }
        return view('content.apps.app-tahun-ajaran-list');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tahun' => 'required|unique:tahun_ajaran,tahun',
            'aktif' => 'boolean',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }
        TahunAjaran::create($request->only('tahun', 'aktif'));
        return response()->json(['success' => true]);
    }

    public function update(Request $request)
    {
        $ta = TahunAjaran::find($request->id);
        if (!$ta) {
            return response()->json(['error' => 'Tahun ajaran tidak ditemukan'], 404);
        }
        $ta->update($request->only('tahun', 'aktif'));
        return response()->json(['success' => true]);
    }

    public function destroy(Request $request)
    {
        $ta = TahunAjaran::find($request->id);
        if (!$ta) {
            return response()->json(['error' => 'Tahun ajaran tidak ditemukan'], 404);
        }
        $ta->delete();
        return response()->json(['success' => true]);
    }

    public function getById($id)
    {
        $ta = TahunAjaran::find($id);
        if ($ta) {
            return response()->json(['success' => true, 'data' => $ta]);
        } else {
            return response()->json(['success' => false, 'error' => 'Data tidak ditemukan']);
        }
    }

    public function updateById(Request $request)
    {
        $ta = TahunAjaran::find($request->id);
        if (!$ta) {
            return response()->json(['success' => false, 'error' => 'Tahun ajaran tidak ditemukan'], 404);
        }
        $ta->update($request->only('tahun', 'aktif'));
        return response()->json(['success' => true]);
    }

    public function deleteById(Request $request)
    {
        $ta = TahunAjaran::find($request->id);
        if (!$ta) {
            return response()->json(['success' => false, 'error' => 'Tahun ajaran tidak ditemukan'], 404);
        }
        $ta->delete();
        return response()->json(['success' => true]);
    }

    public function data() {
        $data = TahunAjaran::all(['id', 'tahun']);
        return response()->json(['data' => $data]);
    }
} 