<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Semester;

class SemesterList extends Controller
{
    public function index()
    {
        return view('content.apps.app-semester-list');
    }

    public function data()
    {
        $data = Semester::all();
        $result = $data->map(function($item) {
            return [
                'id' => $item->id,
                'nama' => $item->nama,
                'status' => $item->status,
                'action' => '',
            ];
        });
        return response()->json(['data' => $result]);
    }

    public function store(Request $request)
    {
        $semester = new Semester();
        $semester->nama = $request->nama;
        $semester->save();
        return response()->json(['success' => true]);
    }

    public function updatebyid(Request $request)
    {
        $semester = Semester::find($request->id);
        if (!$semester) {
            return response()->json(['success' => false, 'error' => 'Data tidak ditemukan']);
        }
        $semester->nama = $request->nama;
        $semester->save();
        return response()->json(['success' => true]);
    }

    public function getbyid($id)
    {
        $semester = Semester::find($id);
        if (!$semester) {
            return response()->json(['success' => false, 'error' => 'Data tidak ditemukan']);
        }
        return response()->json(['success' => true, 'data' => $semester]);
    }

    public function deletebyid(Request $request)
    {
        $semester = Semester::find($request->id);
        if (!$semester) {
            return response()->json(['success' => false, 'error' => 'Data tidak ditemukan']);
        }
        $semester->delete();
        return response()->json(['success' => true]);
    }
} 