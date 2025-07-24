<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use App\Models\Semester;
use App\Models\Kelas;
use App\Models\KelasSiswa;
use App\Models\WaliKelas;
use App\Models\Nilai;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RankingController extends Controller
{
    public function index()
    {
        // Get current academic year and semester
        $tahunAjaranAktif = TahunAjaran::where('aktif', true)->first();
        $semesterAktif = Semester::where('status', 'aktif')->first();
        
        if (!$tahunAjaranAktif) {
            return redirect()->back()->with('error', 'Tidak ada tahun ajaran aktif');
        }
        
        if (!$semesterAktif) {
            return redirect()->back()->with('error', 'Tidak ada semester aktif');
        }

        // Get current user's class if they are a homeroom teacher
        $guru = Auth::user()->guru;
        $kelasGuru = null;
        $waliKelas = null;
        $siswa = collect();

        if ($guru) {
            // Get the class where this teacher is the homeroom teacher
            $waliKelas = \App\Models\WaliKelas::where('guru_id', $guru->id)
                ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
                ->with('kelas')
                ->first();

            if ($waliKelas) {
                $kelasGuru = $waliKelas->kelas;
                
                // Get students in this class with their kelas_siswa relationship
                $kelasSiswaList = KelasSiswa::where('kelas_id', $kelasGuru->id)
                    ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
                    ->with('siswa')
                    ->get();
                
                $siswa = $kelasSiswaList->map(function($kelasSiswa) use ($tahunAjaranAktif, $semesterAktif) {
                    $siswaData = $kelasSiswa->siswa;
                    
                    // Calculate average score for this student through kelas_siswa relationship for current semester
                    $averageScore = Nilai::where('kelas_siswa_id', $kelasSiswa->id)
                        ->where('semester_id', $semesterAktif->id)
                        ->avg('nilai_akhir');
                    
                    $siswaData->rata_rata = $averageScore ? round($averageScore, 2) : 0;
                    $siswaData->kelas_siswa_id = $kelasSiswa->id; // Store kelas_siswa ID for ranking
                    
                    return $siswaData;
                })
                ->sortByDesc('rata_rata');
            }
        }

        // If no class assigned, check if user is student or admin
        if ($siswa->isEmpty()) {
            if (Auth::user()->role === 'siswa') {
                // For students, get their classmates
                $currentSiswa = Auth::user()->siswa;
                if ($currentSiswa) {
                    $kelasSiswaList = KelasSiswa::where('tahun_ajaran_id', $tahunAjaranAktif->id)
                        ->whereHas('siswa', function($query) use ($currentSiswa) {
                            $query->where('id', $currentSiswa->id);
                        })
                        ->first();
                    
                    if ($kelasSiswaList) {
                        $kelasGuru = $kelasSiswaList->kelas;
                        
                        // Get all students in the same class
                        $kelasSiswaList = KelasSiswa::where('kelas_id', $kelasGuru->id)
                            ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
                            ->with('siswa')
                            ->get();
                        
                        $siswa = $kelasSiswaList->map(function($kelasSiswa) use ($tahunAjaranAktif, $semesterAktif) {
                            $siswaData = $kelasSiswa->siswa;
                            
                            // Calculate average score for this student through kelas_siswa relationship for current semester
                            $averageScore = Nilai::where('kelas_siswa_id', $kelasSiswa->id)
                                ->where('semester_id', $semesterAktif->id)
                                ->avg('nilai_akhir');
                            
                            $siswaData->rata_rata = $averageScore ? round($averageScore, 2) : 0;
                            $siswaData->kelas_siswa_id = $kelasSiswa->id;
                            
                            return $siswaData;
                        })
                        ->sortByDesc('rata_rata');
                    }
                }
            } elseif (Auth::user()->role === 'admin') {
                // For admin, get all students
                $kelasSiswaList = KelasSiswa::where('tahun_ajaran_id', $tahunAjaranAktif->id)
                    ->with(['siswa', 'kelas'])
                    ->get();
                    
                $siswa = $kelasSiswaList->map(function($kelasSiswa) use ($tahunAjaranAktif, $semesterAktif) {
                    $siswaData = $kelasSiswa->siswa;
                    
                    // Calculate average score for this student through kelas_siswa relationship for current semester
                    $averageScore = Nilai::where('kelas_siswa_id', $kelasSiswa->id)
                        ->where('semester_id', $semesterAktif->id)
                        ->avg('nilai_akhir');
                    
                    $siswaData->rata_rata = $averageScore ? round($averageScore, 2) : 0;
                    $siswaData->kelas_siswa_id = $kelasSiswa->id;
                    $siswaData->kelas_nama = $kelasSiswa->kelas->nama_kelas;
                    
                    return $siswaData;
                })
                ->sortByDesc('rata_rata');
            }
        }

        // Determine view based on user role
        $userRole = Auth::user()->role;
        $viewName = $userRole === 'siswa' ? 'content.apps.app-ranking-siswa' : 'content.apps.app-ranking';
        
        return view($viewName, compact(
            'siswa',
            'tahunAjaranAktif',
            'semesterAktif',
            'kelasGuru',
            'waliKelas',
            'userRole'
        ));
    }

    public function saveRanking(Request $request)
    {
        $request->validate([
            'ranking_data' => 'required|array',
            'ranking_data.*.kelas_siswa_id' => 'required|exists:kelas_siswa,id',
            'ranking_data.*.position' => 'required|integer|min:1',
            'ranking_data.*.score' => 'nullable|numeric'
        ]);

        $tahunAjaranAktif = TahunAjaran::where('aktif', true)->first();
        $semesterAktif = Semester::where('status', 'aktif')->first();
        
        if (!$tahunAjaranAktif) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada tahun ajaran aktif'
            ], 400);
        }
        
        if (!$semesterAktif) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada semester aktif'
            ], 400);
        }

        try {
            DB::beginTransaction();

            // Get current user's wali kelas data
            $guru = Auth::user()->guru;
            $waliKelas = null;

            if ($guru) {
                $waliKelas = \App\Models\WaliKelas::where('guru_id', $guru->id)
                    ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
                    ->first();
                
                if (!$waliKelas) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Anda tidak memiliki kelas yang diampu pada tahun ajaran ini'
                    ], 403);
                }
            }

            // Clear existing rankings for this wali kelas/year/semester
            if ($waliKelas) {
                DB::table('ranking_siswa')
                    ->where('wali_kelas_id', $waliKelas->id)
                    ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
                    ->where('semester_id', $semesterAktif->id)
                    ->delete();
            }

            // Save new rankings
            foreach ($request->ranking_data as $ranking) {
                // Verify that the kelas_siswa belongs to the current wali kelas
                $kelasSiswa = KelasSiswa::where('id', $ranking['kelas_siswa_id'])
                    ->where('kelas_id', $waliKelas->kelas_id)
                    ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
                    ->first();

                if (!$kelasSiswa) {
                    throw new \Exception('Siswa tidak ditemukan dalam kelas yang Anda ampu');
                }

                DB::table('ranking_siswa')->insert([
                    'kelas_siswa_id' => $ranking['kelas_siswa_id'],
                    'wali_kelas_id' => $waliKelas->id,
                    'tahun_ajaran_id' => $tahunAjaranAktif->id,
                    'semester_id' => $semesterAktif->id,
                    'posisi' => $ranking['position'],
                    'nilai_rata_rata' => $ranking['score'] ?? 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Peringkat siswa berhasil disimpan'
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan peringkat: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getRanking(Request $request)
    {
        $tahunAjaranAktif = TahunAjaran::where('aktif', true)->first();
        $semesterAktif = Semester::where('status', 'aktif')->first();
        
        if (!$tahunAjaranAktif) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada tahun ajaran aktif'
            ], 400);
        }
        
        if (!$semesterAktif) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada semester aktif'
            ], 400);
        }

        $user = Auth::user();
        $waliKelasId = null;
        $kelasId = null;

        if ($user->role === 'guru' && $user->guru) {
            // For teachers, get their wali kelas
            $waliKelas = \App\Models\WaliKelas::where('guru_id', $user->guru->id)
                ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
                ->first();
            
            if ($waliKelas) {
                $waliKelasId = $waliKelas->id;
            }
        } elseif ($user->role === 'siswa' && $user->siswa) {
            // For students, get their class
            $kelasSiswa = KelasSiswa::where('siswa_id', $user->siswa->id)
                ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
                ->first();
            
            if ($kelasSiswa) {
                $kelasId = $kelasSiswa->kelas_id;
            }
        }

        $query = DB::table('ranking_siswa')
            ->join('kelas_siswa', 'ranking_siswa.kelas_siswa_id', '=', 'kelas_siswa.id')
            ->join('siswa', 'kelas_siswa.siswa_id', '=', 'siswa.id')
            ->join('wali_kelas', 'ranking_siswa.wali_kelas_id', '=', 'wali_kelas.id')
            ->join('kelas', 'wali_kelas.kelas_id', '=', 'kelas.id')
            ->where('ranking_siswa.tahun_ajaran_id', $tahunAjaranAktif->id)
            ->where('ranking_siswa.semester_id', $semesterAktif->id);

        // Filter based on user role
        if ($waliKelasId) {
            $query->where('ranking_siswa.wali_kelas_id', $waliKelasId);
        } elseif ($kelasId) {
            $query->where('kelas.id', $kelasId);
        }

        $rankings = $query->orderBy('ranking_siswa.posisi')
            ->select(
                'ranking_siswa.*',
                'siswa.id as siswa_id',
                'siswa.nama',
                'siswa.nis',
                'siswa.foto',
                'siswa.jenis_kelamin',
                'kelas.nama_kelas',
                'kelas_siswa.id as kelas_siswa_id'
            )
            ->get();

        return response()->json([
            'success' => true,
            'data' => $rankings
        ]);
    }
}