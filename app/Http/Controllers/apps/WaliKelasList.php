<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WaliKelas;

class WaliKelasList extends Controller
{
    public function index()
    {
        return view('content.apps.app-wali-kelas-list');
    }

    public function data(Request $request)
    {
        $wali = WaliKelas::with(['guru', 'kelas', 'tahunAjaran'])->get();
        $data = $wali->map(function($item) {
            return [
                'id' => $item->id,
                'nama' => $item->guru ? $item->guru->nama : '',
                'nip' => $item->guru ? $item->guru->nip : '',
                'kelas' => $item->kelas,
                'kelas_id' => $item->kelas_id,
                'tahun_ajaran' => $item->tahunAjaran ? $item->tahunAjaran->tahun : '',
                'status' => $item->status,
                'action' => '',
            ];
        });
        return response()->json(['data' => $data]);
    }

    public function getbyid($id)
    {
        $wali = WaliKelas::with(['guru', 'kelas', 'tahunAjaran'])->find($id);
        if ($wali) {
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $wali->id,
                    'guru_id' => $wali->guru_id,
                    'kelas_id' => $wali->kelas_id,
                    'tahun_ajaran_id' => $wali->tahun_ajaran_id,
                    'nama' => $wali->guru ? $wali->guru->nama : '',
                    'nip' => $wali->guru ? $wali->guru->nip : '',
                    'kelas' => $wali->kelas ? [
                        'id' => $wali->kelas->id,
                        'nama_kelas' => $wali->kelas->nama_kelas
                    ] : null,
                    'tahun_ajaran' => $wali->tahunAjaran ? $wali->tahunAjaran->tahun : '',
                    'status' => $wali->status
                ]
            ]);
        } else {
            return response()->json(['success' => false, 'error' => 'Data tidak ditemukan']);
        }
    }

    public function store(Request $request)
    {
        try {
            $wali = WaliKelas::create($request->all());
            return response()->json(['success' => true, 'data' => $wali]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function updatebyid(Request $request)
    {
        try {
            $wali = WaliKelas::find($request->id);
            if (!$wali) {
                return response()->json(['success' => false, 'error' => 'Data tidak ditemukan']);
            }
            $wali->update($request->all());
            return response()->json(['success' => true, 'data' => $wali]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function deletebyid(Request $request)
    {
        try {
            $wali = WaliKelas::find($request->id);
            if (!$wali) {
                return response()->json(['success' => false, 'error' => 'Data tidak ditemukan']);
            }
            $wali->delete();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }
} 