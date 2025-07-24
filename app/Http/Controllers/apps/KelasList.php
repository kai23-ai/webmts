<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kelas;
use Illuminate\Support\Facades\Validator;

class KelasList extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $kelas = Kelas::all();
            $data = [];
            foreach ($kelas as $kls) {
                $data[] = [
                    'id'         => $kls->id,
                    'nama_kelas' => $kls->nama_kelas,
                    'action'     => '',
                ];
            }
            return response()->json(['data' => $data]);
        }
        return view('content.apps.app-kelas-list');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_kelas' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }
        Kelas::create($request->only('nama_kelas'));
        return response()->json(['success' => true]);
    }

    public function update(Request $request)
    {
        $kelas = Kelas::find($request->id);
        if (!$kelas) {
            return response()->json(['error' => 'Kelas tidak ditemukan'], 404);
        }
        $kelas->update($request->all());
        return response()->json(['success' => true]);
    }

    public function destroy(Request $request)
    {
        $kelas = Kelas::find($request->id);
        if (!$kelas) {
            return response()->json(['error' => 'Kelas tidak ditemukan'], 404);
        }
        $kelas->delete();
        return response()->json(['success' => true]);
    }

    public function getById($id)
    {
        $kelas = Kelas::find($id);
        if ($kelas) {
            return response()->json(['success' => true, 'data' => $kelas]);
        } else {
            return response()->json(['success' => false, 'error' => 'Data tidak ditemukan']);
        }
    }

    public function updateById(Request $request)
    {
        $kelas = Kelas::find($request->id);
        if (!$kelas) {
            return response()->json(['success' => false, 'error' => 'Kelas tidak ditemukan'], 404);
        }
        $kelas->update($request->all());
        return response()->json(['success' => true]);
    }

    public function deleteById(Request $request)
    {
        $kelas = Kelas::find($request->id);
        if (!$kelas) {
            return response()->json(['success' => false, 'error' => 'Kelas tidak ditemukan'], 404);
        }
        $kelas->delete();
        return response()->json(['success' => true]);
    }

    public function data()
    {
        $kelas = Kelas::all();
        $data = [];
        foreach ($kelas as $kls) {
            $data[] = [
                'id'         => $kls->id,
                'nama_kelas' => $kls->nama_kelas,
                'action'     => '',
            ];
        }
        return response()->json(['data' => $data]);
    }
} 