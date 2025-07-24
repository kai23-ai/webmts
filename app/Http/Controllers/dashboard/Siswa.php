<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\KelasSiswa;
use App\Models\TahunAjaran;
use App\Models\Nilai;
use App\Models\MataPelajaran;
use App\Models\Semester;

class Siswa extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $siswa = $user->siswa;
        
        // Tahun ajaran aktif
        $tahunAjaran = TahunAjaran::where('aktif', 1)->first();
        $kelasSiswa = null;
        $kelas = null;
        $waliKelas = null;
        $nilaiSiswa = collect();
        
        if ($tahunAjaran && $siswa) {
            $kelasSiswa = KelasSiswa::where('siswa_id', $siswa->id)
                ->where('tahun_ajaran_id', $tahunAjaran->id)
                ->where('status', 'aktif')
                ->with(['kelas', 'tahunAjaran'])
                ->first();
                
            if ($kelasSiswa) {
                $kelas = $kelasSiswa->kelas;
                $waliKelas = $kelas->waliKelas()
                    ->where('tahun_ajaran_id', $tahunAjaran->id)
                    ->where('status', 'aktif')
                    ->with('guru')
                    ->first();
                    
                // Get semester aktif
                $semester = Semester::where('status', 'aktif')->first();
                
                if ($semester) {
                    // Get nilai siswa
                    $nilaiSiswa = Nilai::where('kelas_siswa_id', $kelasSiswa->id)
                        ->where('semester_id', $semester->id)
                        ->with('mapel')
                        ->get();
                }
            }
        }
        
        // Get all mata pelajaran for comparison
        $mataPelajaran = MataPelajaran::orderBy('urutan')->get();
        
        return view('content.dashboard.dashboards-siswa', compact(
            'siswa', 
            'kelasSiswa', 
            'kelas', 
            'waliKelas', 
            'nilaiSiswa', 
            'mataPelajaran',
            'tahunAjaran'
        ));
    }
    
    public function history()
    {
        $user = Auth::user();
        $siswa = $user->siswa;
        
        // Tahun ajaran aktif
        $tahunAjaran = TahunAjaran::where('aktif', 1)->first();
        $kelasSiswa = null;
        $kelas = null;
        
        if ($tahunAjaran && $siswa) {
            $kelasSiswa = KelasSiswa::where('siswa_id', $siswa->id)
                ->where('tahun_ajaran_id', $tahunAjaran->id)
                ->where('status', 'aktif')
                ->with(['kelas', 'tahunAjaran'])
                ->first();
                
            if ($kelasSiswa) {
                $kelas = $kelasSiswa->kelas;
            }
        }
        
        // Riwayat kelas sebelumnya (status != aktif)
        $riwayatKelas = KelasSiswa::where('siswa_id', $siswa->id)
            ->where('status', '!=', 'aktif')
            ->with(['kelas', 'tahunAjaran'])
            ->orderByDesc('tahun_ajaran_id')
            ->get();
            
        return view('content.dashboard.history-siswa', compact(
            'siswa', 
            'kelasSiswa', 
            'kelas', 
            'riwayatKelas'
        ));
    }
}