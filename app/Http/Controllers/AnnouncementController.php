<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $announcements = \App\Models\Announcement::all();
        return view('content.apps.app-pengumuman-list', compact('announcements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $announcement = \App\Models\Announcement::findOrFail($id);
        return response()->json(['success' => true, 'data' => $announcement]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $announcement = \App\Models\Announcement::findOrFail($id);
        $announcement->update($request->only(['judul', 'isi', 'role', 'status']));
        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function data()
    {
        $data = \App\Models\Announcement::all();
        return response()->json(['data' => $data]);
    }

    public function updateStatus(Request $request, $id)
    {
        $announcement = \App\Models\Announcement::findOrFail($id);
        $announcement->status = $request->status;
        $announcement->save();
        return response()->json(['success' => true]);
    }

    public function notifications()
    {
        $user = auth()->user();
        $role = $user->role;
        $announcements = \App\Models\Announcement::where('status', 'aktif')
            ->where(function($q) use ($role) {
                $q->where('role', $role)->orWhere('role', 'semua');
            })
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        return response()->json(['data' => $announcements]);
    }
}
