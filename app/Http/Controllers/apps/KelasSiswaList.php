<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KelasSiswa;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Support\Facades\Validator;

class KelasSiswaList extends Controller
{
    public function list(Request $request)
    {
        $data = KelasSiswa::with(['kelas', 'siswa', 'tahunAjaran'])->get()->map(function($item) {
            return [
                'id' => $item->id,
                'kelas_nama' => $item->kelas ? $item->kelas->nama_kelas : '-',
                'siswa_nama' => $item->siswa ? $item->siswa->nama : '-',
                'tahun_ajaran_nama' => $item->tahunAjaran ? $item->tahunAjaran->tahun : '-',
                'tahun_ajaran_id' => $item->tahun_ajaran_id,
                'status' => $item->status,
                'action' => ''
            ];
        });
        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kelas_id' => 'required|exists:kelas,id',
            'siswa_id' => 'required|exists:siswa,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'status' => 'nullable|in:aktif,tidak',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }
        $kelasSiswa = new KelasSiswa();
        $kelasSiswa->kelas_id = $request->kelas_id;
        $kelasSiswa->siswa_id = $request->siswa_id;
        $kelasSiswa->tahun_ajaran_id = $request->tahun_ajaran_id;
        $kelasSiswa->status = $request->status ?? 'aktif';
        $kelasSiswa->save();
        return response()->json(['success' => true, 'data' => $kelasSiswa]);
    }

    public function update(Request $request)
    {
        $kelasSiswa = KelasSiswa::find($request->id);
        if (!$kelasSiswa) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }
        $validator = Validator::make($request->all(), [
            'kelas_id' => 'required|exists:kelas,id',
            'siswa_id' => 'required|exists:siswa,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'status' => 'nullable|in:aktif,tidak',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }
        $kelasSiswa->kelas_id = $request->kelas_id;
        $kelasSiswa->siswa_id = $request->siswa_id;
        $kelasSiswa->tahun_ajaran_id = $request->tahun_ajaran_id;
        $kelasSiswa->status = $request->status ?? 'aktif';
        $kelasSiswa->save();
        return response()->json(['success' => true, 'data' => $kelasSiswa]);
    }

    public function delete(Request $request)
    {
        $kelasSiswa = KelasSiswa::find($request->id);
        if (!$kelasSiswa) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }
        $kelasSiswa->delete();
        return response()->json(['success' => true]);
    }

    public function getById($id)
    {
        $item = KelasSiswa::with(['kelas', 'siswa', 'tahunAjaran'])->find($id);
        if ($item) {
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $item->id,
                    'kelas' => $item->kelas ? [
                        'id' => $item->kelas->id,
                        'nama_kelas' => $item->kelas->nama_kelas
                    ] : null,
                    'siswa' => $item->siswa ? [
                        'id' => $item->siswa->id,
                        'nama' => $item->siswa->nama
                    ] : null,
                    'tahunAjaran' => $item->tahunAjaran ? [
                        'id' => $item->tahunAjaran->id,
                        'tahun' => $item->tahunAjaran->tahun
                    ] : null,
                    'status' => $item->status
                ]
            ]);
        } else {
            return response()->json(['success' => false, 'error' => 'Data tidak ditemukan']);
        }
    }
} 