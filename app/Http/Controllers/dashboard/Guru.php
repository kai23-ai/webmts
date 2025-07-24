<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\KelasSiswa;
use App\Models\WaliKelas;
use App\Models\TahunAjaran;
use Excel;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use App\Exports\LeggerExport;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class Guru extends Controller
{
  public function index()
  {
    $user = Auth::user();
    $guru = $user->guru;

    // Tahun ajaran aktif
    $tahunAjaran = TahunAjaran::where('aktif', 1)->first();
    $daftarSiswa = collect();
    $kelas = null;
    $waliKelas = null;
    if ($tahunAjaran && $guru) {
      $waliKelas = WaliKelas::where('guru_id', $guru->id)
        ->where('tahun_ajaran_id', $tahunAjaran->id)
        ->where('status', 'aktif')
        ->with('tahunAjaran')
        ->first();
      if ($waliKelas) {
        $kelas = $waliKelas->kelas;
        $daftarSiswa = KelasSiswa::with('siswa')
          ->where('kelas_id', $waliKelas->kelas_id)
          ->where('tahun_ajaran_id', $tahunAjaran->id)
          ->where('status', 'aktif')
          ->get();
      }
    }
    return view('content.dashboard.dashboards-guru', compact('guru', 'daftarSiswa', 'kelas', 'waliKelas'));
  }

  public function history()
  {
    $user = Auth::user();
    $guru = $user->guru;

    // Tahun ajaran aktif
    $tahunAjaran = TahunAjaran::where('aktif', 1)->first();
    $daftarSiswa = collect();
    $kelas = null;
    $waliKelas = null;
    if ($tahunAjaran && $guru) {
      $waliKelas = WaliKelas::where('guru_id', $guru->id)
        ->where('tahun_ajaran_id', $tahunAjaran->id)
        ->where('status', 'aktif')
        ->with('tahunAjaran')
        ->first();
      if ($waliKelas) {
        $kelas = $waliKelas->kelas;
        $daftarSiswa = KelasSiswa::with('siswa')
          ->where('kelas_id', $waliKelas->kelas_id)
          ->where('tahun_ajaran_id', $tahunAjaran->id)
          ->where('status', 'aktif')
          ->get();
      }
    }
    // Riwayat kelas sebelumnya (status != aktif)
    $riwayatKelas = WaliKelas::where('guru_id', $guru->id)
      ->where('status', '!=', 'aktif')
      ->with(['kelas', 'tahunAjaran'])
      ->orderByDesc('tahun_ajaran_id')
      ->get();
    return view('content.dashboard.history-guru', compact('guru', 'daftarSiswa', 'kelas', 'waliKelas', 'riwayatKelas'));
  }

  public function exportLegger(Request $request)
  {
      $user = Auth::user();
      $guru = $user->guru;
      $tahunAjaran = \App\Models\TahunAjaran::where('aktif', 1)->first();
      $waliKelas = null;
      $kelas = null;
      if ($tahunAjaran && $guru) {
          $waliKelas = \App\Models\WaliKelas::where('guru_id', $guru->id)
              ->where('tahun_ajaran_id', $tahunAjaran->id)
              ->where('status', 'aktif')
              ->with('tahunAjaran')
              ->first();
          if ($waliKelas) {
              $kelas = $waliKelas->kelas;
          }
      }
      if (!$kelas) {
          return back()->with('error', 'Kelas aktif tidak ditemukan');
      }
      $daftarSiswa = \App\Models\KelasSiswa::with('siswa')
          ->where('kelas_id', $waliKelas->kelas_id)
          ->where('tahun_ajaran_id', $tahunAjaran->id)
          ->where('status', 'aktif')
          ->get();
      // Ambil list mapel dari database
      $mapelList = \App\Models\MataPelajaran::orderBy('urutan')->get();
      $header = ['No', 'NIS', 'Nisn', 'Nama', 'JK'];
      $header = array_merge($header, $mapelList->pluck('kode_mapel')->toArray(), ['Jumlah']);
      // Ambil semester aktif
      $semester = \App\Models\Semester::where('status', 'aktif')->first();
      $semesterId = $semester ? $semester->id : null;
      $data = [];
      foreach ($daftarSiswa as $i => $ks) {
          \Log::info('Siswa:', ['kelas_siswa_id' => $ks->id, 'nama' => $ks->siswa->nama ?? '', 'siswa_id' => $ks->siswa_id]);
          $row = [
              $i+1,
              $ks->siswa->nis ?? '',
              $ks->siswa->nisn ?? '',
              $ks->siswa->nama ?? '',
              $ks->siswa->jenis_kelamin ?? '',
          ];
          $nilaiMapel = [];
          $totalNilai = 0; // Hitung total di database
          foreach ($mapelList as $mapel) {
              \Log::info('Cek nilai', [
                  'kelas_siswa_id' => $ks->id,
                  'mapel_id' => $mapel->id,
                  'semester_id' => $semesterId
              ]);
              $nilai = \App\Models\Nilai::where('kelas_siswa_id', $ks->id)
                  ->where('mapel_id', $mapel->id)
                  ->when($semesterId, function($q) use ($semesterId) {
                      $q->where('semester_id', $semesterId);
                  })
                  ->value('nilai_akhir');
              // Jika nilai null, jadikan 0
              $nilaiInt = ($nilai === null || $nilai === '') ? 0 : (int)$nilai;
              $nilaiMapel[] = $nilaiInt;
              $totalNilai += $nilaiInt; // Tambahkan ke total
          }
          $row = array_merge($row, $nilaiMapel);
          $row[] = $totalNilai; // Langsung tampilkan total yang sudah dihitung
          $data[] = $row;
      }
      \Log::info('Jumlah data siswa untuk export:', ['count' => count($data)]);
      \Log::info('Contoh baris data:', $data[0] ?? []);
      $filename = 'legger_nilai_' . ($kelas->nama_kelas ?? 'kelas') . '.xlsx';
      return \Excel::download(new \App\Exports\LeggerExport($data, $header, $kelas, $tahunAjaran, $semester ? $semester->nama : ''), $filename);
  }
} 