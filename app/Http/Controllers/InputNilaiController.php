<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\MataPelajaran;
use App\Models\TahunAjaran;
use App\Models\Semester;
use App\Models\KelasSiswa;
use App\Models\Nilai;

class InputNilaiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Pastikan user adalah guru
        if ($user->role !== 'guru') {
            return redirect('/')->with('error', 'Akses ditolak');
        }

        // Ambil data guru
        $guru = $user->guru;
        if (!$guru) {
            return redirect('/')->with('error', 'Data guru tidak ditemukan');
        }

        // Load relasi wali_kelas dengan eager loading
        $guru->load('wali_kelas.kelas');

        // Ambil tahun ajaran aktif
        $tahunAjaranAktif = TahunAjaran::where('aktif', 1)->first();
        
        // Ambil semua tahun ajaran untuk dropdown
        $tahunAjaran = TahunAjaran::all();
        
        // Ambil semester aktif
        $semesterAktif = Semester::where('status', 'aktif')->first();
        
        // Ambil semua semester untuk dropdown
        $semester = Semester::all();

        // Ambil wali_kelas berdasarkan guru_id, status aktif, dan tahun ajaran aktif
        $waliKelasAktif = \App\Models\WaliKelas::where('guru_id', $user->guru->id)
            ->where('status', 'aktif')
            ->where('tahun_ajaran_id', $tahunAjaranAktif ? $tahunAjaranAktif->id : null)
            ->with('kelas')
            ->first();
        $kelasGuru = $waliKelasAktif && $waliKelasAktif->kelas ? $waliKelasAktif->kelas : null;

        // Ambil siswa dari kelas tersebut
        $siswaWaliKelas = collect();
        if ($waliKelasAktif) {
            $siswaWaliKelas = \App\Models\KelasSiswa::where('kelas_id', $waliKelasAktif->kelas_id)
                ->with('siswa')
                ->get()
                ->pluck('siswa');
        }

        // Ambil semua mata pelajaran untuk dropdown
        $mataPelajaran = MataPelajaran::all();

        return view('content.apps.app-input-nilai', compact(
            'tahunAjaranAktif',
            'semesterAktif', 
            'mataPelajaran',
            'siswaWaliKelas',
            'tahunAjaran',
            'semester',
            'kelasGuru'
        ));
    }

    public function getSiswaByMataPelajaran(Request $request)
    {
        $mataPelajaranId = $request->mata_pelajaran_id;
        $guru = Auth::user()->guru;

        // Ambil siswa yang mengambil mata pelajaran ini
        $siswa = KelasSiswa::whereHas('kelas', function($query) use ($mataPelajaranId) {
            $query->whereHas('mataPelajaran', function($q) use ($mataPelajaranId) {
                $q->where('id', $mataPelajaranId);
            });
        })
        ->with('siswa')
        ->get()
        ->pluck('siswa');

        return response()->json($siswa);
    }

    public function store(Request $request)
    {
        $request->validate([
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'siswa_id' => 'required|exists:siswa,id',
            'nilai_tugas' => 'required|numeric|min:0|max:100',
            'nilai_uts' => 'required|numeric|min:0|max:100',
            'nilai_uas' => 'required|numeric|min:0|max:100',
        ]);

        // Hitung nilai akhir
        $nilaiAkhir = ($request->nilai_tugas * 0.3) + ($request->nilai_uts * 0.3) + ($request->nilai_uas * 0.4);
        // Logika capaian kompetensi
        if ($nilaiAkhir >= 90) {
            $capaian = 'A';
        } elseif ($nilaiAkhir >= 80) {
            $capaian = 'B';
        } elseif ($nilaiAkhir >= 70) {
            $capaian = 'C';
        } else {
            $capaian = 'D';
        }
        // Cek apakah nilai sudah ada
        $existingNilai = Nilai::where([
            'mata_pelajaran_id' => $request->mata_pelajaran_id,
            'siswa_id' => $request->siswa_id,
            'tahun_ajaran_id' => $request->tahun_ajaran_id,
            'semester_id' => $request->semester_id,
        ])->first();
        if ($existingNilai) {
            // Update nilai yang sudah ada
            $existingNilai->update([
                'nilai_tugas' => $request->nilai_tugas,
                'nilai_uts' => $request->nilai_uts,
                'nilai_uas' => $request->nilai_uas,
                'nilai_akhir' => $nilaiAkhir,
                'capaian_kompetensi' => $capaian,
            ]);
        } else {
            // Buat nilai baru
            Nilai::create([
                'mata_pelajaran_id' => $request->mata_pelajaran_id,
                'siswa_id' => $request->siswa_id,
                'tahun_ajaran_id' => $request->tahun_ajaran_id,
                'semester_id' => $request->semester_id,
                'nilai_tugas' => $request->nilai_tugas,
                'nilai_uts' => $request->nilai_uts,
                'nilai_uas' => $request->nilai_uas,
                'nilai_akhir' => $nilaiAkhir,
                'capaian_kompetensi' => $capaian,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Nilai berhasil disimpan'
        ]);
    }

    public function batchStore(Request $request)
    {
        $request->validate([
            'mapel_id' => 'required|exists:mata_pelajaran,id',
            'semester_id' => 'required|exists:semester,id',
            'nilai' => 'required|array',
            'nilai.*.kelas_siswa_id' => 'required|exists:kelas_siswa,id',
            'nilai.*.nilai_akhir' => 'required|numeric|min:0|max:100',
        ]);

        $user = Auth::user();
        $guru = $user->guru;
        $semesterId = $request->semester_id;
        $mapelId = $request->mapel_id;

        // Ambil wali_kelas_id aktif
        $waliKelasAktif = \App\Models\WaliKelas::where('guru_id', $guru->id)
            ->where('status', 'aktif')
            ->first();
        if (!$waliKelasAktif) {
            return response()->json(['success' => false, 'message' => 'Wali kelas aktif tidak ditemukan'], 422);
        }
        $waliKelasId = $waliKelasAktif->id;

        foreach ($request->nilai as $item) {
            $kelasSiswaId = $item['kelas_siswa_id'];
            $nilaiAkhir = $item['nilai_akhir'];
            // Logika capaian kompetensi batch
            if ($nilaiAkhir >= 90) {
                $capaian = 'A';
            } elseif ($nilaiAkhir >= 80) {
                $capaian = 'B';
            } elseif ($nilaiAkhir >= 70) {
                $capaian = 'C';
            } else {
                $capaian = 'D';
            }
            // Cek apakah nilai sudah ada
            $existingNilai = \App\Models\Nilai::where([
                'mapel_id' => $mapelId,
                'kelas_siswa_id' => $kelasSiswaId,
                'wali_kelas_id' => $waliKelasId,
                'semester_id' => $semesterId,
            ])->first();
            if ($existingNilai) {
                $existingNilai->update([
                    'nilai_akhir' => $nilaiAkhir,
                    'capaian_kompetensi' => $capaian,
                ]);
            } else {
                \App\Models\Nilai::create([
                    'mapel_id' => $mapelId,
                    'kelas_siswa_id' => $kelasSiswaId,
                    'wali_kelas_id' => $waliKelasId,
                    'semester_id' => $semesterId,
                    'nilai_akhir' => $nilaiAkhir,
                    'capaian_kompetensi' => $capaian,
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Semua nilai berhasil disimpan.'
        ]);
    }

    public function getNilaiByMapel(Request $request)
    {
        $request->validate([
            'mapel_id' => 'required|exists:mata_pelajaran,id',
            'semester_id' => 'required|exists:semester,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
        ]);

        $user = Auth::user();
        $guru = $user->guru;
        $waliKelasAktif = \App\Models\WaliKelas::where('guru_id', $guru->id)
            ->where('tahun_ajaran_id', $request->tahun_ajaran_id)
            ->where('status', 'aktif')
            ->first();
        if (!$waliKelasAktif) {
            return response()->json(['success' => false, 'message' => 'Wali kelas aktif tidak ditemukan'], 422);
        }
        $waliKelasId = $waliKelasAktif->id;

        $nilai = \App\Models\Nilai::where('mapel_id', $request->mapel_id)
            ->where('semester_id', $request->semester_id)
            ->where('wali_kelas_id', $waliKelasId)
            ->get(['kelas_siswa_id', 'nilai_akhir']);

        return response()->json([
            'success' => true,
            'data' => $nilai
        ]);
    }
    
    /**
     * Mendapatkan status pengisian nilai untuk semua mata pelajaran
     */
    public function getMapelStatus(Request $request)
    {
        $request->validate([
            'semester_id' => 'required|exists:semester,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
        ]);

        $user = Auth::user();
        $guru = $user->guru;
        
        // Ambil wali kelas aktif
        $waliKelasAktif = \App\Models\WaliKelas::where('guru_id', $guru->id)
            ->where('tahun_ajaran_id', $request->tahun_ajaran_id)
            ->where('status', 'aktif')
            ->first();
            
        if (!$waliKelasAktif) {
            return response()->json(['success' => false, 'message' => 'Wali kelas aktif tidak ditemukan'], 422);
        }
        
        $waliKelasId = $waliKelasAktif->id;
        $kelasId = $waliKelasAktif->kelas_id;
        
        // Ambil jumlah siswa di kelas
        $jumlahSiswa = \App\Models\KelasSiswa::where('kelas_id', $kelasId)->count();
        
        // Ambil semua mata pelajaran
        $mataPelajaran = \App\Models\MataPelajaran::all();
        
        $result = [];
        
        foreach ($mataPelajaran as $mapel) {
            // Hitung jumlah nilai yang sudah diinput untuk mata pelajaran ini
            $nilaiTerisi = \App\Models\Nilai::where('mapel_id', $mapel->id)
                ->where('semester_id', $request->semester_id)
                ->where('wali_kelas_id', $waliKelasId)
                ->count();
            
            $result[] = [
                'mapel_id' => $mapel->id,
                'nama_mapel' => $mapel->nama_mapel,
                'total_siswa' => $jumlahSiswa,
                'nilai_terisi' => $nilaiTerisi
            ];
        }
        
        return response()->json([
            'success' => true,
            'data' => $result
        ]);
    }
} 